<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->dateTime('post_date');
            $table->text('body');
            $table->string('password');
            $table->string('token');
            $table->string('email');
            $table->integer('author_gender');
            $table->string('post_type');
            $table->integer('post_visits');
            $table->string('category');
            $table->string('category_short');
            $table->boolean('is_private');
            $table->string('ext1');
            $table->string('ext2');
            $table->string('ext3');
            $table->string('ext4');
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
        Schema::dropIfExists('tests');
    }
}
