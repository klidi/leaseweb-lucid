<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('asset_id')
                ->index();
            $table->bigInteger('user_id')
                ->unsigned()
                ->index()
                ->foreign()
                ->references("id")
                ->on('users')
                ->onDelete("cascade");
            $table->bigInteger('brand_id')
                ->unsigned()
                ->index()
                ->foreign()
                ->references("id")
                ->on('brands');
            $table->string('name');
            $table->json('price');
            $table->json('currency');
            $table->json('ram_modules');
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
        Schema::dropIfExists('servers');
    }
}
