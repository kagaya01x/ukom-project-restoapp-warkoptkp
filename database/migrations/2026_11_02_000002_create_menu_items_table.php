<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->bigIncrements('menu_item_id');
            $table->unsignedBigInteger('category_id');
            $table->string('item_menu_name');
            $table->unsignedBigInteger('item_menu_price');
            $table->text('item_menu_desc')->nullable();
            $table->string('item_menu_img_link')->nullable();
            $table->timestamps();

            $table->foreign('category_id')
                  ->references('category_id')
                  ->on('menu_category')
                  ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
