<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSangridModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sangrid_models', function (Blueprint $table) {
            $table->id('clientID');
            $table->date('tanggal');
            $table->string('nama');
            // I faced a similar problem in one project,
            // so I wanted to insert but without adding the timestamps in my code every time I insert so.
            // if you need to use insert without adding the timestamps manually.
            // you can change your migrations file and add the timestamps manuallay:
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sangrid_models');
    }
}
