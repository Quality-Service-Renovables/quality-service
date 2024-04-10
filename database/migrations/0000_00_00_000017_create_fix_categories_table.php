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
        Schema::create('fix_categories', static function (Blueprint $table) {
            $table->id('fix_category_id');
            $table->uuid('fix_category_uuid');
            $table->string('fix_category')->unique();
            $table->string('fix_category_code')->unique();
            $table->longText('description')->nullable();
            $table->boolean('is_default')->default(true);
            $table->unsignedBigInteger('dependency')->nullable();
            $table->bigInteger('level')->default(1);
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            //INDEX
            $table->index('fix_category_uuid');
            $table->index('dependency');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fix_categories');
    }
};
