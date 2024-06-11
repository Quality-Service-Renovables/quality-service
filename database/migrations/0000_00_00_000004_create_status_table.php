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
            $table->id('status_id');
            $table->uuid('status_uuid');
            $table->string('status');
            $table->string('status_code');
            $table->longText('description');
            $table->boolean('active')->default(true);
            $table->unsignedBigInteger('ct_status_id')->comment('Relation with status category');
            $table->timestamps();
            $table->softDeletes();
            //INDEX
            $table->index(['status_uuid']);
            $table->index('ct_status_id');
            //FOREIGN KEYS
            $table->foreign('ct_status_id', 'fk_status_category')
                ->references('ct_status_id')->on('ct_status');
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
