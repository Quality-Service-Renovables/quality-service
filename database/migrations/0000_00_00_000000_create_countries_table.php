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
        Schema::create('countries', static function (Blueprint $table) {
            $table->id('country_id');
            $table->uuid('country_uuid');
            $table->string('country')->unique();
            $table->string('country_code')->unique();
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            //INDEX
            $table->index(['country_uuid']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
