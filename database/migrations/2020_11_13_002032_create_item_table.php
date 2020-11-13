<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->unsignedBigInteger('category_id');

            $table->string('name');
            $table->unsignedSmallInteger('type');
            $table->boolean('is_active');

            $table->foreign('company_id', 'item_company_id_foreign')
                ->references('id')->on('company')
                ->onDelete('RESTRICT');

            $table->foreign('category_id', 'item_category_category_id_foreign')
                ->references('id')->on('item_category')
                ->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item');
    }
}
