<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDishesTable extends Migration
{
    public function up()
    {
        Schema::create('dishes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kitchen_id')->constrained();
            $table->foreignId('category_id')->constrained();
            $table->string('name');
            $table->foreignId('chef_id')->nullable()->constrained();
            $table->string('serving_at')->default('restaurant');
            $table->double('price');
            $table->integer('calories');
            $table->smallInteger('diet');
            $table->smallInteger('cooking_method');
            $table->char('nutri_score', 1);
            $table->boolean('in_stock')->default(false);
            $table->date('produced_at');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dishes');
    }
}
