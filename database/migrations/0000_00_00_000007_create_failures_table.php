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
            $table->string('failure');
            $table->string('failure_code');
            $table->longText('description')->nullable()->comment('Failure description');
            $table->boolean('active')->default(true);
            $table->unsignedBigInteger('ct_failure_id')->comment('Relation with failure category');
            $table->timestamps();
            $table->softDeletes();
            //INDEX
            $table->index('failure_uuid');
            $table->index('ct_failure_id');
            //FOREIGN KEYS
            $table->foreign('ct_failure_id', 'fk_ct_failure')
                ->references('ct_failure_id')
                ->on('ct_failures');
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
