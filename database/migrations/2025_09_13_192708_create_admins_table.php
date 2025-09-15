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
    Schema::create('admins', function (Blueprint $table) {
        $table->id();
        $table->string('first_name', 255);
        $table->string('last_name', 255);
        $table->string('admin_name', 255);
        $table->string('phone_number');
        $table->string('password');
        $table->string('avatar')->nullable();
        $table->boolean("Super_Admin")->default(false);
        $table->timestamps();
        $table->softDeletes(); // إضافة soft deletes

        // indexes
        $table->index('admin_name');
        $table->index('phone_number');
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
