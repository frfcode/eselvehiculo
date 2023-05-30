<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('rol');
            $table->rememberToken();
            $table->timestamps();
        });
        
        DB::table('users')->insert([
            ['name'=>'Jhoan Gomez','email' =>'presidencia@eselvehiculo.com', 'password' => Hash::make('admin2023'), 'rol'=> 'ADMINISTRADOR', 'remember_token' => '', 'created_at' => NULL, 'updated_at' => NULL],
            ['name'=>'default Gerencia','email' =>'gerencia@eselvehiculo.com', 'password' => Hash::make('gerencia2023'), 'rol'=> 'GERENCIA', 'remember_token' => '', 'created_at' => NULL, 'updated_at' => NULL]
        ]);
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
