<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ResultStars extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('result_stars', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('result_id')->nullable()->unsigned();
            $table->integer('gold')->default(0);
            $table->integer('silver')->default(0);
            $table->integer('brown')->default(0);
            $table->enum('medal',['gold','silver','brown'])->nullable()->default('brown');
            $table->enum('status',array('default','active','revision'))->default('active');

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
        Schema::dropIfExists('result_stars');
    }
}
