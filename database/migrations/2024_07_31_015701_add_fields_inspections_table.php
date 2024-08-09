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
        Schema::table('inspections', function (Blueprint $table) {
            $table->longText('escala_condicion')->nullable()->after('location')->comment('Scale Condition');
            $table->unsignedBigInteger('ct_risk_id')->nullable()->after('ct_inspection_id')->comment('Risk');
            //INDEX
            $table->index('ct_risk_id');
            //FOREIGN KEYS
            $table->foreign('ct_risk_id', 'fk_inspection_ct_risk')
                ->references('ct_risk_id')
                ->on('ct_risks');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inspections', function (Blueprint $table) {
            $table->dropColumn('escala_condicion');
            $table->dropColumn('ct_risk_id');
        });
    }
};
