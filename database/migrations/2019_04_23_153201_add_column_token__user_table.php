<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnTokenUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->increments('id')->change();
            $table->renameColumn('name','username');
            $table->string('email',191)->change();
            $table->boolean('active')->default(false);
            $table->integer('parent_id')->nullable()->unsigned();
            $table->foreign('parent_id')->references('id')->on('users');
            $table->boolean('is_super_admin')->default(false);
            $table->string('confirmation_code', 100)->nullable();
            $table->softDeletes();       
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function(Blueprint $table) {
            $table->renameColumn('username','name');
            $table->string('email')->change();
            $table->dropColumn('active');
            $table->dropColumn('is_super_admin');
            $table->dropColumn('confirmation_code');
            $table->dropSoftDeletes();
        });
    }
}
