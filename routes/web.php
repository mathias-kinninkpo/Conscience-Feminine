<?php

use App\Http\Controllers\Admin\ActivityController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\TeamMemberController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\GuestController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes publiques
|--------------------------------------------------------------------------
*/

// Page d'accueil
Route::get('/', [GuestController::class, 'home'])->name('home');

// À propos
Route::get('/about', [GuestController::class, 'about'])->name('about');

// Activités
Route::get('/activities', [GuestController::class, 'activities'])->name('activities');
Route::get('/activities/{id}', [GuestController::class, 'activityDetails'])->name('activities.show');

// Contact
Route::get('/contact', [GuestController::class, 'contact'])->name('contact');
Route::post('/contact', [GuestController::class, 'submitContact'])->name('contact.submit');

// Pages dynamiques
Route::get('/page/{slug}', [GuestController::class, 'page'])->name('page');

/*
|--------------------------------------------------------------------------
| Routes d'authentification
|--------------------------------------------------------------------------
*/

Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');
Route::get('/admin/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/admin/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('admin.password.request');
Route::post('/admin/forgot-password', [AuthController::class, 'sendResetLink'])->name('admin.password.email');
Route::get('/admin/change-password', [AuthController::class, 'showChangePasswordForm'])->name('admin.password.change')->middleware('auth');
Route::post('/admin/change-password', [AuthController::class, 'changePassword'])->name('admin.password.update')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Routes d'administration
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Annonces
    Route::resource('announcements', AnnouncementController::class);
    
    // Activités
    Route::resource('activities', ActivityController::class);
    
    // Pages
    Route::resource('pages', PageController::class);
    
    // Contacts
    Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
    Route::get('/contacts/unread', [ContactController::class, 'unread'])->name('contacts.unread');
    Route::get('/contacts/{id}', [ContactController::class, 'show'])->name('contacts.show');
    Route::post('/contacts/{id}/mark-as-read', [ContactController::class, 'markAsRead'])->name('contacts.mark-as-read');
    Route::post('/contacts/{id}/mark-as-unread', [ContactController::class, 'markAsUnread'])->name('contacts.mark-as-unread');
    Route::delete('/contacts/{id}', [ContactController::class, 'destroy'])->name('contacts.destroy');
    Route::post('/contacts/bulk-delete', [ContactController::class, 'bulkDelete'])->name('contacts.bulk-delete');
    Route::post('/contacts/bulk-mark-as-read', [ContactController::class, 'bulkMarkAsRead'])->name('contacts.bulk-mark-as-read');
    
    // Sliders
    Route::resource('sliders', SliderController::class);
    Route::post('/sliders/reorder', [SliderController::class, 'reorder'])->name('sliders.reorder');
    
    // Équipe
    Route::resource('team', TeamMemberController::class);
    Route::post('/team/reorder', [TeamMemberController::class, 'reorder'])->name('team.reorder');
    
    // FAQs
    Route::resource('faqs', FaqController::class);
    Route::post('/faqs/reorder', [FaqController::class, 'reorder'])->name('faqs.reorder');
    
    // Utilisateurs
    Route::resource('users', UserController::class);
    Route::get('/profile/change-password', [UserController::class, 'showChangePasswordForm'])->name('profile.change-password');
    Route::post('/profile/change-password', [UserController::class, 'changePassword'])->name('profile.update-password');
    
    // Paramètres
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
    Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
    Route::get('/settings/appearance', [SettingsController::class, 'appearance'])->name('settings.appearance');
    Route::post('/settings/appearance', [SettingsController::class, 'updateAppearance'])->name('settings.appearance.update');
    Route::get('/settings/email', [SettingsController::class, 'email'])->name('settings.email');
    Route::post('/settings/email', [SettingsController::class, 'updateEmail'])->name('settings.email.update');
    Route::post('/settings/email/test', [SettingsController::class, 'sendTestEmail'])->name('settings.email.test');
});