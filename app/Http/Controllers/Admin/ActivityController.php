<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ActivityController extends Controller
{
    /**
     * Affiche la liste des activités
     */
    public function index()
    {
        $activities = Activity::latest()->paginate(10);
        
        return view('admin.activities.index', compact('activities'));
    }

    /**
     * Affiche le formulaire de création d'activité
     */
    public function create()
    {
        return view('admin.activities.create');
    }

    /**
     * Enregistre une nouvelle activité
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'activity_date' => 'required|date',
            'location' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('activities', 'public');
        }

        Activity::create([
            'title' => $request->title,
            'description' => $request->description,
            'activity_date' => $request->activity_date,
            'location' => $request->location,
            'image' => $imagePath,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('admin.activities.index')
            ->with('success', 'Activité créée avec succès.');
    }

    /**
     * Affiche les détails d'une activité
     */
    public function show($id)
    {
        $activity = Activity::findOrFail($id);
        
        return view('admin.activities.show', compact('activity'));
    }

    /**
     * Affiche le formulaire de modification d'une activité
     */
    public function edit($id)
    {
        $activity = Activity::findOrFail($id);
        
        return view('admin.activities.edit', compact('activity'));
    }

    /**
     * Met à jour une activité
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'activity_date' => 'required|date',
            'location' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $activity = Activity::findOrFail($id);

        // Traitement de l'image
        if ($request->hasFile('image')) {
            // Supprime l'ancienne image si elle existe
            if ($activity->image) {
                Storage::disk('public')->delete($activity->image);
            }
            $imagePath = $request->file('image')->store('activities', 'public');
            $activity->image = $imagePath;
        }

        $activity->title = $request->title;
        $activity->description = $request->description;
        $activity->activity_date = $request->activity_date;
        $activity->location = $request->location;
        $activity->save();

        return redirect()->route('admin.activities.index')
            ->with('success', 'Activité mise à jour avec succès.');
    }

    /**
     * Supprime une activité
     */
    public function destroy($id)
    {
        $activity = Activity::findOrFail($id);
        
        // Supprime l'image associée si elle existe
        if ($activity->image) {
            Storage::disk('public')->delete($activity->image);
        }
        
        $activity->delete();

        return redirect()->route('admin.activities.index')
            ->with('success', 'Activité supprimée avec succès.');
    }
}