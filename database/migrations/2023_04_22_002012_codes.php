<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Codes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('codes', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->timestamps();
        });

        DB::table('codes')->insert([
            [
                'code' => 'CD3593', 
                'created_at' => NULL,
                'updated_at' => NULL,
                ],[
                'code' => 'CK6807', 
                'created_at' => NULL,
                'updated_at' => NULL,
                ],[
                'code' => 'CF7599', 
                'created_at' => NULL,
                'updated_at' => NULL,
                ],[
                'code' => 'CK7429', 
                'created_at' => NULL,
                'updated_at' => NULL,
                ],[
                'code' => 'CK7420', 
                'created_at' => NULL,
                'updated_at' => NULL,
                ],[
                'code' => 'CD3807', 
                'created_at' => NULL,
                'updated_at' => NULL,
                ],[
                'code' => 'CD16', 
                'created_at' => NULL,
                'updated_at' => NULL,
                ],[
                'code' => 'CF3747', 
                'created_at' => NULL,
                'updated_at' => NULL,
                ],[
                'code' => 'CD3614', 
                'created_at' => NULL,
                'updated_at' => NULL,
                ],[
                'code' => 'CD4558', 
                'created_at' => NULL,
                'updated_at' => NULL,
                ],[
                'code' => 'CF618', 
                'created_at' => NULL,
                'updated_at' => NULL,
                ],[
                'code' => 'CD43', 
                'created_at' => NULL,
                'updated_at' => NULL,
                ],[
                'code' => 'CD309', 
                'created_at' => NULL,
                'updated_at' => NULL,
                ],[
                'code' => 'CK79201', 
                'created_at' => NULL,
                'updated_at' => NULL,
                ],[
                'code' => 'CF2405', 
                'created_at' => NULL,
                'updated_at' => NULL,
                ],[
                'code' => 'CF2402', 
                'created_at' => NULL,
                'updated_at' => NULL,
                ],[
                'code' => 'CD2870', 
                'created_at' => NULL,
                'updated_at' => NULL,
                ],[
                'code' => 'CK5301', 
                'created_at' => NULL,
                'updated_at' => NULL,
                ],[
                'code' => 'CF3744', 
                'created_at' => NULL,
                'updated_at' => NULL,
                ],[
                'code' => 'CK5827', 
                'created_at' => NULL,
                'updated_at' => NULL,
                ],[
                'code' => 'CF5870', 
                'created_at' => NULL,
                'updated_at' => NULL,
                ],[
                'code' => 'CC5663', 
                'created_at' => NULL,
                'updated_at' => NULL,
                ],[
                'code' => 'CD5552', 
                'created_at' => NULL,
                'updated_at' => NULL,
                ],[
                'code' => 'CK9015', 
                'created_at' => NULL,
                'updated_at' => NULL,
                ],[
                'code' => 'CF5738', 
                'created_at' => NULL,
                'updated_at' => NULL,
                ],[
                'code' => 'CD14120', 
                'created_at' => NULL,
                'updated_at' => NULL,
                ],[
                'code' => 'CK69754', 
                'created_at' => NULL,
                'updated_at' => NULL,
                ],[
                'code' => 'CF74120', 
                'created_at' => NULL,
                'updated_at' => NULL,
                ],[
                'code' => 'CD8', 
                'created_at' => NULL,
                'updated_at' => NULL,
                ],[
                'code' => 'CK5107', 
                'created_at' => NULL,
                'updated_at' => NULL,
                ],[
                'code' => 'CC38540C', 
                'created_at' => NULL,
                'updated_at' => NULL,
                ],[
                'code' => 'CD8530', 
                'created_at' => NULL,
                'updated_at' => NULL,
                ],[
                'code' => 'CK25045', 
                'created_at' => NULL,
                'updated_at' => NULL,
                ],[
                'code' => 'CF5896', 
                'created_at' => NULL,
                'updated_at' => NULL,
                ],[
                'code' => 'CD55854', 
                'created_at' => NULL,
                'updated_at' => NULL,
                ],[
                'code' => 'CD28976', 
                'created_at' => NULL,
                'updated_at' => NULL,
                ],[
                'code' => 'CD9463', 
                'created_at' => NULL,
                'updated_at' => NULL,
                ],[
                'code' => 'CC5662', 
                'created_at' => NULL,
                'updated_at' => NULL,
                ],[
                'code' => 'CF5030', 
                'created_at' => NULL,
                'updated_at' => NULL,
                ],[
                'code' => 'CD552', 
                'created_at' => NULL,
                'updated_at' => NULL,
                ],[
                'code' => 'CC38504C', 
                'created_at' => NULL,
                'updated_at' => NULL,
                ],[
                'code' => 'CK5929', 
                'created_at' => NULL,
                'updated_at' => NULL,
                ],[
                'code' => 'CK65923', 
                'created_at' => NULL,
                'updated_at' => NULL,
                ],[
                'code' => 'CD4997', 
                'created_at' => NULL,
                'updated_at' => NULL,
                ],[
                'code' => 'CD59', 
                'created_at' => NULL,
                'updated_at' => NULL,
                ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('codes');
    }
}
