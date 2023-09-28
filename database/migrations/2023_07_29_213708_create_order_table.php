<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->id();
            
            $table->string('mid')->nullable()->unique();
            $table->string('name')->nullable();
            $table->text('eventtime')->nullable();
            $table->integer('area')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('amountpeople')->nullable();
            $table->string('price')->nullable();
            
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
        Schema::dropIfExists('order');
    }
}
