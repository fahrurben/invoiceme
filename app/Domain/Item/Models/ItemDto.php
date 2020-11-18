<?php
/**
 * Created by PhpStorm.
 * User: fahrur
 * Date: 19/11/20
 * Time: 5:50
 */

namespace App\Domain\Item\Models;

use Rakit\Validation\Validation;
use Rakit\Validation\Validator;

class ItemDto
{
    public $companyId;

    public $name;

    public $type;

    public $categoryId;

    public $isActive;

    public function __construct()
    {
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

        return $validator->make((array)$this, $rules);
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

        return $validator->make((array)$this, $rules);
    }
}