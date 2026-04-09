<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations - Add fields from SSO Server
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Add SSO fields if they don't exist
            if (!Schema::hasColumn('users', 'nik')) {
                $table->string('nik')->unique()->nullable()->after('id');
            }
            if (!Schema::hasColumn('users', 'name')) {
                $table->string('name')->nullable()->after('username');
            }
            if (!Schema::hasColumn('users', 'email')) {
                $table->string('email')->unique()->nullable()->after('name');
            }
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone')->nullable()->after('email');
            }
            if (!Schema::hasColumn('users', 'organization')) {
                $table->string('organization')->nullable()->after('phone');
            }
            if (!Schema::hasColumn('users', 'email_verified_at')) {
                $table->timestamp('email_verified_at')->nullable()->after('email');
            }
        });
    }

    /**
     * Reverse the migrations
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'nik',
                'name',
                'email',
                'phone',
                'organization',
                'email_verified_at',
            ]);
        });
    }
};
