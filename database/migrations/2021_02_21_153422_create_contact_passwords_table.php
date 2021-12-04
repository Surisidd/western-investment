<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactPasswordsTable extends Migration
{
   
    public function up()
    {
        Schema::create('contact_passwords', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ContactID');
            $table->string('password')->nullable();
            $table->string('status')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
        });
    }

 
    public function down()
    {
        Schema::dropIfExists('contact_passwords');
    }
}
