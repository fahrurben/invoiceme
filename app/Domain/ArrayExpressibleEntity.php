<?php
/**
 * Created by PhpStorm.
 * User: fahrur
 * Date: 08/12/20
 * Time: 3:13
 */

namespace App\Domain;


trait ArrayExpressibleEntity
{
    public function toArray()
    {
        return get_object_vars($this);
    }
}