<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->increments('id');
            $table->string("title");
            $table->string("photo");
            $table->string("cover");
            $table->text('description');
            $table->date('release_date');
            $table->string('producer')->nullable();
            $table->string('director')->nullable();
            $table->string('age_limit');
            $table->integer('lead_actor');
            $table->integer('time')->nullable();
            $table->float('cost')->nullable();
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
        Schema::dropIfExists('movies');
    }
}
