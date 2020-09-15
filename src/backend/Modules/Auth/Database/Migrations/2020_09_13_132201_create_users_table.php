<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('primeiro_nome');
            $table->string('ultimo_nome');
            $table->string('email')->unique();
            $table->string('cpf')->unique();
            $table->string('password');
            $table->foreignUuid('id_adress');
            $table->foreign('id_adress')
                ->references('id')
                ->on('user_address')
                ->onDelete('cascade');
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
        Schema::dropIfExists('users');
    }
}
