<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRelations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('logs', function (Blueprint $table) {
            $table->unsignedInteger('procedure_id');
            $table->foreign('procedure_id')->references('id')->on('procedures')->onDelete('cascade');
        });

        Schema::table('procedures', function (Blueprint $table) {
            $table->unsignedInteger('endpoint_id');
            $table->foreign('endpoint_id')->references('id')->on('endpoints')->onDelete('cascade');
        });

        Schema::table('endpoints', function (Blueprint $table) {
            $table->unsignedInteger('instance_id');
            $table->foreign('instance_id')->references('id')->on('instances')->onDelete('cascade');
        });

        Schema::table('fields', function (Blueprint $table) {
            $table->unsignedInteger('procedure_id');
            $table->foreign('procedure_id')->references('id')->on('procedures')->onDelete('cascade');
        });

        Schema::table('instances', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
