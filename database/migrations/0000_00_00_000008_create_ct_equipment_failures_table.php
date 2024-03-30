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
        Schema::create('ct_equipment_failures', static function (Blueprint $table) {
            $table->id('ct_equipment_failure');
            $table->uuid('ct_equipment_failure_uuid');
            $table->string('ct_failure_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ct_equipment_failures');
    }
};
