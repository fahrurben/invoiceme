<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');

            $table->string('no');
            $table->date('issue_date');
            $table->date('due_date');
            $table->string('customer_name');
            $table->string('customer_email');
            $table->decimal('sub_total', 9, 2);
            $table->decimal('tax', 9, 2);
            $table->decimal('tax_total', 9, 2);
            $table->decimal('total', 9, 2);

            $table->foreign('company_id', 'invoice_company_id_foreign')
                ->references('id')->on('company')
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
        Schema::dropIfExists('invoice');
    }
}
