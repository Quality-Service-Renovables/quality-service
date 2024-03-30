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
        Schema::create('status', static function (Blueprint $table) {
            $table->id('id_status');
            $table->string('status');
            $table->string('code');
            $table->string('description');
            $table->unsignedBigInteger('client_id');
            $table->boolean('active');
            $table->timestamps();
            $table->softDeletes();
            //INDEX
            $table->index(['client_id']);
            //FOREIGN KEYS
            $table->foreign('client_id', 'fk_status_client')
                ->references('client_id')
                ->on('clients');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('status');
    }
};
