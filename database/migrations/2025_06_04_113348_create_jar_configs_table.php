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
        Schema::create('jar_configs', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Tên hũ
            $table->decimal('percent', 5, 2); // Phần trăm phân bổ
            $table->text('description')->nullable(); // Mô tả (nếu có)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jar_configs');
    }
};
