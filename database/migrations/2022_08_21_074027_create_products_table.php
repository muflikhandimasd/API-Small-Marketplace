<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->integer('product_price');
            $table->string('city');
            $table->string('product_image');
            $table->string('seller_name');
            $table->integer('is_halal')->default(1);
            $table->integer('is_ready')->default(1);
            $table->integer('is_new')->default(1);
            $table->integer('is_checkout')->default(0);
            $table->integer('quantity')->default(1);
            $table->float('weight')->default(1);
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
