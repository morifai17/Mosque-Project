<?php

use App\Models\Product;
use App\Models\Student;
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
        Schema::create('carts', function (Blueprint $table) {

            $table->id();
            $table->foreignIdFor(Product::class)->constrained();
            $table->foreignIdFor(Student::class)->constrained();
            $table->unsignedInteger('quantity');
            $table->unsignedInteger('total_price');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
