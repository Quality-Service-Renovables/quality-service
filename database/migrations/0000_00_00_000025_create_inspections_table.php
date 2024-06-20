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
            $table->unsignedBigInteger('equipment_id')->comment('Relation with equipment');
            $table->unsignedBigInteger('client_id')->comment('Relation with client');
            $table->unsignedBigInteger('status_id')->comment('Relation with status');
            $table->unsignedBigInteger('project_id')->comment('Relation with proyects');
            $table->timestamps();
            $table->softDeletes();
            //INDEX
            $table->index('inspection_uuid');
            $table->index('ct_inspection_id');
            $table->index('equipment_id');
            $table->index('client_id');
            $table->index('status_id');
            $table->index('project_id');
            //FOREIGN KEYS
            $table->foreign('ct_inspection_id', 'fk_ct_inspection')
                ->references('ct_inspection_id')->on('ct_inspections');
            $table->foreign('equipment_id', 'fk_inspecion_equipment')
                ->references('equipment_id')->on('equipments');
            $table->foreign('client_id', 'fk_inspeciont_client')
                ->references('client_id')->on('clients');
            $table->foreign('status_id', 'fk_inspection_status')
                ->references('status_id')->on('status');
            $table->foreign('project_id', 'fk_inspection_project')
                ->references('project_id')->on('projects');
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
