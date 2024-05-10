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
        Schema::create('inspection_internals', static function (Blueprint $table) {
            $table->id('inspections_external_id');
            $table->uuid('inspections_external_uuid');
            $table->string('inspection_external')->comment('Internal inspection description');
            $table->longText('inspection_state')->comment('Internal inspection status');
            $table->unsignedBigInteger('inspection_id')->comment('Relation with inspection');
            $table->unsignedBigInteger('ct_inspection_section_id')->comment('Relation with inspection section');
            $table->unsignedBigInteger('ct_inspection_internal_id')->comment('Relation with inspection internal');
            $table->timestamps();
            $table->softDeletes();
            //INDEX
            $table->index('inspections_external_uuid');
            $table->index('ct_inspection_section_id');
            $table->index('ct_inspection_internal_id');
            $table->index('inspection_id');
            //FOREIGN KEYS
            $table->foreign('ct_inspection_section_id', 'fk_internal_inspection_section')
                ->references('ct_inspection_section_id')->on('ct_inspection_sections');
            $table->foreign('ct_inspection_internal_id', 'fk_internal_ct_inspection')
                ->references('ct_inspection_internal_id')->on('ct_inspection_internals');
            $table->foreign('inspection_id', 'fk_internal_inspection')
                ->references('inspection_id')->on('inspections');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspection_internals');
    }
};
