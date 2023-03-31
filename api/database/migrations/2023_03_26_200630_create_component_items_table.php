<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('component_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->comment('Fk from table:categories');
            $table->string('title');
            $table->string('description');
            $table->string('image');
            $table->longText('data');
            $table->tinyInteger('item_feature')->default(0)->comment('0 == free, 1 == pro');
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
        Schema::dropIfExists('component_items');
    }
};
