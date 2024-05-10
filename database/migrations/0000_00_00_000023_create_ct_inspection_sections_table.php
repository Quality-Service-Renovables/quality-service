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
        Schema::create('ct_inspection_sections', static function (Blueprint $table) {
            $table->id('ct_inspection_section_id');
            $table->uuid('ct_inspection_section_uuid');
            $table->string('ct_inspection_section');
            $table->unsignedBigInteger('ct_inspection_id')->comment('Relation with inspection categories');
            $table->timestamps();
            $table->softDeletes();
            //INDEX
            $table->index('ct_inspection_id');
            //FOREIGN KEYS
            $table->foreign('ct_inspection_id', 'fk_section_category')
                ->references('ct_inspection_id')->on('ct_inspections');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ct_inspection_sections');
    }
};
