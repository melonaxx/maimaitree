<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCarpoolsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carpools', function (Blueprint $table) {
            $table->increments('id');//ID
            $table->string('uid');//用户ID
            $table->string('name', 32)->default('');//用户名
            $table->tinyInteger('sex')->unsigned()->default(0);//性别
            $table->string('phone')->default('');//电话
            $table->tinyInteger('type')->unsigned()->default(0);//拼车类型
            $table->string('origin', 64)->default('');//出发地
            $table->string('origin_cross', 255)->default('');//出发地经纬度
            $table->string('by_way', 64)->default('');//途径地
            $table->string('terminal', 64)->default('');//目的地
            $table->string('terminal_cross', 255)->default('');//目的地经纬度
            $table->integer('time')->unsigned()->default(0);//出发时间
            $table->integer('number')->unsigned()->default(0);//空座
            $table->integer('price')->unsigned()->default(0);//价格
            $table->string('license', 64)->default('');//车牌
            $table->string('car_type', 64)->default('');//车型
            $table->string('volume', 64)->default('');//容积
            $table->integer('weight')->unsigned()->default(0);//承重
            $table->tinyInteger('frequency')->unsigned()->default(0);//撞车频次
            $table->string('remark')->default('');//备注
            $table->tinyInteger('relief')->unsigned()->default(1);//免责条款
            $table->integer('watch')->unsigned()->default(0);//观看次数
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
        Schema::drop('carpools');
    }
}
