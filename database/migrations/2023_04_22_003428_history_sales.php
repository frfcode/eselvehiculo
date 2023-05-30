<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class HistorySales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_sales', function (Blueprint $table) {
            //
            $table->id();
            $table->string('n_facture');
            $table->string('code');
            $table->string('product');
            $table->mediumInteger('price');
            $table->mediumInteger('product_cant');
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
        Schema::dropIfExists('history_sales');
    }
}
