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
        Schema::create('errors', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->integer('weight');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('errors');
    }
};
