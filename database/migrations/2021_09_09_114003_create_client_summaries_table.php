<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientSummariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_summaries', function (Blueprint $table) {
            $table->id();
            $table->string('client')->nullable();
            $table->string('fund')->nullable();
            $table->string('startValue')->nullable();
            $table->string('contributions')->nullable();
            $table->bigInteger('redemption')->nullable();
            $table->bigInteger('return')->nullable();
            $table->string('endValue')->nullable();
            $table->string('email1')->nullable();
            $table->string('email2')->nullable();
            $table->string('email3')->nullable();
            $table->string('clientcode')->nullable();
            $table->string('status')->nullable();
            $table->string('error')->nullable();
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
        Schema::dropIfExists('client_summaries');
    }
}
