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
        Schema::create('client_configurations', static function (Blueprint $table) {
            $table->id('client_configuration_id');
            $table->uuid('client_configuration_uuid');
            $table->unsignedBigInteger('client_id');
            $table->boolean('send_email')->default(false);
            $table->boolean('invoice_required')->default(false);
            $table->boolean('send_client_report')->default(false);
            $table->boolean('crypt_report')->default(false);
            $table->string('key_report')->nullable();
            $table->timestamps();
            $table->softDeletes();
            //INDEX
            $table->index('client_configuration_uuid');
            $table->index('client_id');
            //FOREIGN KEYS
            $table->foreign('client_id', 'fk_client_configuration_client')
                ->references('client_id')->on('clients');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_configurations');
    }
};
