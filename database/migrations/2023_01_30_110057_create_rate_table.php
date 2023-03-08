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
        Schema::create('rate', function (Blueprint $table) {
            $table->id();
            $table->integer('quality_rate');
            $table->integer('price_rate');
            $table->integer('time_rate');
            $table->bigInteger('user_id')->references('Id')->on('customer')->nullable()->onDelete('cascade')->onUpdate('cascade')->unsigned()->index();
            $table->bigInteger('worker_id')->references('Id')->on('worker')->nullable()->onDelete('cascade')->onUpdate('cascade')->unsigned()->index();
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
        Schema::dropIfExists('rate');
    }
};
