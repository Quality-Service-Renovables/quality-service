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
            $table->unsignedBigInteger('trademark_category_id');
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            //INDEX
            $table->index(['trademark_uuid']);
            $table->index(['trademark_category_id']);
            //FOREIGN KEYS
            $table->foreign('trademark_category_id', 'fk_trademark_category')
                ->references('trademark_category_id')
                ->on('trademark_categories');
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
