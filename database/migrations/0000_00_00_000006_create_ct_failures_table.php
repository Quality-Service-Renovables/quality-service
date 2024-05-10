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
        Schema::create('ct_failures', static function (Blueprint $table) {
            $table->id('ct_failure_id');
            $table->uuid('ct_failure_uuid');
            $table->string('ct_failure');
            $table->string('ct_failure_code');
            $table->longText('description')->nullable()->comment('Failure description');
            $table->boolean('is_default')->default(false);
            $table->unsignedBigInteger('dependency')->nullable();
            $table->bigInteger('level')->default(1);
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            //INDEX
            $table->index(['ct_failure_uuid']);
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
