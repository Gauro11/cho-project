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
        Schema::create('vital_statistics_management', function (Blueprint $table) {
            $table->id();
            $table->string('year');
            $table->integer('total_population');
            $table->integer('total_live_births');
            $table->integer('total_deaths');
            $table->integer('infant_deaths');
            $table->integer('maternal_deaths');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vital_statistics_management');
    }
};
