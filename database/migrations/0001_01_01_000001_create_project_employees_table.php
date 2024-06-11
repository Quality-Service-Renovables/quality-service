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
        Schema::create('project_employees', static function (Blueprint $table) {
            $table->id('project_employee_id');
            $table->uuid('project_employee_uuid');
            $table->unsignedBigInteger('user_id')->comment('Relation with user technical profile');
            $table->unsignedBigInteger('project_id')->comment('Relation with projects');
            $table->timestamps();
            $table->softDeletes();
            //INDEX
            $table->index('project_employee_uuid');
            $table->index('user_id');
            $table->index('project_id');
            //FOREIGN KEYS
            $table->foreign('user_id', 'fk_employee_user')
                ->references('id')->on('users');
            $table->foreign('project_id', 'fk_employee_project')
                ->references('project_id')->on('projects');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_employees');
    }
};
