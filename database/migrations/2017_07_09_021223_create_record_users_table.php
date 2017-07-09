<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRecordUsersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('record_users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('openid', 32);                          //wx openid
            $table->string('uname', 64)->default('');              //用户ID
            $table->string('nick_name', 64)->default('');          //用户nike
            $table->tinyInteger('gender')->unsigned()->default(0); //性别 0:未知1:男2:女
            $table->integer('daily_salary')->default(0);           //单日工资
            $table->string('tel', 32)->default('');                //电话
            $table->string('country', 32)->default('');            //国家
            $table->string('province', 32)->default('');           //省份
            $table->string('city', 32)->default('');               //城市
            $table->timestamps();
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
        Schema::drop('record_users');
    }
}
