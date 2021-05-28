<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable()->unsigned();
            $table->integer('category_id')->nullable()->unsigned();
            $table->enum('type',array('default','semi','final'))->default('default');
            $table->integer('generated_by')->nullable()->unsigned();
            $table->enum('status',array('default','active','revision'))->default('active');
            $table->float('total')->nullable();
            $table->float('rank')->nullable();
            $table->integer("total_star")->nullable()->unsigned();
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
        Schema::dropIfExists('results');
    }
}
