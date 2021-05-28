<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJudgesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    /**
     * Run the migrations.
     * in is innovation
     * ps is problem solving
     * pv is public value
     * ti transparancy and iq
     * ef efficiency
     * pm performance
     * qt quality
     * rt reliability
     * op organization presentation
     * en enquiries
     * ms marketing strategy
     * cu customer
     * fi financial
     * ca competitive advantage
     * me market entry
     * sc scalability
     * tm team organization
     * sh stackholder
     * @return void
     */
    public function up()
    {
//        @todo: need to improve foreign key
        Schema::disableForeignKeyConstraints();
        Schema::create('judges', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('app_id')->nullable()->unsigned();
//            $table->foreign('app_id')->references('id')->on('applications')->onDelete('cascade');
            $table->integer('user_id')->nullable()->unsigned();
//            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('status')->nullable()->unsigned()->default(1);
            $table->integer('category_id')->nullable()->unsigned();
            $table->enum('type', array('semi','final'));
//            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->float('in')->nullable()->unsigned()->default(0.0);
            $table->float('ps')->nullable()->unsigned()->default(0.0);
            $table->float('pv')->nullable()->unsigned()->default(0.0);
            $table->float('ti')->nullable()->unsigned()->default(0.0);
            $table->float('ef')->nullable()->unsigned()->default(0.0);
            $table->float('pm')->nullable()->unsigned()->default(0.0);
            $table->float('qt')->nullable()->unsigned()->default(0.0);
            $table->float('rt')->nullable()->unsigned()->default(0.0);
            $table->float('op')->nullable()->unsigned()->default(0.0);
            $table->float('en')->nullable()->unsigned()->default(0.0);
            $table->float('ms')->nullable()->unsigned()->default(0.0);
            $table->float('ca')->nullable()->unsigned()->default(0.0);
            $table->float('cu')->nullable()->unsigned()->default(0.0);
            $table->float('fi')->nullable()->unsigned()->default(0.0);
            $table->float('me')->nullable()->unsigned()->default(0.0);
            $table->float('sc')->nullable()->unsigned()->default(0.0);
            $table->float('tm')->nullable()->unsigned()->default(0.0);
            $table->float('sh')->nullable()->unsigned()->default(0.0);
            $table->float('total')->nullable()->unsigned()->default(0.0);
            $table->integer('num_star')->unsigned()->default(0);
            $table->timestamps();
//            $table->softDeletes();
//            $table->index(['app_id','user_id','category_id','status']);
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('judges');
    }
}
