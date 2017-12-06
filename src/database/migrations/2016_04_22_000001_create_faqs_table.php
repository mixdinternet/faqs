<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFaqsTable extends Migration
{
    public function up()
    {
        Schema::create('faqs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('status', 8)->default('active');
            $table->boolean('star')->default(0);
            $table->string('name');
            $table->text('description');
            $table->tinyInteger('order')->nullable();
            $table->string('slug', 150)->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::drop('faqs');
    }
}
