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
        Schema::create('decision_areas', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('label');
            $table->string('description');
            $table->integer('importancy')->default(5);
            $table->integer('urgency')->default(5);
            $table->boolean('isFocused')->default(false);
            $table->unsignedBigInteger('project_id')->default(1);
            $table->unsignedBigInteger('user_id');    
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('decision_areas');
    }
};
