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
        Schema::create('inspection_sections', static function (Blueprint $table) {
            $table->id('inspection_section_id');
            $table->uuid('inspection_section_uuid');
            $table->string('inspection_section');
            $table->unsignedBigInteger('ct_inspection_section_id')
                ->comment('Relation with inspection section category');
            $table->unsignedBigInteger('inspection_id')
                ->comment('Relation with inspection');
            $table->timestamps();
            $table->softDeletes();
            //INDEX
            $table->index('ct_inspection_section_id');
            $table->index('inspection_id');
            //FOREIGN KEYS
            $table->foreign('ct_inspection_section_id', 'fk_section_ct_inspection')
                ->references('ct_inspection_section_id')->on('ct_inspection_sections');
            $table->foreign('inspection_id', 'fk_section_inspection')
                ->references('inspection_id')->on('inspections');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspection_sections');
    }
};
