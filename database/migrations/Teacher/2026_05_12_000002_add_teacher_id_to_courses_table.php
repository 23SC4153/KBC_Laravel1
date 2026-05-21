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
        Schema::table('courses', function (Blueprint $table) {
            // Add columns if they don't exist
            if (!Schema::hasColumn('courses', 'CourseCode')) {
                $table->string('CourseCode')->unique()->nullable();
            }
            if (!Schema::hasColumn('courses', 'CourseName')) {
                $table->string('CourseName')->nullable();
            }
            if (!Schema::hasColumn('courses', 'description')) {
                $table->text('description')->nullable();
            }
            if (!Schema::hasColumn('courses', 'teacher_id')) {
                $table->unsignedBigInteger('teacher_id')->nullable();
                $table->foreign('teacher_id')->references('id')->on('teachers')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            if (Schema::hasColumn('courses', 'teacher_id')) {
                $table->dropForeign(['teacher_id']);
                $table->dropColumn('teacher_id');
            }
        });
    }
};
