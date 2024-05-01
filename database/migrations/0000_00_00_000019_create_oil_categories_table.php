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
        Schema::create('oil_categories', static function (Blueprint $table) {
            $table->id('oil_category_id');
            $table->uuid('oil_category_uuid');
            $table->string('oil_category');
            $table->string('oil_category_code');
            $table->longText('description')->nullable()->comment('Oil Category Description');
            $table->boolean('is_default')->default(false);
            $table->unsignedBigInteger('dependency')->nullable();
            $table->bigInteger('level')->default(1);
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            //INDEX
            $table->index('oil_category_uuid');
            $table->index('dependency');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('oil_categories');
    }
};
