<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id'); 
            $table->string('name');
            $table->string('cpf')->unique();
            $table->string('email')->unique();
            $table->decimal('salary', 10, 2); 
            $table->timestamps();



            // Chave estrangeira para relacionar com a tabela projects
           
        });
    }

    public function down()
    {
        Schema::dropIfExists('employees');
    }
}



