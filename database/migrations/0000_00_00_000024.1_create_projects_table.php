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
        Schema::create('projects', static function (Blueprint $table) {
            $table->id('project_id');
            $table->uuid('project_uuid');
            $table->string('project_name');
            $table->string('description')->nullable();
            $table->unsignedBigInteger('client_id')->comment('Relation with client');
            $table->unsignedBigInteger('status_id')->comment('Relation with status');
            $table->timestamps();
            $table->softDeletes();
            //INDEX
            $table->index('client_id');
            //FOREIGN KEYS
            $table->foreign('client_id', 'fk_project_client')
                ->references('client_id')->on('clients');
            $table->foreign('status_id', 'fk_project_status')
                ->references('status_id')->on('status');
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
