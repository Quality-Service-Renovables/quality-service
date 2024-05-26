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
        Schema::create('inspection_forms', static function (Blueprint $table) {
            $table->id('inspection_form_id');
            $table->uuid('inspection_form_uuid');
            $table->string('inspection_form_code')->unique();
            $table->string('inspection_form_value');
            $table->string('inspection_form_comments')->nullable();
            $table->unsignedBigInteger('inspection_id')->comment('Relation with inspection');
            $table->unsignedBigInteger('ct_inspection_form_id')->comment('Relation with catalog form inspection');
            $table->timestamps();
            $table->softDeletes();
            //INDEX
            $table->index('inspection_id');
            $table->index('inspection_form_uuid');
            $table->index('ct_inspection_form_id');
            //FOREIGN KEYS
            $table->foreign('inspection_id', 'fk_inspection_form_inspection')
                ->references('inspection_id')->on('inspections');
            $table->foreign('ct_inspection_form_id', 'fk_form_category')
                ->references('ct_inspection_form_id')->on('ct_inspection_forms');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspection_forms');
    }
};
