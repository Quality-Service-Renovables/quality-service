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
        Schema::create('ct_inspection_forms', static function (Blueprint $table) {
            $table->id('ct_inspection_form_id');
            $table->uuid('ct_inspection_form_uuid');
            $table->string('ct_inspection_form');
            $table->string('ct_inspection_form_code')->unique();
            $table->unsignedBigInteger('ct_inspection_section_id')->comment('Relation with sub inspection section');
            $table->boolean('required')->default(true);
            $table->timestamps();
            $table->softDeletes();
            //INDEX
            $table->index('ct_inspection_form_uuid');
            $table->index('ct_inspection_section_id');
            //FOREIGN KEYS
            $table->foreign('ct_inspection_section_id', 'fk_form_section')
                ->references('ct_inspection_section_id')->on('ct_inspection_sections');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ct_inspection_forms');
    }
};
