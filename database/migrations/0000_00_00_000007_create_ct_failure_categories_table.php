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
        Schema::create('ct_failures_categories', static function (Blueprint $table) {
            $table->id('failure_category_id');
            $table->uuid('failure_category_uuid');
            $table->string('description');
            $table->boolean('active')->default(1);
            $table->integer('level');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ct_failures_categories');
    }
};
