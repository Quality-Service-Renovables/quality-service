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
        Schema::create('trademarks', static function (Blueprint $table) {
            $table->id('trademark_id');
            $table->uuid('trademark_uuid');
            $table->string('trademark');
            $table->string('trademark_code');
            $table->unsignedBigInteger('ct_trademark_id');
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            //INDEX
            $table->index(['trademark_uuid']);
            $table->index(['ct_trademark_id']);
            //FOREIGN KEYS
            $table->foreign('ct_trademark_id', 'fk_ct_trademark')
                ->references('ct_trademark_id')
                ->on('ct_trademarks');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trademarks');
    }
};
