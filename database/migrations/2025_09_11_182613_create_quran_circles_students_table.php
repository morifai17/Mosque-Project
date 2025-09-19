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
        Schema::create('quran_circles_students', function (Blueprint $table) {
             $table->id();
        $table->foreignId('quran_circle')->constrained('quran_circles')->onDelete('cascade'); 
        $table->foreignId('teacher_id')->constrained('teachers')->onDelete('cascade'); 
        $table->string('student_name');
        $table->string('phone_number');
        $table->boolean('is_registered')->default(false); // set true when student actually registers
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quran_circle_students');
    }
};
