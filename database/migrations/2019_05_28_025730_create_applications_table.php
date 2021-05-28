<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable()->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('website')->nullable();
            $table->string('email')->nullable();
            $table->string('company_name')->nullable();
            $table->longText('company_profile')->nullable();
            $table->string('ceo_name')->nullable();
            $table->string('ceo_email')->nullable();
            $table->string('contact_name')->nullable();
            $table->string('contact_position')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('product_name')->nullable();
            $table->longText('product_description')->nullable();
            $table->longText('product_uniqueness')->nullable();
            $table->longText('product_quality')->nullable();
            $table->longText('product_market')->nullable();
            $table->longText('business_model')->nullable();
            $table->enum('status',array('draft','pending','accepted','review','finalize','comment'))->default('draft');
            $table->string('video_demo')->nullable();
            $table->integer('approved_by')->nullable()->unsigned();
            $table->foreign('approved_by')->references('id')->on('users');
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
        Schema::dropIfExists('applications');
    }
}
