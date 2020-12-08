<?php
/**
 * Created by PhpStorm.
 * User: fahrur
 * Date: 08/12/20
 * Time: 4:40
 */

namespace App\Helper;


class CommonHelper
{
    public static function getArrayFromCollection($list)
    {
        $data = [];
        foreach ($list as $datum) {
            $data[] = $datum->toArray();
        }
        return $data;
    }
}