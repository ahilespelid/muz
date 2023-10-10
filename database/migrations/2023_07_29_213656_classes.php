<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Classes extends Migration{
    public function up(){
        Schema::create('classes', function (Blueprint $table){
            $table->id();
            
            $table->string('muzid')->nullable()->unique();
            $table->string('corpusesid')->nullable();
            $table->string('name')->nullable();
            $table->integer('product')->nullable();
            $table->integer('price')->nullable();
            $table->longtext('img')->nullable();
            $table->integer('orders')->nullable();
            $table->timestamp('deleted_at')->nullable();
            
            $table->timestamps();
        });
    }
    public function down(){Schema::dropIfExists('classes');}
}
