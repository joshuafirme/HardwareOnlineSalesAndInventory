<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierDeliveryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_delivery', function (Blueprint $table) {
            $table->id();
            $table->string('prefix')->default('D-');
            $table->string('po_no');
            $table->string('product_code');
            $table->integer('qty_delivered');
            $table->string('remarks');
            $table->string('date_delivered');
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
        Schema::dropIfExists('supplier_delivery');
    }
}
