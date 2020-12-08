<?php
/**
 * Created by PhpStorm.
 * User: fahrur
 * Date: 19/11/20
 * Time: 5:50
 */

namespace App\Domain\Item\Models;

use App\Domain\ArrayExpressible;
use App\Domain\ArrayExpressibleEntity;
use Rakit\Validation\Validation;
use Rakit\Validation\Validator;

class ItemDto implements ArrayExpressible
{
    use ArrayExpressibleEntity;

    public $companyId;

    public $name;

    public $type;

    public $categoryId;

    public $isActive;

    public function __construct()
    {
    }

    public function fromArray($data)
    {
        $this->name = $data['name'] ?? '';
        $this->type = $data['type'] ?? null;
        $this->categoryId = $data['categoryId'] ?? null;
        $this->isActive  = $data['isActive'] ?? null;
    }

    public function getValidator(): Validation
    {
        $validator = new Validator;

        $rules = [
            'companyId' => 'required',
            'name' => 'required',
            'type' => 'required',
            'categoryId' => 'required',
        ];

        return $validator->make($this->toArray(), $rules);
    }

    public function getUpdateValidator(): Validation
    {
        $validator = new Validator;

        $rules = [
            'companyId' => 'required',
            'name' => 'required',
            'type' => 'required',
            'categoryId' => 'required',
        ];

        return $validator->make($this->toArray(), $rules);
    }
}