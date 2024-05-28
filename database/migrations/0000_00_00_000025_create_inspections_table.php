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
        Schema::create('inspections', static function (Blueprint $table) {
            $table->id('inspection_id');
            $table->uuid('inspection_uuid');
            $table->longText('resume')->nullable()->comment('Resume inspection');
            $table->longText('conclusion')->nullable()->comment('Technical conclusion');
            $table->longText('recomendations')->nullable()->comment('Recomendations');
            $table->unsignedBigInteger('ct_inspection_id')->comment('Relation with inspection category');
            $table->timestamps();
            $table->softDeletes();
            //INDEX
            $table->index('ct_inspection_id');
            //FOREIGN KEYS
            $table->foreign('ct_inspection_id', 'fk_ct_inspection')
                ->references('ct_inspection_id')->on('ct_inspections');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspections');
    }
};
