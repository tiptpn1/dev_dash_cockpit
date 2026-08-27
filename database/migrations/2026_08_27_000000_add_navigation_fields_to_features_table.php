<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('features', function (Blueprint $table) {
            $table->foreignId('parent_id')->nullable()->constrained('features')->nullOnDelete();
            $table->string('icon')->nullable();
            $table->string('url')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_sidebar')->default(true);
            $table->boolean('is_active')->default(true);
        });
    }

    public function down(): void
    {
        Schema::table('features', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn(['parent_id', 'icon', 'url', 'sort_order', 'is_sidebar', 'is_active']);
        });
    }
};
