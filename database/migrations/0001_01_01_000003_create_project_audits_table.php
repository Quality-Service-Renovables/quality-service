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
        Schema::create('project_audits', static function (Blueprint $table) {
            $table->id('project_audit_id');
            $table->uuid('project_audit_uuid');
            $table->unsignedBigInteger('project_id')->comment('Relation with inspection');
            $table->unsignedBigInteger('status_id')->comment('Relation with status');
            $table->unsignedBigInteger('application_log_id')->comment('Relation with application log');
            $table->longText('comments')->nullable();
            $table->timestamps();
            $table->softDeletes();
            //INDEX
            $table->index('project_audit_uuid');
            $table->index('project_id');
            $table->index('status_id');
            $table->index('application_log_id');
            //FOREIGN KEYS
            // Inspection Relation
            $table->foreign('project_id', 'fk_project_audits_project')
                ->references('project_id')->on('projects');
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
