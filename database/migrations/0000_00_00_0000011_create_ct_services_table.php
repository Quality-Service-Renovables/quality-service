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
        Schema::create('ct_services', static function (Blueprint $table) {
            $table->id('ct_service_id');
            $table->uuid('ct_service_uuid');
            $table->string('ct_service');
            $table->string('ct_service_code');
            $table->longText('description')->nullable();
            $table->boolean('is_default')->default(false);
            $table->unsignedBigInteger('dependency')->nullable();
            $table->bigInteger('level')->default(1);
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            //INDEX
            $table->index('ct_service_uuid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ct_services');
    }
};
