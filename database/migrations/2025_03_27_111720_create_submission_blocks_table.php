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
        Schema::create('submission_blocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained('checklist_submissions')->onDelete('cascade');
            $table->foreignId('block_id')->constrained('checklist_blocks')->onDelete('cascade');
            $table->boolean('checked')->default(false);
            $table->text('comment')->nullable();
            $table->integer('score')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('submission_blocks');
    }
};
