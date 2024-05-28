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
        Schema::create('equipment_maintenance', static function (Blueprint $table) {
            $table->id('equipment_maintenance_id');
            $table->uuid('equipment_maintenance_uuid');
            $table->longText('description');
            $table->boolean('maintenance_apply')->default(true);
            $table->dateTime('maintenance_date');
            $table->dateTime('maintenance_scheduled');
            $table->unsignedBigInteger('equipment_id')->comment('Relation with equipment');
            $table->unsignedBigInteger('ct_maintenance_id')->comment('Relation with maintenance category');
            $table->timestamps();
            $table->softDeletes();
            //INDEX
            $table->index('equipment_maintenance_uuid');
            $table->index('equipment_id');
            $table->index('ct_maintenance_id');
            //FOREIGN KEYS
            $table->foreign('equipment_id', 'fk_maintenance_equipment')
                ->references('equipment_id')->on('equipments');
            $table->foreign('ct_maintenance_id', 'fk_ct_maintenance')
                ->references('ct_maintenance_id')->on('ct_maintenances');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_maintenance');
    }
};
