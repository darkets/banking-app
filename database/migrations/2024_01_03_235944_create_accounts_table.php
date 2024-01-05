<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->string('identifier')->primary();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('currency', ['USD', 'EUR', 'RUB', 'GBP']);
            $table->bigInteger('balance');
            $table->enum('type', ['checking', 'investment']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('accounts');
    }
}
