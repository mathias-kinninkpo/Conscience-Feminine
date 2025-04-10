<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AnnouncementController extends Controller
{
    /**
     * Affiche la liste des annonces
     */
    public function index()
    {
        $announcements = Announcement::latest()->paginate(10);
        
        return view('admin.announcements.index', compact('announcements'));
    }

    /**
     * Affiche le formulaire de création d'annonce
     */
    public function create()
    {
        return view('admin.announcements.create');
    }

    /**
     * Enregistre une nouvelle annonce
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'published_at' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('announcements', 'public');
        }

        Announcement::create([
            'title' => $request->title,
            'description' => $request->description,
            'published_at' => $request->published_at ?? now(),
            'image' => $imagePath,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Annonce créée avec succès.');
    }

    /**
     * Affiche les détails d'une annonce
     */
    public function show($id)
    {
        $announcement = Announcement::findOrFail($id);
        
        return view('admin.announcements.show', compact('announcement'));
    }

    /**
     * Affiche le formulaire de modification d'une annonce
     */
    public function edit($id)
    {
        $announcement = Announcement::findOrFail($id);
        
        return view('admin.announcements.edit', compact('announcement'));
    }

    /**
     * Met à jour une annonce
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'published_at' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $announcement = Announcement::findOrFail($id);

        // Traitement de l'image
        if ($request->hasFile('image')) {
            // Supprime l'ancienne image si elle existe
            if ($announcement->image) {
                Storage::disk('public')->delete($announcement->image);
            }
            $imagePath = $request->file('image')->store('announcements', 'public');
            $announcement->image = $imagePath;
        }

        $announcement->title = $request->title;
        $announcement->description = $request->description;
        $announcement->published_at = $request->published_at ?? $announcement->published_at;
        $announcement->save();

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Annonce mise à jour avec succès.');
    }

    /**
     * Supprime une annonce
     */
    public function destroy($id)
    {
        $announcement = Announcement::findOrFail($id);
        
        // Supprime l'image associée si elle existe
        if ($announcement->image) {
            Storage::disk('public')->delete($announcement->image);
        }
        
        $announcement->delete();

        return redirect()->route('admin.announcements.index')
            ->with('success', 'Annonce supprimée avec succès.');
    }
}