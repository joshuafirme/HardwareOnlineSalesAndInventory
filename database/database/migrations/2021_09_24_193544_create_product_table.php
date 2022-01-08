<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('prefix')->default('P-');
            $table->string('description');
            $table->integer('qty');
            $table->integer('reorder');
            $table->decimal('orig_price');
            $table->decimal('selling_price');
            $table->text('image')->nullable();
            $table->integer('unit_id');
            $table->integer('category_id');
            $table->integer('supplier_id');
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
        Schema::dropIfExists('product');
    }
}
