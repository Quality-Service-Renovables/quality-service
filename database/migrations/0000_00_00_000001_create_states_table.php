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
        Schema::create('states', static function (Blueprint $table) {
            $table->id('state_id');
            $table->uuid('state_uuid');
            $table->string('name')->unique();
            $table->string('code_name')->unique()->nullable();
            $table->boolean('active')->default(1);
            $table->unsignedBigInteger('country_id');
            $table->timestamps();
            $table->softDeletes();
            //INDEX
            $table->index(['state_uuid', 'country_id']);
            //FOREIGN KEYS
            $table->foreign('country_id', 'fk_state_country')
                ->references('country_id')
                ->on('countries');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('states');
    }
};
