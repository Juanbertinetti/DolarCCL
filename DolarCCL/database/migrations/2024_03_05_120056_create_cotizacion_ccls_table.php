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
    public function up() : void
    {
        Schema::create('cotizacion_ccl', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->string('indicador_financiero');
            $table->decimal('valor');
            $table->timestamp('fecha_act');
            $table->dateTime('fecha_dato');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cotizacion_ccls');
    }
};
