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
        Schema::create('equipment_failures', static function (Blueprint $table) {
            $table->id('equipment_failure_id');
            $table->uuid('equipment_failure_uuid');
            $table->unsignedBigInteger('equipment_id');
            $table->unsignedBigInteger('failure_id');
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            //INDEX
            $table->index('equipment_failure_uuid');
            $table->index('failure_id');
            //FOREIGN KEYS
            $table->foreign('failure_id', 'fk_equipment_failure')
                ->references('failure_id')
                ->on('failures');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_failures');
    }
};
