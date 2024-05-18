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
        Schema::create('decision_area_connections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('decision_area_id_1')->constrained('decision_areas')->onDelete('cascade');
            $table->foreignId('decision_area_id_2')->constrained('decision_areas')->onDelete('cascade');
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('decision_area_connections');
    }
};
