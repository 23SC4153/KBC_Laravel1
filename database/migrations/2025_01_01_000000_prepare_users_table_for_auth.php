<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // If an old custom users table exists, rename it to Laravel's expected users table.
        if (!Schema::hasTable('users') && Schema::hasTable('users1s')) {
            DB::statement('RENAME TABLE users1s TO users');
        }

        // Create users table if neither legacy nor default table exists.
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('name')->nullable();
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password')->nullable();
                $table->rememberToken();
                $table->timestamps();
            });
        }

        // Ensure auth-required columns are present so later migrations can safely alter users.
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'name')) {
                $table->string('name')->nullable()->after('id');
            }

            if (!Schema::hasColumn('users', 'password')) {
                $table->string('password')->nullable()->after('email');
            }

            if (!Schema::hasColumn('users', 'email_verified_at')) {
                $table->timestamp('email_verified_at')->nullable()->after('email');
            }

            if (!Schema::hasColumn('users', 'remember_token')) {
                $table->rememberToken();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Intentionally left empty to avoid destructive table renames/drops in rollback.
    }
};
