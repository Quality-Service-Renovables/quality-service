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
        Schema::create('ct_inspection_externals', static function (Blueprint $table) {
            $table->id('ct_inspection_external_id');
            $table->uuid('ct_inspection_external_uuid');
            $table->string('inspection_external')->comment('External inspection description');
            $table->unsignedBigInteger('ct_inspection_id')->comment('Relation with inspection category');
            $table->unsignedBigInteger('ct_inspection_section_id')->comment('Relation with inspection section');
            $table->timestamps();
            $table->softDeletes();
            //INDEX
            $table->index('ct_inspection_id');
            $table->index('ct_inspection_section_id');
            //FOREIGN KEYS
            $table->foreign('ct_inspection_id', 'fk_external_category')
                ->references('ct_inspection_id')->on('ct_inspections');
            $table->foreign('ct_inspection_section_id', 'fk_external_section')
                ->references('ct_inspection_section_id')->on('ct_inspection_sections');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ct_inspection_externals');
    }
};
