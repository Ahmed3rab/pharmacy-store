<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductDiscountItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_discount_items', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->foreignId('product_discount_id')->constrained();
            $table->foreignId('product_id')->constrained();
            $table->float('price_after');
            $table->timestamps();

            $table->unique('product_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_discount_items');
    }
}
