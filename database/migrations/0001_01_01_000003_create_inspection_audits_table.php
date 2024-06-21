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
        Schema::create('inspection_audits', static function (Blueprint $table) {
            $table->id('inspection_audit_id');
            $table->uuid('inspection_audit_uuid');
            $table->unsignedBigInteger('inspection_id')->comment('Relation with inspection');
            $table->unsignedBigInteger('status_id')->comment('Relation with status');
            $table->unsignedBigInteger('application_log_id')->comment('Relation with application log');
            $table->longText('comments')->nullable();
            $table->timestamps();
            $table->softDeletes();
            //INDEX
            $table->index('inspection_audit_uuid');
            $table->index('inspection_id');
            $table->index('status_id');
            $table->index('application_log_id');
            //FOREIGN KEYS
            // Inspection Relation
            $table->foreign('inspection_id', 'fk_inspection_audits_inspection')
                ->references('inspection_id')->on('inspections');
            // Status relation
            $table->foreign('status_id', 'fk_inspection_audits_status')
                ->references('status_id')->on('status');
            // Log Relation
            $table->foreign('application_log_id', 'fk_inspection_audits_log')
                ->references('application_log_id')->on('application_logs');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspection_audits');
    }
};
