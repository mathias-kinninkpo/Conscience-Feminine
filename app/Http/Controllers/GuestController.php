<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Announcement;
use App\Models\Contact;
use App\Models\Faq;
use App\Models\Page;
use App\Models\Slider;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GuestController extends Controller
{
    /**
     * Affiche la page d'accueil
     */
    public function home()
    {
        $sliders = Slider::all();
        $announcements = Announcement::latest()->take(3)->get();
        $recentActivities = Activity::latest()->take(4)->get();
        
        return view('home', compact('sliders', 'announcements', 'recentActivities'));
    }

    /**
     * Affiche la page À propos
     */
    public function about()
    {
        $teamMembers = TeamMember::all();
        $page = Page::where('slug', 'about')->first();
        
        return view('about', compact('teamMembers', 'page'));
    }

    /**
     * Affiche la liste des activités
     */
    public function activities()
    {
        $activities = Activity::latest()->paginate(9);
        
        return view('activities.index', compact('activities'));
    }

    /**
     * Affiche les détails d'une activité
     */
    public function activityDetails($id)
    {
        $activity = Activity::findOrFail($id);
        $relatedActivities = Activity::where('id', '!=', $id)
            ->latest()
            ->take(3)
            ->get();
        
        return view('activities.show', compact('activity', 'relatedActivities'));
    }

    /**
     * Affiche la page de contact
     */
    public function contact()
    {
        $faqs = Faq::all();
        
        return view('contact', compact('faqs'));
    }

    /**
     * Traite l'envoi du formulaire de contact
     */
    public function submitContact(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'subject' => $request->subject,
            'message' => $request->message,
            'is_read' => false,
        ]);

        return redirect()->back()->with('success', 'Votre message a été envoyé avec succès. Nous vous répondrons dans les plus brefs délais.');
    }

    /**
     * Affiche une page dynamique par son slug
     */
    public function page($slug)
    {
        $page = Page::where('slug', $slug)->firstOrFail();
        
        return view('page', compact('page'));
    }
}