<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCryptoTable extends Migration
{
    public function up()
    {
        Schema::create('crypto', function (Blueprint $table) {
            $table->string('crypto_symbol')->primary();
            $table->decimal('USD', 10, 4);
            $table->decimal('EUR', 10, 4);
            $table->decimal('RUB', 30, 4);
            $table->decimal('GBP', 10, 4);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('crypto');
    }
}
