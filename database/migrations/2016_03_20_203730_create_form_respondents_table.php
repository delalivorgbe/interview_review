<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormRespondentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_respondents', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id');
            $table->integer('form_id');
            $table->string('original_filename');
            $table->string('doc_path');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('form_respondents');
    }
}
