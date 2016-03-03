<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('slug');
            $table->string('layout', 30)->nullable();
            $table->string('entity', 30)->nullable();
            $table->string('scope', 10)->nullable();
            $table->text('content')->nullable();
            $table->text('description')->nullable();
            $table->string('status');
            $table->boolean('linked');
            $table->boolean('static_layout');
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
        Schema::drop('pages');
    }
}
