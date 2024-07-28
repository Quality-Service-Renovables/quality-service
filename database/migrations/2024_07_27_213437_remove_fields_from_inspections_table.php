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
            $table->dropForeign('fk_inspecion_equipment');
            $table->dropColumn('equipment_id');
            $table->dropIndex('equipment_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inspections', function (Blueprint $table) {
            $table->unsignedBigInteger('equipment_id')->comment('Relation with equipment');
            $table->index('equipment_id');
            $table->foreign('equipment_id', 'fk_inspecion_equipment')
                ->references('equipment_id')->on('equipments');
        });
    }
};
