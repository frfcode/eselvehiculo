<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Billing extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billing', function (Blueprint $table) {
            $table->id()->startingValue(2000000);
            $table->string('vendor');
            $table->string('client');
            $table->string('iva');
            $table->string('total_price');
            $table->timestamps();
        });

        DB::table('billing')->insert([
            [
                'vendor' => 'default',
                'client' => 'client-default',
                'iva' => '16',
                'total_price' => 0,
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
        Schema::dropIfExists('billing');
    }
}
