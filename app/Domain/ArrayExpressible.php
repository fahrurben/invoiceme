<?php
/**
 * Created by PhpStorm.
 * User: fahrur
 * Date: 06/12/20
 * Time: 13:59
 */

namespace App\Domain;


interface ArrayExpressible
{
    public function toArray();
}