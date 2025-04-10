<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PageController extends Controller
{
    /**
     * Affiche la liste des pages
     */
    public function index()
    {
        $pages = Page::paginate(10);
        
        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Affiche le formulaire de création de page
     */
    public function create()
    {
        return view('admin.pages.create');
    }

    /**
     * Enregistre une nouvelle page
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'slug' => 'nullable|string|max:255|unique:pages,slug',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $slug = $request->slug ?? Str::slug($request->title);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('pages', 'public');
        }

        Page::create([
            'title' => $request->title,
            'content' => $request->content,
            'slug' => $slug,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page créée avec succès.');
    }

    /**
     * Affiche le formulaire de modification d'une page
     */
    public function edit($id)
    {
        $page = Page::findOrFail($id);
        
        return view('admin.pages.edit', compact('page'));
    }

    /**
     * Met à jour une page
     */
    public function update(Request $request, $id)
    {
        $page = Page::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'slug' => 'nullable|string|max:255|unique:pages,slug,' . $page->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $slug = $request->slug ?? Str::slug($request->title);

        // Traitement de l'image
        if ($request->hasFile('image')) {
            // Supprime l'ancienne image si elle existe
            if ($page->image) {
                Storage::disk('public')->delete($page->image);
            }
            $imagePath = $request->file('image')->store('pages', 'public');
            $page->image = $imagePath;
        }

        $page->title = $request->title;
        $page->content = $request->content;
        $page->slug = $slug;
        $page->save();

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page mise à jour avec succès.');
    }

    /**
     * Supprime une page
     */
    public function destroy($id)
    {
        $page = Page::findOrFail($id);
        
        // Supprime l'image associée si elle existe
        if ($page->image) {
            Storage::disk('public')->delete($page->image);
        }
        
        $page->delete();

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page supprimée avec succès.');
    }
}