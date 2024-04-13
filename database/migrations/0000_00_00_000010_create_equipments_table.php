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
            $table->string('equipment_image');
            $table->string('model');
            $table->string('serial_number')->comment('Serial number or vin number');
            $table->string('manufacture_date')->comment('Manufacture date');
            $table->date('barcode')->comment('Barcode');
            $table->longText('description')->comment('General comments');
            $table->string('manual')->nullable();
            $table->unsignedBigInteger('equipment_category_id');
            $table->unsignedBigInteger('trademark_id');
            $table->unsignedBigInteger('status_id');
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            //INDEX
            $table->index('equipment_uuid');
            $table->index('equipment_category_id');
            $table->index('trademark_id');
            $table->index('status_id');
            //FOREIGN KEYS
            $table->foreign('equipment_category_id', 'fk_equipment_category')
                ->references('equipment_category_id')->on('equipment_categories');
            $table->foreign('trademark_id', 'fk_equipment_trademark')
                ->references('trademark_id')->on('trademarks');
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
