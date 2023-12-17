<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Orders extends Migration{
    public function up(){
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            
            $table->string('muzid')->nullable();
            $table->string('classesid')->nullable();
            $table->string('usersid')->nullable();
            $table->string('deal')->nullable();
            $table->string('isour')->nullable();
            $table->datetime('datefrom')->nullable();
            $table->datetime('dateto')->nullable();
            $table->string('amountpeople')->nullable();
            $table->text('comment')->nullable();
            $table->timestamp('deleted_at')->nullable();
            
            $table->timestamps();
        });
    }
    public function down(){Schema::dropIfExists('orders');}
}
