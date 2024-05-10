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
        Schema::create('inspection_externals', static function (Blueprint $table) {
            $table->id('inspections_external_id');
            $table->uuid('inspections_external_uuid');
            $table->unsignedBigInteger('inspection_section_id');
            $table->string('inspection_external')->comment('External inspection description');
            $table->longText('inspection_state')->comment('External inspection status');
            $table->unsignedBigInteger('inspection_id')->comment('Relation with inspection');
            $table->unsignedBigInteger('ct_inspection_section_id')->comment('Relation with inspection section');
            $table->unsignedBigInteger('ct_inspection_external_id')->comment('Relation with inspection external');
            $table->timestamps();
            $table->softDeletes();
            //INDEX
            $table->index('inspections_external_uuid');
            $table->index('ct_inspection_section_id');
            $table->index('ct_inspection_external_id');
            $table->index('inspection_id');
            //FOREIGN KEYS
            $table->foreign('ct_inspection_section_id', 'fk_external_ins_section')
                ->references('ct_inspection_section_id')->on('ct_inspection_sections');
            $table->foreign('ct_inspection_external_id', 'fk_external_ins_category')
                ->references('ct_inspection_external_id')->on('ct_inspection_externals');
            $table->foreign('inspection_id', 'fk_external_inspection')
                ->references('inspection_id')->on('inspections');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspection_externals');
    }
};
