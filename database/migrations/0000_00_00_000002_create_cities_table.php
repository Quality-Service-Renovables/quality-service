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
        Schema::create('cities', static function (Blueprint $table) {
            $table->id('city_id');
            $table->uuid('city_uuid');
            $table->string('name')->unique();
            $table->string('code_name')->unique()->nullable();
            $table->boolean('active')->default(1);
            $table->unsignedBigInteger('state_id');
            $table->timestamps();
            $table->softDeletes();
            //INDEX
            $table->index(['city_uuid', 'state_id']);
            //FOREIGN KEYS
            $table->foreign('state_id', 'fk_city_country')
                ->references('state_id')
                ->on('states');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};
