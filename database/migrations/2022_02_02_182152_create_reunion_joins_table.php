<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReunionJoinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reuniones_join', function (Blueprint $table) {
            $table->uuid("reunion_id");
            $table->uuid("user_id");
            $table->dateTime("joining_at")->nullable();
            $table->dateTime("disconnected_at")->nullable();
            $table->foreign("reunion_id")->references("id")->on("reuniones");
            $table->foreign("user_id")->references("id")->on("users");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reuniones_join');
    }
}
