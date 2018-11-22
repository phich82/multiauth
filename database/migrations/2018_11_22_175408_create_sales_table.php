<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('region');
            $table->string('country');
            $table->string('item_type');
            $table->string('sales_channel');
            $table->string('order_priority');
            $table->string('order_date');
            $table->integer('order_id');
            $table->string('ship_date');
            $table->integer('units_sold');
            $table->double('unit_price', 12);
            $table->double('unit_cost', 12);
            $table->double('total_revenue', 12);
            $table->double('total_cost', 12);
            $table->double('total_profit', 12);
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
        Schema::dropIfExists('sales');
    }
}
