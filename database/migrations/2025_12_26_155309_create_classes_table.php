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
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('name');                  // e.g., "First Standard", "Grade 10"
            $table->string('section')->nullable();   // e.g., "A", "B", "Science", etc.
            $table->string('class_code')->nullable()->unique(); // Optional: unique code like "FS-A", "10B"
            $table->text('description')->nullable(); // Optional: short description or notes
            $table->unsignedInteger('capacity')->default(0); // Optional: max students allowed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};