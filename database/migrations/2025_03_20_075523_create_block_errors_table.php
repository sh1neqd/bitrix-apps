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
        Schema::create('block_errors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('block_id')->constrained('checklist_blocks');
            $table->foreignId('error_id')->constrained('errors');
            $table->string('timing')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('block_errors');
    }
};
