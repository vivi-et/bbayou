<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGiftconsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('giftcons', function (Blueprint $table) {
            $table->id();
            $table->date('expire_date');
            $table->integer('orderno');
            $table->string('place');
            $table->date('recieved_date');
            $table->boolean('used');
            $table->boolean('used_on')->nullable;
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
        Schema::dropIfExists('giftcons');
    }
}
