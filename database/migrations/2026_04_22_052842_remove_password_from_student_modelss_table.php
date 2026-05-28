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
        Schema::table('student_modelss', function (Blueprint $table) {
            // Remove password column if it exists
            if (Schema::hasColumn('student_modelss', 'password')) {
                $table->dropColumn('password');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_modelss', function (Blueprint $table) {
            // Restore password column if needed
            if (!Schema::hasColumn('student_modelss', 'password')) {
                $table->string('password')->nullable();
            }
        });
    }
};
