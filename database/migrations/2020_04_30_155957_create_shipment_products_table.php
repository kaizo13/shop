<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShipmentProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipment_products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('idShipment')->unsigned();
            $table->bigInteger('idProduct')->unsigned();
            $table->foreign('idProduct')->references('id')->on('products');
            $table->foreign('idShipment')->references('id')->on('shipments');
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
        Schema::dropIfExists('shipment_products');
    }
}
