<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Affiche la liste des messages de contact
     */
    public function index()
    {
        $contacts = Contact::latest()->paginate(15);
        
        return view('admin.contacts.index', compact('contacts'));
    }

    /**
     * Affiche les détails d'un message de contact
     */
    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        
        // Marque le message comme lu s'il ne l'est pas déjà
        if (!$contact->is_read) {
            $contact->is_read = true;
            $contact->save();
        }
        
        return view('admin.contacts.show', compact('contact'));
    }

    /**
     * Marque un message comme lu
     */
    public function markAsRead($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->is_read = true;
        $contact->save();
        
        return redirect()->back()->with('success', 'Message marqué comme lu.');
    }

    /**
     * Marque un message comme non lu
     */
    public function markAsUnread($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->is_read = false;
        $contact->save();
        
        return redirect()->back()->with('success', 'Message marqué comme non lu.');
    }

    /**
     * Supprime un message de contact
     */
    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();
        
        return redirect()->route('admin.contacts.index')
            ->with('success', 'Message supprimé avec succès.');
    }

    /**
     * Affiche la liste des messages non lus
     */
    public function unread()
    {
        $contacts = Contact::where('is_read', false)->latest()->paginate(15);
        
        return view('admin.contacts.unread', compact('contacts'));
    }

    /**
     * Supprime plusieurs messages sélectionnés
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'selected' => 'required|array',
            'selected.*' => 'integer|exists:contacts,id',
        ]);

        Contact::whereIn('id', $request->selected)->delete();
        
        return redirect()->route('admin.contacts.index')
            ->with('success', count($request->selected) . ' message(s) supprimé(s) avec succès.');
    }

    /**
     * Marque plusieurs messages comme lus
     */
    public function bulkMarkAsRead(Request $request)
    {
        $request->validate([
            'selected' => 'required|array',
            'selected.*' => 'integer|exists:contacts,id',
        ]);

        Contact::whereIn('id', $request->selected)->update(['is_read' => true]);
        
        return redirect()->route('admin.contacts.index')
            ->with('success', count($request->selected) . ' message(s) marqué(s) comme lu(s).');
    }
}