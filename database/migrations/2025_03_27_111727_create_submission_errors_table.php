<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('submission_errors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_block_id')->constrained('submission_blocks')->onDelete('cascade');
            $table->foreignId('error_id')->constrained('errors')->onDelete('cascade');
            $table->string('timing')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('submission_errors');
    }
};
