<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FaqController extends Controller
{
    /**
     * Affiche la liste des FAQs
     */
    public function index()
    {
        $faqs = Faq::orderBy('id', 'asc')->paginate(10);
        
        return view('admin.faqs.index', compact('faqs'));
    }

    /**
     * Affiche le formulaire de création de FAQ
     */
    public function create()
    {
        return view('admin.faqs.create');
    }

    /**
     * Enregistre une nouvelle FAQ
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Faq::create([
            'question' => $request->question,
            'answer' => $request->answer,
        ]);

        return redirect()->route('admin.faqs.index')
            ->with('success', 'FAQ créée avec succès.');
    }

    /**
     * Affiche le formulaire de modification d'une FAQ
     */
    public function edit($id)
    {
        $faq = Faq::findOrFail($id);
        
        return view('admin.faqs.edit', compact('faq'));
    }

    /**
     * Met à jour une FAQ
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $faq = Faq::findOrFail($id);
        $faq->question = $request->question;
        $faq->answer = $request->answer;
        $faq->save();

        return redirect()->route('admin.faqs.index')
            ->with('success', 'FAQ mise à jour avec succès.');
    }

    /**
     * Supprime une FAQ
     */
    public function destroy($id)
    {
        $faq = Faq::findOrFail($id);
        $faq->delete();
        
        return redirect()->route('admin.faqs.index')
            ->with('success', 'FAQ supprimée avec succès.');
    }

    /**
     * Réorganise l'ordre des FAQs
     */
    public function reorder(Request $request)
    {
        $request->validate([
            'order' => 'required|array',
            'order.*' => 'integer|exists:faqs,id',
        ]);

        foreach ($request->order as $position => $id) {
            Faq::where('id', $id)->update(['position' => $position + 1]);
        }

        return response()->json(['success' => true]);
    }
}