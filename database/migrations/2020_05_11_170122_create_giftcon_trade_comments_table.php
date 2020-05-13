<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGiftconTradeCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('giftcon_trade_comments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('giftcon_id1');
            $table->bigInteger('giftcon_id2')->nullable;
            $table->bigInteger('giftcon_id3')->nullable;
            $table->bigInteger('giftcon_id4')->nullable;
            $table->bigInteger('giftcon_id5')->nullable;
            $table->bigInteger('giftcon_trade_post_id');
            $table->bigInteger('user_id');
            $table->boolean('traded')->default(0);
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
        Schema::dropIfExists('giftcon_trade_comments');
    }
}
