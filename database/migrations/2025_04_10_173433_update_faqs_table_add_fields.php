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
        Schema::table('faqs', function (Blueprint $table) {
            // Ajoute la colonne 'question' si elle n'existe pas déjà
            if (!Schema::hasColumn('faqs', 'question')) {
                $table->text('question')->after('id');
            }
            // Ajoute la colonne 'answer' si elle n'existe pas déjà
            if (!Schema::hasColumn('faqs', 'answer')) {
                $table->text('answer')->after('question');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('faqs', function (Blueprint $table) {
            $table->dropColumn(['question', 'answer']);
        });
    }
};
