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
        Schema::create('oils', static function (Blueprint $table) {
            $table->id('oil_id');
            $table->uuid('oil_uuid');
            $table->string('oil');
            $table->string('oil_code');
            $table->string('viscosity')->nullable()->comment('Viscosity');
            $table->string('description')->nullable()->comment('Oil description technical details');
            $table->unsignedBigInteger('oil_category_id');
            $table->unsignedBigInteger('trademark_id');
            $table->unsignedBigInteger('trademark_model_id');
            $table->date('production_date')->nullable();
            $table->date('expiration_date')->nullable();
            $table->unsignedBigInteger('quantity')->nullable()->comment('Quantity Lts');
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            //INDEX
            $table->index('oil_uuid');
            $table->index('oil_category_id');
            $table->index('trademark_id');
            $table->index('trademark_model_id');
            //FOREIGN KEYS
            $table->foreign('oil_category_id', 'fk_oil_category')
                ->references('oil_category_id')->on('oil_categories');
            $table->foreign('trademark_id', 'fk_oil_trademark')
                ->references('trademark_id')->on('trademarks');
            $table->foreign('trademark_model_id', 'fk_oil_trademark_model')
                ->references('trademark_model_id')->on('trademark_models');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oils');
    }
};
