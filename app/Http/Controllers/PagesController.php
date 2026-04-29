<?php

namespace App\Http\Controllers;

use App\Models\Pages;
use App\Http\Requests\StorePageRequest;
use App\Http\Requests\UpdatePageRequest;

class PagesController extends Controller
{
    public function index()
    {
        $pages = Pages::orderBy('index')->get();
        return view('pages.index', compact('pages'));
    }

    public function show($slug)
    {
        $page = Pages::where('slug', $slug)->where('is_published', true)->firstOrFail();
        return view('pages.show', compact('page'));
    }

    public function create()
    {
        return view('pages.create');
    }

    public function store(StorePageRequest $request)
    {
        $page = Pages::create($request->only(['title', 'slug', 'icon', 'content', 'is_published', 'index']));

        return redirect()->route('admin')->with('success', 'Página criada com sucesso.');
    }

    public function edit(Pages $page)
    {
        return view('pages.edit', compact('page'));
    }

    public function update(UpdatePageRequest $request, Pages $page)
    {
        $page->update($request->only(['title', 'slug', 'icon', 'content', 'is_published']));

        return redirect()->route('admin')->with('success', 'Página atualizada com sucesso.');
    }

    public function destroy(Pages $page)
    {
        $page->delete();
        return redirect()->route('admin')->with('success', 'Página removida.');
    }
}