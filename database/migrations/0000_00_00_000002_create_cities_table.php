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
            $table->string('city')->unique();
            $table->string('city_code')->unique();
            $table->boolean('active')->default(true);
            $table->unsignedBigInteger('state_id');
            $table->timestamps();
            $table->softDeletes();
            //INDEX
            $table->index(['state_id','city_uuid']);
            //FOREIGN KEYS
            $table->foreign('state_id', 'fk_city_state')
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
