<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Users extends Migration{
    public function up(){
        Schema::create('users', function (Blueprint $table){
            $table->id();
            
            //$table->string('muzid')->nullable()->unique();
            $table->string('bitrixid')->nullable();
            $table->string('fio')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->timestamp('deleted_at')->nullable();
            
            $table->timestamps();
        });
    }
    public function down(){Schema::dropIfExists('users');}
}
