<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSomeupsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('someups', function (Blueprint $table) {
            $table->increments('id');//ID
            $table->string('title')->default('');//说明
            $table->string('file_name')->default('');//文件名
            $table->string('source')->default('');//文件链接
            $table->integer('size')->unsigned()->default(0);//文件大小
            $table->string('ext')->default('');//扩展
            $table->tinyInteger('status')->unsigned()->default(0);//状态
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
        Schema::drop('someups');
    }
}
