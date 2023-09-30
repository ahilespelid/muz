<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Orders extends Migration{
    public function up(){
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            
            $table->string('muzid')->nullable()->unique();
            $table->string('classesid')->nullable();
            $table->string('usersid')->nullable();
            $table->string('deal')->nullable();
            $table->string('starttime')->nullable();
            $table->string('endtime')->nullable();
            $table->string('amountpeople')->nullable();
            $table->text('comment')->nullable();
            
            $table->timestamps();
        });
    }
    public function down(){Schema::dropIfExists('orders');}
}
