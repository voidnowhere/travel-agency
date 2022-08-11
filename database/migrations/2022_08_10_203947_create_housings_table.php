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
        Schema::create('housings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('residence_id')->constrained();
            $table->foreignId('housing_category_id')->constrained();
            $table->string('name');
            $table->text('description');
            $table->unsignedTinyInteger('for_max');
            $table->unsignedInteger('order_by');
            $table->boolean('is_active');
            $table->timestamps();

            $table->unique(['residence_id', 'housing_category_id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('housings');
    }
};
