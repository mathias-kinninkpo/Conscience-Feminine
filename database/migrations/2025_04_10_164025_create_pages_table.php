<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            // Ajoute la colonne 'title' après 'id' si elle n'existe pas déjà
            if (!Schema::hasColumn('pages', 'title')) {
                $table->string('title')->after('id');
            }
            // Ajoute la colonne 'slug' après 'title'
            if (!Schema::hasColumn('pages', 'slug')) {
                $table->string('slug')->unique()->after('title');
            }
            // Ajoute la colonne 'content' après 'slug'
            if (!Schema::hasColumn('pages', 'content')) {
                $table->text('content')->nullable()->after('slug');
            }
            // Ajoute la colonne 'image' après 'content'
            if (!Schema::hasColumn('pages', 'image')) {
                $table->string('image')->nullable()->after('content');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pages', function (Blueprint $table) {
            // Supprime les colonnes ajoutées
            $table->dropColumn(['title', 'slug', 'content', 'image']);
        });
    }
};
