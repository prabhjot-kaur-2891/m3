<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UrlTokens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('urlTokens', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('destinationUrl', 255);
            $table->string('shortUrl', 20)->unique()->collation('utf8_bin');
            $table->integer('hits')->default(0);
            $table->dateTime('expiry')->nullable();
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
        //
    }
}
