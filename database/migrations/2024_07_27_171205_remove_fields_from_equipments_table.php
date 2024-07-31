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
        Schema::table('equipments', function (Blueprint $table) {
            //Eliminamos los campos
            $table->dropColumn('work_hours');
            $table->dropColumn('energy_produced');
            $table->dropColumn('barcode');
            $table->dropColumn('manufacture_date');
            $table->dropColumn('description');
            $table->dropColumn('location');

            //Eliminamos las llaves foráneas
            $table->dropForeign('fk_equipment_trademark');
            $table->dropForeign('fk_equipment_trademark_model');
            $table->dropColumn('trademark_id');
            $table->dropColumn('trademark_model_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('equipments', function (Blueprint $table) {
            $table->unsignedBigInteger('work_hours')->nullable()->comment('Work hours');
            $table->unsignedBigInteger('energy_produced')->nullable()->comment('Energy produced in Kilowatts');
            $table->string('barcode')->nullable()->comment('Barcode');
            $table->date('manufacture_date')->nullable()->comment('Manufacture date');
            $table->longText('description')->nullable()->comment('General comments');
            $table->longText('location')->nullable()->comment('Describe equipment location');

            //Agregamos las llaves foráneas
            $table->unsignedBigInteger('trademark_id')->comment('Relation with trademark');
            $table->unsignedBigInteger('trademark_model_id')->comment('Relation with trademark model');

            //Agregamos los índices
            $table->index('trademark_id');
            $table->index('trademark_model_id');

            //Agregamos las llaves foráneas
            $table->foreign('trademark_id', 'fk_equipment_trademark')
                ->references('trademark_id')->on('trademarks');
            $table->foreign('trademark_model_id', 'fk_equipment_trademark_model')
                ->references('trademark_model_id')->on('trademark_models');
        });
    }
};
