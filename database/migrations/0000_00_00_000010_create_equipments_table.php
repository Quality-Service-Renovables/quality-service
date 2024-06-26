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
        Schema::create('equipments', static function (Blueprint $table) {
            $table->id('equipment_id');
            $table->uuid('equipment_uuid');
            $table->string('equipment');
            $table->string('equipment_code');
            $table->string('equipment_image')->default('img/equipments/default.png');
            $table->string('equipment_diagram')->nullable();
            $table->string('serial_number')->nullable()->comment('Serial number or vin number');
            $table->date('manufacture_date')->nullable()->comment('Manufacture date');
            $table->unsignedBigInteger('work_hours')->nullable()->comment('Work hours');
            $table->unsignedBigInteger('energy_produced')->nullable()->comment('Energy produced in Kilowatts');
            $table->string('barcode')->nullable()->comment('Barcode');
            $table->longText('description')->nullable()->comment('General comments');
            $table->longText('location')->nullable()->comment('Describe equipment location');
            $table->string('manual')->nullable();
            $table->unsignedBigInteger('ct_equipment_id')->comment('Relation with equipment category');
            $table->unsignedBigInteger('trademark_id')->comment('Relation with trademark');
            $table->unsignedBigInteger('trademark_model_id')->comment('Relation with trademark model');
            $table->unsignedBigInteger('status_id')->comment('Relation with equipment status');
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            //INDEX
            $table->index('equipment_uuid');
            $table->index('ct_equipment_id');
            $table->index('trademark_id');
            $table->index('trademark_model_id');
            $table->index('status_id');
            //FOREIGN KEYS
            $table->foreign('ct_equipment_id', 'fk_ct_equipment')
                ->references('ct_equipment_id')->on('ct_equipments');
            $table->foreign('trademark_id', 'fk_equipment_trademark')
                ->references('trademark_id')->on('trademarks');
            $table->foreign('trademark_model_id', 'fk_equipment_trademark_model')
                ->references('trademark_model_id')->on('trademark_models');
            $table->foreign('status_id', 'fk_equipment_status')
                ->references('status_id')->on('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipments');
    }
};
