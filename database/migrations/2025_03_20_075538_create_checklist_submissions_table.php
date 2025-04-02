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
        Schema::create('checklist_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('checklist_id')->constrained('checklists');
            $table->foreignId('manager_id')->constrained('managers');
            $table->string('call_status');
            $table->dateTime('call_date_time');
            $table->string('client_phone');
            $table->integer('total_score');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('checklist_submissions');
    }
};
