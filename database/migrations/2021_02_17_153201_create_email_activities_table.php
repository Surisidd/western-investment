<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailActivitiesTable extends Migration
{
    
    public function up()
    {
        Schema::create('email_activities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ContactID');
            $table->enum('status',['sent','failed','error'])->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('notes')->nullable();
            $table->string('email')->nullable();
            $table->unsignedBigInteger('schedule_id')->nullable();
            $table->unsignedBigInteger('startPortfolio')->nullable();
            $table->unsignedBigInteger('interests')->nullable();
            $table->bigInteger('endPortfolio')->nullable();
            $table->string('desc')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('email_activities');
    }
}
