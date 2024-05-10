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
        Schema::create('ct_fixs', static function (Blueprint $table) {
            $table->id('ct_fix_id');
            $table->uuid('ct_fix_uuid');
            $table->string('ct_fix');
            $table->string('ct_fix_code');
            $table->longText('description')->nullable();
            $table->boolean('is_default')->default(false);
            $table->unsignedBigInteger('dependency')->nullable();
            $table->bigInteger('level')->default(1);
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            //INDEX
            $table->index('ct_fix_uuid');
            $table->index('dependency');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ct_fixs');
    }
};
