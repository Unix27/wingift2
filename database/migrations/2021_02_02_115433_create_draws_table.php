<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDrawsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('draws', function (Blueprint $table) {
            $table->id();

            $table->string('title', 255);
            $table->string('prize', 255);
            $table->timestamp('end_date');
            $table->string('link', 255)->nullable();
            $table->string('image', 255)->nullable();
            $table->boolean('is_active')->default(1);
            $table->boolean('is_free')->default(0);

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
        Schema::dropIfExists('draws');
    }
}
