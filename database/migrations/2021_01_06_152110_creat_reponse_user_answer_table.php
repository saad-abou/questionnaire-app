<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatReponseUserAnswerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reponse_user_answer', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_answer_id')->foreign('user_answer_id')->references('id')->on('user_answers')->onDelete('cascade');
            $table->unsignedBigInteger('reponse_id')->foreign('reponse_id')->references('id')->on('reponses')->onDelete('cascade');
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
        Schema::dropIfExists('reponse_user_answer');
    }
}
