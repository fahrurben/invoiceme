<?php
/**
 * Created by PhpStorm.
 * User: fahrur
 * Date: 20/11/20
 * Time: 4:58
 */

namespace App\Domain\Invoice\Models;

use Rakit\Validation\Validation;
use Rakit\Validation\Validator;

class LineDto
{
    public $id;

    public $invoiceId;

    public $itemId;

    public $qty;

    public $price;

    public $amount;

    public function __construct()
    {
    }

    public function getValidator(): Validation
    {
        $validator = new Validator;

        $rules = [
            'itemId' => 'required',
            'qty' => 'required|numeric',
            'price' => 'required|numeric',
            'amount' => 'required|numeric',
        ];

        return $validator->make((array)$this, $rules);
    }
}