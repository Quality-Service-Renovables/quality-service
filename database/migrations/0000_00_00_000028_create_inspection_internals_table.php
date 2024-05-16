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
            $table->id('inspection_internal_id');
            $table->uuid('inspection_internal_uuid');
            $table->string('evaluation')->comment('Internal inspection evaluation');
            $table->longText('notes')->comment('Internal inspection notes');
            $table->unsignedBigInteger('inspection_id')->comment('Relation with inspection');
            $table->unsignedBigInteger('ct_inspection_section_id')->comment('Relation with inspection section');
            $table->unsignedBigInteger('ct_inspection_internal_id')->comment('Relation with inspection internal');
            $table->timestamps();
            $table->softDeletes();
            //INDEX
            $table->index('inspection_internal_uuid');
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
