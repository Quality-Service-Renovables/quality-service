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
        Schema::create('clients', static function (Blueprint $table) {
            $table->id('client_id');
            $table->uuid('client_uuid');
            $table->string('name')->unique();
            $table->string('legal_name')->unique()->nullable();
            $table->string('address')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('website')->nullable();
            $table->string('email')->unique()->nullable();
            $table->boolean('active')->default(1);
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('state_id');
            $table->string('logo')->nullable();
            $table->timestamps();
            $table->softDeletes();
            //INDEX
            $table->index(['country_id', 'state_id', 'city_id']);
            //FOREIGN KEYS
            $table->foreign('country_id', 'fk_client_country')
                ->references('country_id')
                ->on('countries');
            $table->foreign('state_id', 'fk_client_state')
                ->references('state_id')
                ->on('states');
            $table->foreign('city_id', 'fk_client_city')
                ->references('city_id')
                ->on('cities');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
