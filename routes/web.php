<?php

use Illuminate\Support\Facades\Route;

// Routes publiques
Route::get('/', function () {
    return view('home'); // Créez la vue resources/views/home.blade.php
})->name('home');

Route::get('/about', function () {
    return view('about'); // Créez la vue resources/views/about.blade.php
})->name('about');

Route::get('/activities', function () {
    return view('activities.index'); // Créez la vue resources/views/activities.blade.php
})->name('activities');

Route::get('/contact', function () {
    return view('contact'); // Créez la vue resources/views/contact.blade.php
})->name('contact');

Route::get('/logout', function () {
    return view('contact'); // Créez la vue resources/views/contact.blade.php
})->name('logout');

// Routes d'administration
Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', function () {
        return view('admin.dashboard'); // Créez la vue resources/views/admin/dashboard.blade.php
    })->name('dashboard');

    Route::get('/announcements', function () {
        return view('admin.announcements.index'); // Créez la vue resources/views/admin/announcements/index.blade.php
    })->name('announcements.index');

    Route::get('/activities', function () {
        return view('admin.activities.index'); // Créez la vue resources/views/admin/activities/index.blade.php
    })->name('activities.index');

    Route::get('/pages', function () {
        return view('admin.pages.index'); // Créez la vue resources/views/admin/pages/index.blade.php
    })->name('pages.index');

    Route::get('/contacts', function () {
        return view('admin.contacts.index'); // Créez la vue resources/views/admin/contacts/index.blade.php
    })->name('contacts.index');

    Route::get('/sliders', function () {
        return view('admin.sliders.index'); // Créez la vue resources/views/admin/sliders/index.blade.php
    })->name('sliders.index');

    Route::get('/team', function () {
        return view('admin.team.index'); // Créez la vue resources/views/admin/team/index.blade.php
    })->name('team.index');

    Route::get('/faqs', function () {
        return view('admin.faqs.index'); // Créez la vue resources/views/admin/faqs/index.blade.php
    })->name('faqs.index');

    Route::get('/users', function () {
        return view('admin.users.index'); // Créez la vue resources/views/admin/users/index.blade.php
    })->name('users.index');

    Route::get('/settings', function () {
        return view('admin.settings'); // Créez la vue resources/views/admin/settings.blade.php
    })->name('settings');
});
