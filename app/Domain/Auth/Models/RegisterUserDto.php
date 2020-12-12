<?php
/**
 * Created by PhpStorm.
 * User: fahrur
 * Date: 14/11/20
 * Time: 10:33
 */

namespace App\Domain\Auth\Models;

use Rakit\Validation\Validation;
use Rakit\Validation\Validator;

class RegisterUserDto
{
    public $name;

    public $email;

    public $password;

    public $companyName;

    public $address;

    public $city;

    public $phone;

    public $companyEmail;

    public $logo;

    public function __construct()
    {
    }

    public function fromArray($data)
    {
        $this->name = $data['name'] ?? '';
        $this->email  = $data['email'] ?? '';
        $this->password  = $data['password'] ?? '';
        $this->companyName = $data['companyName'] ?? '';
        $this->address  = $data['address'] ?? '';
        $this->city  = $data['city'] ?? '';
        $this->phone  = $data['phone'] ?? '';
        $this->companyEmail  = $data['companyEmail'] ?? '';
    }

    public function getCreateValidator(): Validation
    {
        $validator = new Validator;

        $rules = [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'companyName' => 'nullable',
            'address' => 'required',
            'city' => 'required',
            'phone' => 'nullable',
            'companyEmail' => 'email',
            ];

        return $validator->make((array)$this, $rules);
    }


}