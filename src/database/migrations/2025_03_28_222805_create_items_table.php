<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('category_id')->constrained()->cascadeOnDelete();
            $table->string('item_name',255);
            $table->text('item_image');
            $table->string('brand_name',255)->nullable();
            $table->integer('price');
            $table->text('description');
            $table->tinyInteger('condition')->unsigned()->comment('状態: 1:良好 2:目立った傷や汚れなし 3: やや傷や汚れあり 4:状態が悪い');
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
        Schema::dropIfExists('items');
    }
}
