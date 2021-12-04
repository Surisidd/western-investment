<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactCurrenciesTable extends Migration
{
  
    public function up()
    {
        Schema::create('contact_currencies', function (Blueprint $table) {
            $table->id();
            $table->string('ContactID');
            $table->string('currency')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('contact_currencies');
    }
}
