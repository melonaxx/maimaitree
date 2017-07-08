<?php

/*小程序-记工表*/
Schema::create('record_works', function (Blueprint $table) {
    $table->increments('id');
    $table->integer('uid');                                  //用户ID
    $table->tinyInteger('type')->default(1);                 //类型
    $table->tinyInteger('classify')->default(1);             //分类
    $table->integer('salary')->default(0);                   //工资
    $table->string('remark')->default('');                   //备注
    $table->timestamp('date')->nullable();                   //记录日期（天）
    $table->string('work_time')->default('');                //工作时长
    $table->timestamps();
    $table->softDeletes();
});

/*小程序-用户表*/
Schema::create('record_user', function (Blueprint $table) {
    $table->increments('id');
    $table->string('uname', 64)->default('');                 //用户ID
    $table->string('nick_name', 64)->default('');             //用户ID
    $table->tinyInteger('gender')->default('');               //性别
    $table->string('daily_salary')->default(0);               //单日工资
    $table->string('tel', 32)->default('');                   //电话
    $table->string('country', 32)->default('');               //国家
    $table->string('province', 32)->default('');              //省份
    $table->string('city', 32)->default('');                  //城市
    $table->timestamps();
    $table->softDeletes();
});

