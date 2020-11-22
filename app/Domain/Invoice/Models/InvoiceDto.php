<?php
/**
 * Created by PhpStorm.
 * User: fahrur
 * Date: 20/11/20
 * Time: 5:03
 */

namespace App\Domain\Invoice\Models;

use Rakit\Validation\Validation;
use Rakit\Validation\Validator;

class InvoiceDto
{
    public $companyId;

    public $no;

    public $issueDate;

    public $dueDate;

    public $customerName;

    public $customerEmail;

    /**
     * @var LineDto[] $lines
     */
    public $lines;

    public $tax;

    public function __construct()
    {
        $this->lines = [];
    }

    public function getValidator(): Validation
    {
        $validator = new Validator;

        $rules = [
            'companyId' => 'required',
            'no' => 'required',
            'issueDate' => 'date',
            'dueDate' => 'date',
            'customerName' => 'required',
            'customerEmail' => 'required',
            'tax' => 'required|numeric',
        ];

        return $validator->make((array)$this, $rules);
    }
}