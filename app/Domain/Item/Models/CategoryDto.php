<?php
/**
 * Created by PhpStorm.
 * User: fahrur
 * Date: 18/11/20
 * Time: 5:33
 */

namespace App\Domain\Item\Models;

use Rakit\Validation\Validation;
use Rakit\Validation\Validator;

class CategoryDto
{
    public $companyId;

    public $name;

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
        ];

        return $validator->make((array)$this, $rules);
    }

    public function getUpdateValidator(): Validation
    {
        $validator = new Validator;

        $rules = [
            'companyId' => 'required',
            'name' => 'required',
            'isActive' => 'required',
        ];

        return $validator->make((array)$this, $rules);
    }
}