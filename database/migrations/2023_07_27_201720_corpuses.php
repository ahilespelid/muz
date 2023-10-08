<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Corpuses extends Migration{
    public function up(){
        Schema::create('corpuses', function (Blueprint $table){
            $table->id();
               
            $table->string('muzid')->nullable()->unique();
            $table->string('name')->nullable();           
            $table->string('type')->nullable();           
            $table->longtext('img')->nullable();
            $table->timestamp('deleted_at')->nullable();
            
            $table->timestamps();
        });
    }
    public function down(){Schema::dropIfExists('corpuses');}
}
