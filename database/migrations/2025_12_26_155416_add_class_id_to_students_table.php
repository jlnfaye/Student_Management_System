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
        Schema::table('students', function (Blueprint $table) {
            // Add foreign key to link students to classes
            $table->foreignId('class_id')
                  ->nullable()
                  ->constrained('classes')   // references 'id' on 'classes' table
                  ->onDelete('set null');    // if class is deleted, set student class to null
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            // Remove the foreign key and column
            $table->dropForeign(['class_id']);
            $table->dropColumn('class_id');
        });
    }
};