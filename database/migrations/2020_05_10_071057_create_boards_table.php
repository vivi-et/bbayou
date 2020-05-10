<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBoardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('boards', function (Blueprint $table) {
            $table->id();
            $table->string('board_name');
            $table->integer('board_auth')->default(1); // 1 공개 0 관리자만
            $table->timestamps();
        });

        DB::table('boards')->insert([ 
            ['board_name' => 'free', 'created_at' => now(), 'updated_at' => now(), ], 
            ['board_name' => 'humor', 'created_at' => now(), 'updated_at' => now(), ], 
            ['board_name' => 'game', 'created_at' => now(), 'updated_at' => now(), ], 
            ['board_name' => 'sport', 'created_at' => now(), 'updated_at' => now(), ], 
 
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('boards');
    }
}
