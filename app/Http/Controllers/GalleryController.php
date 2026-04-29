<?php

namespace App\Http\Controllers;

use App\Models\Image as ImageModel;
use App\Models\GalleryFolder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;

class GalleryController extends Controller
{
    protected $imageManager;

    public function __construct()
    {
        $this->imageManager = ImageManager::usingDriver(\Intervention\Image\Drivers\Gd\Driver::class);
    }

    public function index(Request $request)
    {
        $folders = GalleryFolder::where('user_id', auth()->id())
            ->orWhere('is_public', true)
            ->orderBy('name')
            ->get();
            
        return view('gallery.index', compact('folders'));
    }

    public function folder(GalleryFolder $folder)
    {
        $images = $folder->images()->orderByDesc('created_at')->paginate(30);
        return view('gallery.folder', compact('folder', 'images'));
    }

    public function createFolder(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_public' => 'boolean',
        ]);

        $folder = GalleryFolder::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'user_id' => auth()->id(),
            'is_public' => $request->is_public ?? true,
        ]);

        return back()->with('success', 'Pasta criada!');
    }

    public function upload(Request $request, GalleryFolder $folder)
    {
        $request->validate([
            'images.*' => 'required|image|max:10240',
        ]);

        $uploaded = [];

        // Ensure gallery directory exists
        $galleryPath = storage_path('app/public/gallery');
        if (!file_exists($galleryPath)) {
            mkdir($galleryPath, 0755, true);
        }

        $files = $request->file('images');

        if (!is_array($files)) {
            $files = [$files];
        }

        foreach ($files as $file) {
            $filename = Str::uuid() . '.webp';
            $path = 'gallery/' . $filename;

            // Convert to WebP
            $image = $this->imageManager->decodePath($file->getPathname());
            $encoded = $image->encodeUsingFormat(\Intervention\Image\Format::WEBP, quality: 85);
            $encoded->save(storage_path('app/public/' . $path));
            
            $imageRecord = ImageModel::create([
                'path' => $path,
                'alt_text' => $file->getClientOriginalName(),
                'imageable_id' => $folder->id,
                'imageable_type' => GalleryFolder::class,
                'mime_type' => 'image/webp',
            ]);
            
            $uploaded[] = $imageRecord;
        }

        return back()->with('success', count($uploaded) . ' imagem(ns) carregada(s)!');
    }

    public function deleteFolder(GalleryFolder $folder)
    {
        if ($folder->user_id !== auth()->id()) {
            return back()->with('error', 'Não autorizado.');
        }

        foreach ($folder->images as $image) {
            \Storage::disk('public')->delete($image->path);
            $image->delete();
        }

        $folder->delete();
        return redirect('/gallery')->with('success', 'Pasta deletada.');
    }

    public function deleteImage(ImageModel $image)
    {
        if ($image->user_id !== auth()->id()) {
            return back()->with('error', 'Não autorizado.');
        }

        \Storage::disk('public')->delete($image->path);
        $image->delete();
        
        return back()->with('success', 'Imagem deletada.');
    }

    public function apiIndex(Request $request)
    {
        $query = ImageModel::query();
        
        if ($request->has('folder_id')) {
            $query->where('folder_id', $request->folder_id);
        }
        
        $images = $query->orderByDesc('created_at')->paginate(30);
        return response()->json($images);
    }

    public function apiUpload(Request $request)
    {
        $request->validate([
            'images.*' => 'required|image|max:10240',
            'folder_id' => 'nullable|uuid',
        ]);

        $uploaded = [];
        
        foreach ($request->file('images') as $file) {
            $filename = Str::uuid() . '.webp';
            $path = $file->storeAs('gallery', $filename, 'public');
            
            $image = ImageModel::create([
                'path' => $path,
                'alt_text' => $file->getClientOriginalName(),
                'folder_id' => $request->folder_id,
                'user_id' => auth()->id(),
                'size' => $file->getSize(),
                'mime_type' => 'image/webp',
            ]);
            
            $uploaded[] = $image;
        }

        return response()->json(['success' => true, 'images' => $uploaded]);
    }
}