<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('category_user', function (Blueprint $table) {
            $table->integer('category_id')->nullable()->unsigned();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->integer('user_id')->nullable()->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
//            $table->primary(['category_id','user_id']);

            $table->integer('country_id')->nullable()->unsigned();
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->enum('type', ['candidate','semi', 'final','other'])->default('semi');
            $table->integer('num_form')->default(0);
            $table->primary(['category_id','user_id','country_id','type']);
            $table->timestamps();
        });
        
//        Schema::disableForeignKeyConstraints();
//        Schema::table('category_user', function (Blueprint $table) {
//            $table->unique(['category_id','user_id']);
//            $table->dropPrimary('PRIMARY');
//            $table->primary(['category_id','user_id','type']);
//            $table->dropUnique(['category_id','user_id']);
//        });
        Schema::enableForeignKeyConstraints();

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('category_user');
    }
}
