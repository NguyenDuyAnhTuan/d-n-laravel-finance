<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/2023_01_01_create_incomes_table.php
public function up()
{
    Schema::create('incomes', function (Blueprint $table) {
        $table->id();
        $table->date('date');
        $table->decimal('amount', 10, 2);
        $table->string('description');
        $table->foreignId('user_id')->constrained();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incomes');
    }
};
