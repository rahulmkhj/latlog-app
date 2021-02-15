<?php



use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTargetsTable extends Migration
{
    /**
     * Run the Migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('targets', function (Blueprint $table) {
            $table->id();
            $table->string('host');
            $table->unsignedInteger('count')->default(3);
            $table->float('interval')->default(0.5);
            $table->unsignedInteger('size')->default(56);
            $table->unsignedInteger('ttl')->default(30);
            $table->unsignedInteger('timeout')->default(3);
            $table->unsignedInteger('frequency')->default(300);
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
        Schema::dropIfExists('targets');
    }
}
