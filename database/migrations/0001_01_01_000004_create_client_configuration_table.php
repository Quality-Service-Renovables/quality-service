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
        Schema::create('client_configuration', function (Blueprint $table) {
            $table->id('client_configuration_id');
            $table->uuid('client_configuration_uuid');
            $table->unsignedBigInteger('client_id');
            $table->boolean('send_email');
            $table->boolean('invoice_required');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_configuration');
    }
};
