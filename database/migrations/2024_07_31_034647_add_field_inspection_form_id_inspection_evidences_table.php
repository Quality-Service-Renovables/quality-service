<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('inspection_evidences', function (Blueprint $table) {
            $table->unsignedBigInteger('inspection_form_id')
                ->after('inspection_id')
                ->comment('Relation with inspection form');
            //INDEX
            $table->index('inspection_form_id');
            //FOREIGN KEYS
            $table->foreign('inspection_form_id', 'fk_inspection_form_evidences')
                ->references('inspection_form_id')
                ->on('inspection_forms');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inspections', function (Blueprint $table) {
            $table->dropColumn('inspection_form_id');
        });
    }
};
