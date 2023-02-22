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
        Schema::create('worker', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone');
            $table->string('address');
            $table->bigInteger('city_id')->references('Id')->on('region')->nullable()->onDelete('cascade')->onUpdate('cascade')->unsigned()->index();
            $table->string('image')->nullable();
            $table->bigInteger('category_id')->references('Id')->on('category')->nullable()->onDelete('cascade')->onUpdate('cascade')->unsigned()->index();;
            $table->string('description')->nullable();
            $table->string('portifolio')->nullable();
            $table->string('status')->default('active');
            $table->string('role')->default('worker');
            $table->boolean('active_status')->default(0);
            $table->boolean('dark_mode')->default(0);
            $table->string('messenger_color')->default('#2180f3');


            $table->string('remember_token')->nullable();

            $table->bigInteger('accepted_by')->references('Id')->on('admin')->nullable()->onDelete('cascade')->onUpdate('cascade')->unsigned()->index();
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
        Schema::dropIfExists('worker');
    }
};
