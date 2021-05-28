<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('application_id')->nullable()->unsigned();
            $table->foreign('application_id')->references('id')->on('applications');
            $table->string('youtube_id')->nullable()->unique();
            $table->string('path')->unique();
            $table->string('mine_type')->nullable();
            $table->enum('status',array('host','achieved','youtube'))->default('host');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('video');
    }
}
