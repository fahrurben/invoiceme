<?php
/**
 * Created by PhpStorm.
 * User: fahrur
 * Date: 19/11/20
 * Time: 5:50
 */

namespace App\Domain\Item\Services;


use App\Domain\Item\Models\Item;
use App\Domain\Item\Models\ItemDto;

interface ItemServiceInterface
{
    public function create(ItemDto $itemDto): Item;

    public function update(int $id, ItemDto $itemDto): Item;

    public function delete(int $id);
}