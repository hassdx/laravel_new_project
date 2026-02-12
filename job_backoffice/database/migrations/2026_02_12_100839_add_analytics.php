<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Ensure the users table has the last_log_at column
        if (!Schema::hasColumn('users', 'last_log_at')) {
            Schema::table('users', function (Blueprint $table) {
                $table->timestamp('last_log_at')->nullable();
            });
        }

        // 2. Add viewCount to the job_vacancies table
        // We use Schema::table because the table already exists
        Schema::table('job_vacancies', function (Blueprint $table) {
            $table->unsignedInteger('viewCount')->default(0)->after('title');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('last_log_at');
        });

        Schema::table('job_vacancies', function (Blueprint $table) {
            $table->dropColumn('viewCount');
        });
    }
};