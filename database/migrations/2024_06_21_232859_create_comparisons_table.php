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
        Schema::create('comparisons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('option_id_1');
            $table->unsignedBigInteger('option_id_2');
            $table->boolean('state')->nullable();
            $table->timestamps();

            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
            $table->foreign('option_id_1')->references('id')->on('options')->onDelete('cascade');
            $table->foreign('option_id_2')->references('id')->on('options')->onDelete('cascade');

            $table->unique(['project_id', 'option_id_1', 'option_id_2']);
            $table->unique(['project_id', 'option_id_2', 'option_id_1']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comparisons');
    }
};
