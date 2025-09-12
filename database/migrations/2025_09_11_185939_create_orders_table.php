<?php

use App\Models\Student;
use App\Models\User;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Student::class)->constrained();
            $table->unsignedInteger('total_price');
            $table->foreignId('coupon_id')->nullable()->constrained('coupons')->onDelete('set null'); // if coupon deleted, order keeps null
            $table->integer( 'final_price')->nullable(); // السعر النهائي بعد الخصم
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order');
    }
};
