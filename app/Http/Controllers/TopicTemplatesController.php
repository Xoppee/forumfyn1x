<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;

class TopicTemplatesController extends Controller
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

    public function index(): JsonResponse
    {
        $templates = array_map(function ($template) {
            return [
                'id' => $template['id'],
                'name' => $template['name'],
                'description' => $template['description'],
                'icon' => $template['icon'] ?? 'file-text',
            ];
        }, $this->templates);

        return response()->json(['templates' => $templates]);
    }

    public function show(string $id): JsonResponse
    {
        $template = collect($this->templates)->firstWhere('id', $id);

        if (!$template) {
            return response()->json(['error' => 'Template não encontrado.'], 404);
        }

        return response()->json(['template' => $template]);
    }

    public function fields(string $id): JsonResponse
    {
        $template = collect($this->templates)->firstWhere('id', $id);

        if (!$template) {
            return response()->json(['error' => 'Template não encontrado.'], 404);
        }

        return response()->json(['fields' => $template['fields'] ?? []]);
    }

    public function update(Request $request): JsonResponse
    {
        if (!auth()->user()->hasRole('admin')) {
            return response()->json(['error' => 'Apenas administradores podem editar templates.'], 403);
        }

        $validated = $request->validate([
            'templates' => 'required|array',
            'templates.*.id' => 'required|string',
            'templates.*.name' => 'required|string',
            'templates.*.description' => 'nullable|string',
            'templates.*.icon' => 'nullable|string',
            'templates.*.fields' => 'nullable|array',
            'templates.*.defaultGroup' => 'nullable|string',
        ]);

        $jsonPath = resource_path('json/topics_templates.json');
        
        File::put($jsonPath, json_encode(['templates' => $validated['templates']], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        $this->templates = $validated['templates'];

        return response()->json(['success' => true, 'message' => 'Templates atualizados.']);
    }

    public function add(Request $request): JsonResponse
    {
        if (!auth()->user()->hasRole('admin')) {
            return response()->json(['error' => 'Apenas administradores podem adicionar templates.'], 403);
        }

        $validated = $request->validate([
            'id' => 'required|string|unique:templates',
            'name' => 'required|string',
            'description' => 'nullable|string',
            'icon' => 'nullable|string',
            'fields' => 'nullable|array',
            'defaultGroup' => 'nullable|string',
        ]);

        $this->templates[] = $validated;

        $jsonPath = resource_path('json/topics_templates.json');
        File::put($jsonPath, json_encode(['templates' => $this->templates], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return response()->json(['success' => true, 'template' => $validated], 201);
    }
}