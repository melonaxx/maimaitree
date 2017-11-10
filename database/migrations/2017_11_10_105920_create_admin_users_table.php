<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAdminUsersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_users', function (Blueprint $table) {
            $table->increments('id')->commend('ID');
            $table->string('name', 125)->default('')->commend('用户名');
            $table->tinyInteger('sex')->default(0)->commend('性别 0->保密 1->男 2->女');
            $table->string('email', 125)->unique('users_email_unique')->commend('邮件');
            $table->string('mobile', 11)->nullable()->commend('手机号码');
            $table->string('password', 60)->commend('密码');
            $table->integer('creator')->unsigned()->default(0)->commend('创建者ID');
            $table->integer('channel')->unsigned()->default(0)->commend('后台用户渠道');
            $table->tinyInteger('status')->unsigned()->default(0)->commend('状态 0->正常 1->停用');
            $table->string('remember_token')->nullable()->commend('TOKEN');
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
        Schema::drop('admin_users');
    }
}
