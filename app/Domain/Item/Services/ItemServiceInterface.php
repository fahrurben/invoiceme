<?php
/**
 * Created by PhpStorm.
 * User: fahrur
 * Date: 19/11/20
 * Time: 5:50
 */

namespace App\Domain\Item\Services;


use App\Domain\Item\Models\ItemDto;

interface ItemServiceInterface
{
    public function create(ItemDto $itemDto);

    public function update(int $id, ItemDto $itemDto);

    public function delete(int $id);
}