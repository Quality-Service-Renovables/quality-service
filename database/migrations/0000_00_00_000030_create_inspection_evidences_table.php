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
        Schema::create('inspection_evidences', static function (Blueprint $table) {
            $table->id('inspections_evidence_id');
            $table->uuid('inspections_evidence_uuid');
            $table->string('inspection_evidence');
            $table->string('inspection_evidence_secondary');
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->unsignedBigInteger('inspection_id')->comment('Relation with inspection');
            $table->timestamps();
            $table->softDeletes();
            //INDEX
            $table->index('inspection_id');
            //FOREIGN KEYS
            $table->foreign('inspection_id', 'fk_evidence_inspection')
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
