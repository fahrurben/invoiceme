<?php
/**
 * Created by PhpStorm.
 * User: fahrur
 * Date: 20/11/20
 * Time: 5:03
 */

namespace App\Domain\Invoice\Models;

use App\Domain\ArrayExpressible;
use Rakit\Validation\Validation;
use Rakit\Validation\Validator;

class InvoiceDto implements ArrayExpressible
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

    public function toArray()
    {
        $data = get_object_vars($this);
        $data['lines'] = [];
        foreach ($this->lines as $line) {
            $data['lines'][] = $line->toArray();
        }

        return $data;
    }

    public function fromArray($data)
    {
        $this->no = $data['no'] ?? '';
        $this->issueDate  = $data['issueDate'] ?? null;
        $this->dueDate  = $data['dueDate'] ?? null;
        $this->customerName  = $data['customerName'] ?? '';
        $this->customerEmail  = $data['customerEmail'] ?? '';
        $this->tax  = $data['tax'] ?? 0;

        if (!empty($data['lines'])) {
            foreach ($data['lines'] as $line) {
                $lineDto = new LineDto();
                $lineDto->fromArray($line);

                $this->lines[] = $lineDto;
            }
        }

    }

    public function getValidator(): Validation
    {
        $validator = new Validator;

        $rules = [
            'companyId' => 'required',
            'no' => 'required',
            'issueDate' => 'required|date',
            'dueDate' => 'required|date',
            'customerName' => 'required',
            'customerEmail' => 'required|email',
            'tax' => 'required|numeric',
        ];

        return $validator->make($this->toArray(), $rules);
    }
}