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
        Schema::create('failure_categories', static function (Blueprint $table) {
            $table->id('failure_category_id');
            $table->uuid('failure_category_uuid');
            $table->string('failure_category')->unique();
            $table->string('failure_category_code')->unique();
            $table->boolean('is_default')->default(true);
            $table->bigInteger('level')->default(1);
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            //INDEX
            $table->index(['failure_category_uuid']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('failures_categories');
    }
};
