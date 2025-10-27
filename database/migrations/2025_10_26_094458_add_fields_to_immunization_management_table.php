<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('immunization_management', function (Blueprint $table) {
            $table->string('vaccine_type')->nullable()->after('vaccine_name');
            $table->integer('total_shots')->default(0)->after('vaccine_type');
            $table->string('age_group')->nullable()->after('female_vaccinated');
            $table->string('target_population')->nullable()->after('age_group');
            $table->string('barangay')->nullable()->after('target_population');
            // 'date' column already exists as 'date_of_vaccination'
        });
    }

    public function down()
    {
        Schema::table('immunization_management', function (Blueprint $table) {
            $table->dropColumn(['vaccine_type', 'total_shots', 'age_group', 'target_population', 'barangay']);
        });
    }
};
