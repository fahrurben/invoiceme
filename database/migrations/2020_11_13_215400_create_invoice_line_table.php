<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceLineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_line', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_id');
            $table->unsignedBigInteger('item_id');

            $table->decimal('qty', 9, 2);
            $table->decimal('price', 9, 2);
            $table->decimal('amount', 9, 2);

            $table->foreign('invoice_id', 'invoice_line_invoice_id_foreign')
                ->references('id')->on('invoice')
                ->onDelete('RESTRICT');

            $table->foreign('item_id', 'invoice_line_item_id_foreign')
                ->references('id')->on('item')
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
        Schema::dropIfExists('invoice_line');
    }
}
