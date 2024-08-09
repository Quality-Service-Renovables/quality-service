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
        Schema::create('ct_risks', function (Blueprint $table) {
            $table->id('ct_risk_id');
            $table->uuid('ct_risk_uuid');
            $table->string('ct_risk');
            $table->text('ct_description')->nullable();
            $table->text('ct_description_secondary')->nullable();
            $table->string('ct_color')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ct_risks');
    }
};
