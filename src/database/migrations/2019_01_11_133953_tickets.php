<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Tickets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('tickets', function (Blueprint $table) {

            $table->increments('id');

            // Foreign Register(s)
            $table->unsignedInteger('owner')->nullable();
            $table->unsignedInteger('guest_owner')->nullable();

            $table->foreign('owner')->references('id')->on('users');
            $table->foreign('guest_owner')->references('id')->on('ticket_guest_users');

            $table->string('title');
            $table->text('detail');
            $table->integer('type');
            $table->boolean('logged_in')->default(false);
            $table->json('externals')->nullable();
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
        Schema::dropIfExists('tickets');
    }
}
