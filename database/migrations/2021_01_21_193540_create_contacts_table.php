<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->integer('ContactID');
            $table->string('ContactName');
            $table->string('FirstName');
            $table->string('MiddleName');
            $table->string('LastName');
            $table->string('ContactGroupTypeName');
            $table->string('NationalID');
            $table->string('BankDetails');
            $table->string('BusinessPhone');
            $table->string('Email');
            $table->string('Email2');
            $table->string('Email3');
            $table->date('Birthdate');
            $table->string('Gender');
            $table->string('DeliveryName');
            $table->string('ContactCode');
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
        Schema::dropIfExists('contacts');
    }
}
