<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageWidgetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_widgets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('page_id')->nullable();
            $table->integer('section_id')->nullable();
            $table->string('type');
            $table->text('content');
            $table->integer('sort');
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
        Schema::drop('page_widgets');
    }
}
