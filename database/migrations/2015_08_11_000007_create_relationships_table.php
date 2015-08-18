<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelationshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('relationships', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type');
            $table->integer('alpha_doc_id')->unsigned();
            $table->integer('beta_doc_id')->unsigned();

            $table->foreign('alpha_doc_id')->references('id')->on('document');
            $table->foreign('beta_doc_id')->references('id')->on('document');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('relationships');
    }
}
