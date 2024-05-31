<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('github_id')->nullable();
            $table->string('github_token')->nullable();
            $table->string('github_refresh_token')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('github_id');
            $table->dropColumn('github_token');
            $table->dropColumn('github_refresh_token');
        });
    }
};
