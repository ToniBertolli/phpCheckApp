<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeploymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deployments', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('project');
            $table->string('pipeline');
            $table->string('branch');

            $table->string('status');

            $table->string('invoker');
            $table->string('invoker_image');
            $table->string('committer');
            $table->string('committer_image');

            $table->string('link');
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
        Schema::dropIfExists('deployments');
    }
}
