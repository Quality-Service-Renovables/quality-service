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
        Schema::create('failures', static function (Blueprint $table) {
            $table->id('failure_id');
            $table->uuid('failure_uuid');
            $table->string('failure')->unique();
            $table->string('failure_code')->unique();
            $table->boolean('active')->default(1);
            $table->unsignedBigInteger('failure_category_id');
            $table->timestamps();
            $table->softDeletes();
            //INDEX
            $table->index('failure_uuid');
            $table->index('failure_category_id');
            //FOREIGN KEYS
            $table->foreign('failure_category_id', 'fk_failure_failure_category')
                ->references('failure_category_id')
                ->on('failure_categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('failures');
    }
};
