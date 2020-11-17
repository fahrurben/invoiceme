<?php
/**
 * Created by PhpStorm.
 * User: fahrur
 * Date: 14/11/20
 * Time: 10:32
 */

namespace App\Domain\Auth\Services;


use App\Domain\Auth\Models\RegisterUserDto;

interface UserServiceInterface
{
    public function register(RegisterUserDto $registerUserDto);
}