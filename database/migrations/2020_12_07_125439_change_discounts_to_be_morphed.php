<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeDiscountsToBeMorphed extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('product_discounts', 'discounts');
        Schema::drop('product_discount_items');

        Schema::create('discountables', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('discount_id');
            $table->morphs('discountable');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discountables');
    }
}
