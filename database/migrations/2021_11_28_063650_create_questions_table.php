<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained();
            $table->text('question');
            $table->string('image')->nullable();
            $table->text('option_1');
            $table->text('option_2');
            $table->text('option_3');
            $table->text('option_4');
            $table->enum('answer', ['option_1', 'option_2', 'option_3', 'option_4']);
            $table->integer('timer');
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
        Schema::dropIfExists('questions');
    }
}
