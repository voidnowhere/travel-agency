<?php

use App\Enums\SeasonTypes;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('housing_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('housing_id')->constrained();
            $table->foreignId('housing_formula_id')->constrained();
            $table->enum('type_SHML', SeasonTypes::values());
            $table->unsignedFloat('for_one_price');
            $table->unsignedFloat('for_one_extra_price');
            $table->unsignedInteger('min_nights');
            $table->unsignedFloat('weekend_price');
            $table->boolean('weekend_is_active');
            $table->unsignedFloat('kid_bed_price');
            $table->boolean('kid_bed_is_active');
            $table->unsignedFloat('extra_bed_price');
            $table->boolean('extra_bed_is_active');
            $table->timestamps();

            $table->unique(['housing_id', 'housing_formula_id', 'type_SHML']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('housing_prices');
    }
};
