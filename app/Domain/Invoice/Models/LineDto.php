<?php
/**
 * Created by PhpStorm.
 * User: fahrur
 * Date: 20/11/20
 * Time: 4:58
 */

namespace App\Domain\Invoice\Models;

use App\Domain\ArrayExpressible;
use App\Domain\ArrayExpressibleEntity;
use Rakit\Validation\Validation;
use Rakit\Validation\Validator;

class LineDto implements ArrayExpressible
{
    use ArrayExpressibleEntity;

    public $id;

    public $invoiceId;

    public $itemId;

    public $qty;

    public $price;

    public $amount;

    public function __construct()
    {
    }

    public function fromArray($data)
    {
        $this->id = $data['id'] ?? null;
        $this->invoiceId  = $data['invoiceId'] ?? null;
        $this->itemId  = $data['itemId'] ?? null;
        $this->qty  = $data['qty'] ?? 0;
        $this->price  = $data['price'] ?? '';
        $this->amount  = $data['amount'] ?? 0;
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

        return $validator->make($this->toArray(), $rules);
    }
}