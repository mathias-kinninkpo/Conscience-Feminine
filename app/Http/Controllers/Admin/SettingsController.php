<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    /**
     * Affiche le formulaire des paramètres du site
     */
    public function index()
    {
        return view('admin.settings.index');
    }

    /**
     * Met à jour les paramètres du site
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'site_name' => 'required|string|max:255',
            'site_description' => 'nullable|string',
            'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'site_favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,ico|max:1024',
            'contact_email' => 'required|email|max:255',
            'contact_phone' => 'nullable|string|max:255',
            'contact_address' => 'nullable|string',
            'social_facebook' => 'nullable|string|max:255',
            'social_twitter' => 'nullable|string|max:255',
            'social_instagram' => 'nullable|string|max:255',
            'social_linkedin' => 'nullable|string|max:255',
            'social_youtube' => 'nullable|string|max:255',
            'social_tiktok' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Traitement du logo
        if ($request->hasFile('site_logo')) {
            // Supprime l'ancien logo si il existe
            if (setting('site_logo')) {
                Storage::disk('public')->delete(setting('site_logo'));
            }
            
            $logoPath = $request->file('site_logo')->store('settings', 'public');
            setting(['site_logo' => $logoPath]);
        }

        // Traitement du favicon
        if ($request->hasFile('site_favicon')) {
            // Supprime l'ancien favicon si il existe
            if (setting('site_favicon')) {
                Storage::disk('public')->delete(setting('site_favicon'));
            }
            
            $faviconPath = $request->file('site_favicon')->store('settings', 'public');
            setting(['site_favicon' => $faviconPath]);
        }

        // Mise à jour des autres paramètres
        setting([
            'site_name' => $request->site_name,
            'site_description' => $request->site_description,
            'contact_email' => $request->contact_email,
            'contact_phone' => $request->contact_phone,
            'contact_address' => $request->contact_address,
            'social_facebook' => $request->social_facebook,
            'social_twitter' => $request->social_twitter,
            'social_instagram' => $request->social_instagram,
            'social_linkedin' => $request->social_linkedin,
            'social_youtube' => $request->social_youtube,
            'social_tiktok' => $request->social_tiktok,
        ]);

        return redirect()->route('admin.settings')
            ->with('success', 'Paramètres mis à jour avec succès.');
    }

    /**
     * Met à jour les paramètres d'email
     */
    public function updateEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mail_mailer' => 'required|string|max:255',
            'mail_host' => 'required|string|max:255',
            'mail_port' => 'required|integer',
            'mail_username' => 'nullable|string|max:255',
            'mail_password' => 'nullable|string|max:255',
            'mail_encryption' => 'nullable|string|max:255',
            'mail_from_address' => 'required|email|max:255',
            'mail_from_name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('mail_password'));
        }

        // Mise à jour des paramètres d'email
        setting([
            'mail_mailer' => $request->mail_mailer,
            'mail_host' => $request->mail_host,
            'mail_port' => $request->mail_port,
            'mail_username' => $request->mail_username,
            'mail_password' => $request->mail_password,
            'mail_encryption' => $request->mail_encryption,
            'mail_from_address' => $request->mail_from_address,
            'mail_from_name' => $request->mail_from_name,
        ]);

        return redirect()->route('admin.settings.email')
            ->with('success', 'Paramètres d\'email mis à jour avec succès.');
    }

    /**
     * Envoie un email de test
     */
    public function sendTestEmail(Request $request)
    {
        $request->validate([
            'test_email' => 'required|email|max:255',
        ]);

        // Logique pour envoyer un email de test
        // À implémenter selon vos besoins

        return redirect()->back()
            ->with('success', 'Email de test envoyé avec succès à ' . $request->test_email);
    }

    /**
     * Affiche le formulaire des paramètres d'apparence
     */
    public function appearance()
    {
        return view('admin.settings.appearance');
    }

    /**
     * Met à jour les paramètres d'apparence
     */
    public function updateAppearance(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'primary_color' => 'nullable|string|max:7',
            'secondary_color' => 'nullable|string|max:7',
            'tertiary_color' => 'nullable|string|max:7',
            'background_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Traitement de l'image de fond
        if ($request->hasFile('background_image')) {
            // Supprime l'ancienne image si elle existe
            if (setting('background_image')) {
                Storage::disk('public')->delete(setting('background_image'));
            }
            
            $imagePath = $request->file('background_image')->store('settings', 'public');
            setting(['background_image' => $imagePath]);
        }

        // Mise à jour des couleurs
        setting([
            'primary_color' => $request->primary_color,
            'secondary_color' => $request->secondary_color,
            'tertiary_color' => $request->tertiary_color,
        ]);

        return redirect()->route('admin.settings.appearance')
            ->with('success', 'Paramètres d\'apparence mis à jour avec succès.');
    }
}