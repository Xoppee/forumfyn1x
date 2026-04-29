<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BlogController extends Controller
{
    protected array $templates = [];

    public function __construct()
    {
        $jsonPath = resource_path('json/topics_templates.json');
        
        if (File::exists($jsonPath)) {
            $data = json_decode(File::get($jsonPath), true);
            $this->templates = $data['templates'] ?? [];
        }
    }

    public function index()
    {
        $posts = BlogPost::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('blog.index', compact('posts'));
    }

    public function create()
    {
        $templates = $this->templates;

        return view('blog.create', compact('templates'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'template_id' => 'required|string',
            'title' => 'required|string|max:255',
            'content' => 'required|string|min:50',
            'summary' => 'nullable|string|max:300',
        ]);

        $metaFields = [];
        $template = collect($this->templates)->firstWhere('id', $request->template_id);

        if ($template && isset($template['fields'])) {
            foreach ($template['fields'] as $fieldName => $fieldConfig) {
                if ($request->has($fieldName)) {
                    $metaFields[$fieldName] = $request->input($fieldName);
                }
            }
        }

        $post = BlogPost::create([
            'id' => \Illuminate\Support\Str::uuid(),
            'user_id' => auth()->id(),
            'template_id' => $request->template_id,
            'title' => $request->title,
            'slug' => \Illuminate\Support\Str::slug($request->title),
            'content' => $request->content,
            'summary' => $request->summary,
            'meta_fields' => $metaFields,
            'is_published' => $request->has('is_published'),
        ]);

        return redirect()->route('blog.show', $post->slug)->with('success', 'Post criado com sucesso!');
    }

    public function show($slug)
    {
        $post = BlogPost::where('slug', $slug)->where('is_published', true)->firstOrFail();

        return view('blog.show', compact('post'));
    }

    public function edit($slug)
    {
        $post = BlogPost::where('slug', $slug)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $templates = $this->templates;
        $template = collect($this->templates)->firstWhere('id', $post->template_id);

        return view('blog.edit', compact('post', 'templates', 'template'));
    }

    public function update(Request $request, $slug)
    {
        $post = BlogPost::where('slug', $slug)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|min:50',
            'summary' => 'nullable|string|max:300',
        ]);

        $metaFields = [];
        $template = collect($this->templates)->firstWhere('id', $post->template_id);

        if ($template && isset($template['fields'])) {
            foreach ($template['fields'] as $fieldName => $fieldConfig) {
                if ($request->has($fieldName)) {
                    $metaFields[$fieldName] = $request->input($fieldName);
                }
            }
        }

        $post->update([
            'title' => $request->title,
            'slug' => \Illuminate\Support\Str::slug($request->title),
            'content' => $request->content,
            'summary' => $request->summary,
            'meta_fields' => $metaFields,
            'is_published' => $request->has('is_published'),
        ]);

        return redirect()->route('blog.show', $post->slug)->with('success', 'Post atualizado com sucesso!');
    }

    public function destroy($slug)
    {
        $post = BlogPost::where('slug', $slug)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $post->delete();

        return redirect()->route('blog.index')->with('success', 'Post removido com sucesso!');
    }
}
