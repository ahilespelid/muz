<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Clients extends Migration{
    public function up(){
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->integer('phone')->nullable()->length(10);
            $table->string('name')->nullable();
            
            $table->string('created_at')->nullable();
            $table->string('updated_at')->nullable();
            $table->string('deleted_at')->nullable();
        });
    }
    public function down(){Schema::dropIfExists('clients');}
}
