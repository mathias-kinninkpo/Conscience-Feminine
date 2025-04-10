<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TeamMemberController extends Controller
{
    /**
     * Affiche la liste des membres de l'équipe
     */
    public function index()
    {
        $teamMembers = TeamMember::paginate(10);
        
        return view('admin.team.index', compact('teamMembers'));
    }

    /**
     * Affiche le formulaire de création de membre d'équipe
     */
    public function create()
    {
        return view('admin.team.create');
    }

    /**
     * Enregistre un nouveau membre d'équipe
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('team', 'public');
        }

        TeamMember::create([
            'name' => $request->name,
            'role' => $request->role,
            'bio' => $request->bio,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.team.index')
            ->with('success', 'Membre d\'équipe ajouté avec succès.');
    }

    /**
     * Affiche le formulaire de modification d'un membre d'équipe
     */
    public function edit($id)
    {
        $teamMember = TeamMember::findOrFail($id);
        
        return view('admin.team.edit', compact('teamMember'));
    }

    /**
     * Met à jour un membre d'équipe
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $teamMember = TeamMember::findOrFail($id);

        // Traitement de l'image
        if ($request->hasFile('image')) {
            // Supprime l'ancienne image si elle existe
            if ($teamMember->image) {
                Storage::disk('public')->delete($teamMember->image);
            }
            $imagePath = $request->file('image')->store('team', 'public');
            $teamMember->image = $imagePath;
        }

        $teamMember->name = $request->name;
        $teamMember->role = $request->role;
        $teamMember->bio = $request->bio;
        $teamMember->save();

        return redirect()->route('admin.team.index')
            ->with('success', 'Membre d\'équipe mis à jour avec succès.');
    }

    /**
     * Supprime un membre d'équipe
     */
    public function destroy($id)
    {
        $teamMember = TeamMember::findOrFail($id);
        
        // Supprime l'image associée si elle existe
        if ($teamMember->image) {
            Storage::disk('public')->delete($teamMember->image);
        }
        
        $teamMember->delete();

        return redirect()->route('admin.team.index')
            ->with('success', 'Membre d\'équipe supprimé avec succès.');
    }

    /**
     * Réorganise l'ordre des membres d'équipe
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer|exists:team_members,id',
        ]);

        foreach ($request->order as $position => $id) {
            TeamMember::where('id', $id)->update(['position' => $position + 1]);
        }

        return response()->json(['success' => true]);
    }
}