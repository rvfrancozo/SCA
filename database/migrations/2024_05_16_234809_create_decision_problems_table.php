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
        Schema::create('decision_problems', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('label');
            $table->string('description');
            $table->integer('importancy')->default(5);
            $table->integer('urgency')->default(5);
            $table->boolean('isFocused')->default(false);
            $table->unsignedBigInteger('projec_id')->default(1);
            $table->foreign('projec_id')->references('id')->on('projects')->onDelete('cascade');
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
        Schema::dropIfExists('decision_problems');
    }
};
