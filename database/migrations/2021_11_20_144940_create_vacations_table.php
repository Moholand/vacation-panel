<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vacations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('request_message');
            $table->text('response_message')->nullable();
            $table->enum('status', ['submitted', 'initial-approval', 'confirmed', 'refuse'])->default('submitted');
            $table->enum('type', ['deserved', 'emergency'])->default('deserved');
            $table->enum('mode', ['daily', 'hourly'])->default('daily');
            $table->bigInteger('user_id')->unsigned();
            $table->date('from_date');
            $table->date('to_date')->nullable();
            $table->string('from_hour')->nullable();
            $table->string('to_hour')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vacations');
    }
}
