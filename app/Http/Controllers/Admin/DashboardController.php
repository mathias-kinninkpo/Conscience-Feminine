<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use App\Models\Announcement;
use App\Models\Contact;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Affiche le tableau de bord administrateur
     */
    public function index()
    {
        // Récupération des statistiques pour le tableau de bord
        $stats = [
            'activities_count' => Activity::count(),
            'announcements_count' => Announcement::count(),
            'unread_messages_count' => Contact::where('is_read', false)->count(),
            'users_count' => User::count(),
        ];
        
        // Récupération des dernières activités
        $latestActivities = Activity::latest()->take(5)->get();
        
        // Récupération des dernières annonces
        $latestAnnouncements = Announcement::latest()->take(5)->get();
        
        // Récupération des derniers messages
        $latestMessages = Contact::latest()->take(5)->get();
        
        return view('admin.dashboard', compact(
            'stats', 
            'latestActivities', 
            'latestAnnouncements', 
            'latestMessages'
        ));
    }
}