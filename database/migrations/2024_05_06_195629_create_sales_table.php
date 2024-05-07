<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id('SalesId');
            $table->date('SalesDate');
            $table->foreignId('ProductId')->references('ProductId')->on('products')->onDelete('cascade');
            $table->decimal('SalesAmount', 20);
            $table->foreignId('SalesPersonId')->references('SalesPersonId')->on('SalesPersonId')->onDelete('cascade');
            $table->timestamps();

            $table->index(['SalesId', 'ProductId', 'SalesPersonId']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
}
