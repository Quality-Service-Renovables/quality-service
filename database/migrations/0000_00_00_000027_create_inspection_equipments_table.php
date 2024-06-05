<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inspection_equipments', static function (Blueprint $table) {
            $table->id('inspection_equipment_id');
            $table->uuid('inspection_equipment_uuid');
            $table->unsignedBigInteger('inspection_id')->comment('Relation with inspection');
            $table->unsignedBigInteger('equipment_id')->comment('Relation with equipment');
            $table->boolean('is_inspection_equipment')->default(false)->comment('Is equipment used in inspection');
            $table->timestamps();
            $table->softDeletes();
            //INDEX
            $table->index('inspection_id');
            $table->index('equipment_id');
            //FOREIGN KEYS
            $table->foreign('inspection_id', 'fk_inspection_equipment_inspection')
                ->references('inspection_id')->on('inspections');
            $table->foreign('equipment_id', 'fk_inspection_equipment_equipment')
                ->references('equipment_id')->on('equipments');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspection_equipments');
    }
};
