<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SliderController extends Controller
{
    /**
     * Affiche la liste des sliders
     */
    public function index()
    {
        $sliders = Slider::orderBy('id', 'asc')->paginate(10);
        
        return view('admin.sliders.index', compact('sliders'));
    }

    /**
     * Affiche le formulaire de création de slider
     */
    public function create()
    {
        return view('admin.sliders.create');
    }

    /**
     * Enregistre un nouveau slider
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:50',
            'button_url' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('sliders', 'public');
        }

        Slider::create([
            'title' => $request->title,
            'subtitle' => $request->subtitle,
            'button_text' => $request->button_text,
            'button_url' => $request->button_url,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider créé avec succès.');
    }

    /**
     * Affiche le formulaire de modification d'un slider
     */
    public function edit($id)
    {
        $slider = Slider::findOrFail($id);
        
        return view('admin.sliders.edit', compact('slider'));
    }

    /**
     * Met à jour un slider
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'button_text' => 'nullable|string|max:50',
            'button_url' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $slider = Slider::findOrFail($id);

        // Traitement de l'image
        if ($request->hasFile('image')) {
            // Supprime l'ancienne image si elle existe
            if ($slider->image) {
                Storage::disk('public')->delete($slider->image);
            }
            $imagePath = $request->file('image')->store('sliders', 'public');
            $slider->image = $imagePath;
        }

        $slider->title = $request->title;
        $slider->subtitle = $request->subtitle;
        $slider->button_text = $request->button_text;
        $slider->button_url = $request->button_url;
        $slider->save();

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider mis à jour avec succès.');
    }

    /**
     * Supprime un slider
     */
    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);
        
        // Supprime l'image associée si elle existe
        if ($slider->image) {
            Storage::disk('public')->delete($slider->image);
        }
        
        $slider->delete();

        return redirect()->route('admin.sliders.index')
            ->with('success', 'Slider supprimé avec succès.');
    }

    /**
     * Réorganise l'ordre des sliders
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer|exists:sliders,id',
        ]);

        foreach ($request->order as $position => $id) {
            Slider::where('id', $id)->update(['position' => $position + 1]);
        }

        return response()->json(['success' => true]);
    }
}