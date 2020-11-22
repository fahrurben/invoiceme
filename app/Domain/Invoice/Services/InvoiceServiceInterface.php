<?php
/**
 * Created by PhpStorm.
 * User: fahrur
 * Date: 20/11/20
 * Time: 5:20
 */

namespace App\Domain\Invoice\Services;


use App\Domain\Invoice\Models\Invoice;
use App\Domain\Invoice\Models\InvoiceDto;

interface InvoiceServiceInterface
{
    public function create(InvoiceDto $invoiceDto): Invoice;

    public function update(int $id, InvoiceDto $invoiceDto): Invoice;

    public function delete(int $id);
}