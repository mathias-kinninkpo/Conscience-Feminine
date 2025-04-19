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
        Schema::table('team_members', function (Blueprint $table) {
            if (!Schema::hasColumn('team_members', 'name')) {
                $table->string('name')->after('id');
            }
            if (!Schema::hasColumn('team_members', 'role')) {
                $table->string('role')->nullable()->after('name');
            }
            if (!Schema::hasColumn('team_members', 'bio')) {
                $table->text('bio')->nullable()->after('role');
            }
            if (!Schema::hasColumn('team_members', 'image')) {
                $table->string('image')->nullable()->after('bio');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('team_members', function (Blueprint $table) {
            $table->dropColumn(['name', 'role', 'bio', 'image']);
        });
    }
};
