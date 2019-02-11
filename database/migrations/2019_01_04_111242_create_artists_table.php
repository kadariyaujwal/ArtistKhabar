<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArtistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artists', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name", 255);
            $table->string("address", 255);
            $table->date("birthday");
            $table->string("picture", 255);
            $table->string("cover_picture", 255);
            $table->string("website", 255);
            $table->string("facebook", 255);
            $table->string("twitter", 255);
            $table->string("email", 255);
            $table->text("bio");
            $table->text("meta_desc");
            $table->softDeletes();
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
        Schema::dropIfExists('artists');
    }
}
