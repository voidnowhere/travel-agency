<?php

use App\Enums\SeasonTypes;
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
        Schema::create('seasons', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->date('date_from');
            $table->date('date_to');
            $table->enum('type_SHML', SeasonTypes::values());
            $table->boolean('is_active');
            $table->timestamps();

            $table->unique(['date_from', 'date_to', 'type_SHML']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seasons');
    }
};
