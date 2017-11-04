<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');//用户ID
            $table->string('openid');//openID
            $table->string('name', 32)->default('');//用户名
            $table->string('nickname', 32)->default('');//昵称
            $table->tinyInteger('sex')->unsigned()->default(0);//性别
            $table->tinyInteger('age')->unsigned()->default(0);//年龄
            $table->string('phone',32)->default('');//电话
            $table->string('country', 64)->default('');//国家
            $table->string('province', 64)->default('');//省份
            $table->string('city', 64)->default('');//城市
            $table->string('avatar', 64)->default('');//头像
            $table->string('source', 64)->default('');//来源
            $table->tinyInteger('status')->unsigned()->default(1);//状态
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
        Schema::drop('users');
    }
}
