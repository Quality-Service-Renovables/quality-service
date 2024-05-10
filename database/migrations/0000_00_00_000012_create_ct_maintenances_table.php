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
        Schema::create('ct_maintenances', static function (Blueprint $table) {
            $table->id('ct_maintenance_id');
            $table->uuid('ct_maintenance_uuid');
            $table->string('ct_maintenance');
            $table->string('ct_maintenance_code');
            $table->longText('description')->nullable();
            $table->boolean('is_default')->default(false);
            $table->unsignedBigInteger('dependency')->nullable();
            $table->bigInteger('level')->default(1);
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            //INDEX
            $table->index('ct_maintenance_uuid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ct_maintenances');
    }
};
