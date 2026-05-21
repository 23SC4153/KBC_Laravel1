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
            $table->foreignId('degree_id')
                ->nullable()
                ->after('contact')
                ->constrained('degree_models')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_modelss', function (Blueprint $table) {
            $table->dropConstrainedForeignId('degree_id');
        });
    }
};
