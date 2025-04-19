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
        Schema::table('sliders', function (Blueprint $table) {
            if (!Schema::hasColumn('sliders', 'title')) {
                $table->string('title')->after('id');
            }
            if (!Schema::hasColumn('sliders', 'subtitle')) {
                $table->string('subtitle')->nullable()->after('title');
            }
            if (!Schema::hasColumn('sliders', 'button_text')) {
                $table->string('button_text')->nullable()->after('subtitle');
            }
            if (!Schema::hasColumn('sliders', 'button_url')) {
                $table->string('button_url')->nullable()->after('button_text');
            }
            if (!Schema::hasColumn('sliders', 'image')) {
                $table->string('image')->nullable()->after('button_url');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sliders', function (Blueprint $table) {
            $table->dropColumn(['title', 'subtitle', 'button_text', 'button_url', 'image']);
        });
    }
};
