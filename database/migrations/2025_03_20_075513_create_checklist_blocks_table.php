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
        Schema::create('checklist_blocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('checklist_id')->constrained('checklists');
            $table->string('title');
            $table->integer('max_score');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('checklist_blocks');
    }
};
