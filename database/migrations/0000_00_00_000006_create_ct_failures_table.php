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
        Schema::create('ct_failures', static function (Blueprint $table) {
            $table->id('failure_id');
            $table->uuid('failure_uuid');
            $table->string('description');
            $table->boolean('active')->default(1);
            $table->unsignedBigInteger('ct_failure_category_id');
            $table->timestamps();
            $table->softDeletes();
            //INDEX
            $table->index(['ct_failure_category_id']);
            //FOREIGN KEYS
            $table->foreign('ct_failure_category_id', 'fk_ct_failure_ct_failure_category')
                ->references('ct_failure_category_id')
                ->on('ct_failure_categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ct_failures');
    }
};
