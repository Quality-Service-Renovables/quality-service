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
        Schema::table('inspection_forms', function (Blueprint $table) {
            $table->unsignedBigInteger('ct_risk_id')->nullable()->after('ct_inspection_form_id')->comment('Relation with ct_risks');
            $table->foreign('ct_risk_id', 'fk_ct_risk_id')->references('ct_risk_id')->on('ct_risks');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inspection_forms', function (Blueprint $table) {
            $table->dropForeign(['ct_risk_id']);
            $table->dropColumn('ct_risk_id');
        });
    }
};
