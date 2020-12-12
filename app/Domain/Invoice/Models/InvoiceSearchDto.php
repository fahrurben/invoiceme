<?php
/**
 * Created by PhpStorm.
 * User: fahrur
 * Date: 12/12/20
 * Time: 11:19
 */

namespace App\Domain\Invoice\Models;


class InvoiceSearchDto extends InvoiceDto
{
    public $issueFrom;

    public $issueTo;

    public $dueFrom;

    public $dueTo;
}