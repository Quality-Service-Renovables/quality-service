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
        Schema::create('application_logs', static function (Blueprint $table) {
            $table->id('application_logs_id');
            $table->uuid('application_logs_uuid');
            $table->string('request_url');
            $table->json('request_received');
            $table->json('request_response')->nullable();
            $table->string('module');
            $table->longText('description');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
            $table->softDeletes();
            //INDEX
            $table->index('user_id');
            //FOREIGN KEYS
            $table->foreign('user_id', 'fk_log_user')
                ->references('id')
                ->on('users');
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
