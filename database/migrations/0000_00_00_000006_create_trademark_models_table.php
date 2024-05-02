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
        Schema::create('trademark_models', static function (Blueprint $table) {
            $table->id('trademark_model_id');
            $table->uuid('trademark_model_uuid');
            $table->string('trademark_model');
            $table->string('trademark_model_code');
            $table->boolean('active')->default(true);
            $table->unsignedBigInteger('trademark_id');
            $table->timestamps();
            $table->softDeletes();
            //INDEX
            $table->index(['trademark_model_uuid']);
            $table->index(['trademark_id']);
            //FOREIGN KEYS
            $table->foreign('trademark_id', 'fk_model_trademark')
                ->references('trademark_id')
                ->on('trademarks');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trademark_models');
    }
};
