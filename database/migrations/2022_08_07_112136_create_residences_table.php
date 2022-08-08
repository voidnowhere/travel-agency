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
        Schema::create('residences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('city_id')->constrained();
            $table->foreignId('residence_category_id')->constrained();
            $table->string('name');
            $table->text('description');
            $table->string('website');
            $table->string('email');
            $table->string('contact');
            $table->unsignedFloat('tax');
            $table->unsignedInteger('order_by');
            $table->boolean('is_active');
            $table->timestamps();

            $table->unique(['name', 'city_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('residences');
    }
};
