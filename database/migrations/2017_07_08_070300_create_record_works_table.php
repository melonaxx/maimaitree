<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRecordWorksTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('record_works', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uid')->unsigned();                        //用户ID
            $table->tinyInteger('type')->unsigned()->default(1);       //类型
            $table->tinyInteger('classify')->unsigned()->default(101); //分类
            $table->integer('salary')->default(0);                     //工资
            $table->string('remark')->default('');                     //备注
            $table->timestamp('date')->nullable();                     //记录日期（天）
            $table->string('work_time')->default('');                  //工作时长
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
        Schema::drop('record_works');
    }
}
