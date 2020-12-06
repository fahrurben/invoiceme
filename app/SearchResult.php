<?php
/**
 * Created by PhpStorm.
 * User: fahrur
 * Date: 02/12/20
 * Time: 4:46
 */

namespace App;


class SearchResult
{
    public $page;

    public $size;

    public $total;

    public $total_page;

    public $items;

    public function __construct($page, $size, $total, $total_page, $items)
    {
        $this->page = $page;
        $this->size = $size;
        $this->total = $total;
        $this->total_page = $total_page;
        $this->items = $items;
    }

    public function getArrayData()
    {
        $data = [];
        $sourceData = iterator_to_array($this->items, false);
        foreach ($sourceData as $datum) {
            $data[] = $datum->toArray();
        }
        return $data;
    }
}