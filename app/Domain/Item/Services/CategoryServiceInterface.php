<?php
/**
 * Created by PhpStorm.
 * User: fahrur
 * Date: 18/11/20
 * Time: 5:32
 */

namespace App\Domain\Item\Services;


use App\Domain\Item\Models\CategoryDto;

interface CategoryServiceInterface
{
    public function create(CategoryDto $categoryDto);

    public function update(int $id, CategoryDto $categoryDto);

    public function delete(int $id);
}