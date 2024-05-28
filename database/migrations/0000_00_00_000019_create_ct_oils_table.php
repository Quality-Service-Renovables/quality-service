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
        Schema::create('ct_oils', static function (Blueprint $table) {
            $table->id('ct_oil_id');
            $table->uuid('ct_oil_uuid');
            $table->string('ct_oil');
            $table->string('ct_oil_code');
            $table->longText('description')->nullable()->comment('Oil Category Description');
            $table->boolean('is_default')->default(false);
            $table->unsignedBigInteger('dependency')->nullable();
            $table->bigInteger('level')->default(1);
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            //INDEX
            $table->index('ct_oil_uuid');
            $table->index('dependency');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ct_oils');
    }
};
