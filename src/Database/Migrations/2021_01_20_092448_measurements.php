<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Measurements extends Migration
{
    /**
     * Run the Migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('measurements', function ( Blueprint $table ){
            $table->id();
//            $table->string('host')->nullable();
//            $table->text('result')->nullable();
            $table->foreignIdFor(\Latlog\Models\Target::class);
            $table->unsignedFloat('min', 8, 3)->nullable();
            $table->unsignedFloat('avg', 8, 3)->nullable();
            $table->unsignedFloat('max', 8, 3)->nullable();
            $table->unsignedFloat('stddev', 8, 3)->nullable();
            $table->unsignedInteger('lostPercent')->nullable();
            $table->unsignedInteger('exitcode')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the Migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('measurements');
    }
}
