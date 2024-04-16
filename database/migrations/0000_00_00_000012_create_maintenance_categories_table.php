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
        Schema::create('maintenance_categories', static function (Blueprint $table) {
            $table->id('maintenance_category_id');
            $table->uuid('maintenance_category_uuid');
            $table->string('maintenance_category');
            $table->string('maintenance_category_code');
            $table->longText('description')->nullable();
            $table->boolean('is_default')->default(true);
            $table->unsignedBigInteger('dependency')->nullable();
            $table->bigInteger('level')->default(1);
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            //INDEX
            $table->index('maintenance_category_uuid');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_categories');
    }
};
