<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->string('name')->after('id');
            $table->string('email')->after('name');
            $table->string('subject')->nullable()->after('email');
            $table->text('message')->nullable()->after('subject');
            // $table->boolean('is_read')->default(false)->after('message');
            // $table->timestamps(); // adds created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn(['name', 'email', 'subject', 'message', 'is_read']);
            $table->dropTimestamps();
        });
    }
};
