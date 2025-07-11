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
        Schema::create('morbidity_mortality_management', function (Blueprint $table) {
            $table->id();
            $table->enum('category', ['morbidity', 'mortality'])->default('mortality');
            $table->string('case_name');
            $table->string('date');
            $table->integer('male_count');
            $table->integer('female_count');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('morbidity_mortality_management');
    }
};
