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
            $table->string('name');
            $table->text('description')->nullable();
            $table->json('media')->nullable();
            $table->integer('impressions')->nullable();
            $table->string('location')->nullable();
            $table->string('type')->nullable();
            $table->string('duration')->nullable();
            $table->string('dimension')->nullable();
            $table->integer('price');
            $table->boolean('status')->default(false);
            $table->boolean('featured')->default(false);
            $table->foreignId('user_id')->ondelete('cascade')->onupdate('cascade');
            $table->foreignId('category_id')->ondelete('cascade')->onupdate('cascade');
            $table->foreignId('subcategory_id')->ondelete('cascade')->onupdate('cascade');
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
