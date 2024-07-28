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
        Schema::table('ct_equipments', function (Blueprint $table) {
            $table->json('required_fields_report')->nullable()->after('description')->comment('The required fields of the equipment to inspect, for the report');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ct_equipments', function (Blueprint $table) {
            $table->dropColumn('required_fields_report');
        });
    }
};
