<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('decision_area_connections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('decision_area_id_1');
            $table->unsignedBigInteger('decision_area_id_2');
            $table->unsignedBigInteger('project_id');
            $table->timestamps();

            $table->foreign('decision_area_id_1')->references('id')->on('decision_areas')->onDelete('cascade');
            $table->foreign('decision_area_id_2')->references('id')->on('decision_areas')->onDelete('cascade');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });

        DB::statement('ALTER TABLE decision_area_connections ADD CONSTRAINT unique_decision_area_connection_1 UNIQUE (decision_area_id_1, decision_area_id_2, project_id)');
        DB::statement('ALTER TABLE decision_area_connections ADD CONSTRAINT unique_decision_area_connection_2 UNIQUE (decision_area_id_2, decision_area_id_1, project_id)');
    }

    public function down()
    {
        Schema::dropIfExists('decision_area_connections');
    }
};
