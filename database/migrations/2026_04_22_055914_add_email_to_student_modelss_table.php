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
        if (!Schema::hasColumn('student_modelss', 'email')) {
            Schema::table('student_modelss', function (Blueprint $table) {
                $table->string('email')->nullable()->after('lname');
            });
        }

        // Backfill email using linked user account when available.
        DB::statement('UPDATE student_modelss s LEFT JOIN user_accounts u ON u.id = s.user_account_id SET s.email = u.email WHERE s.email IS NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('student_modelss', 'email')) {
            Schema::table('student_modelss', function (Blueprint $table) {
                $table->dropColumn('email');
            });
        }
    }
};
