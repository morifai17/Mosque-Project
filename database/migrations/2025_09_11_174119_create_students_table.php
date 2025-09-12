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
          Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('teachers')->onDelete('cascade'); 
            $table->string('first_name');
            $table->string('last_name');
            $table->string('avatar')->nullable();
            $table->string('student_name');
            $table->string('phone_number');           
            $table->integer('age');
            $table->string('password');
            $table->integer('points')->default(0);
            $table->rememberToken();
            $table->timestamps();
        }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
