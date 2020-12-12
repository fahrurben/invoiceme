<?php
/**
 * Created by PhpStorm.
 * User: fahrur
 * Date: 19/11/20
 * Time: 5:54
 */

namespace App\Domain\Item\Services;

use App\Domain\Item\Models\Category;
use App\Domain\Item\Models\Item;
use App\Domain\Item\Models\ItemDto;
use App\Domain\Item\Repositories\CategoryRepository;
use App\Domain\Item\Repositories\ItemRepository;
use App\Domain\ValidationException;
use Doctrine\ORM\EntityManagerInterface;

class ItemService implements ItemServiceInterface
{
    /**
     * @var EntityManagerInterface $entityManager
     */
    private $entityManager;

    /**
     * @var ItemRepository $repository
     */
    private $repository;

    /**
     * @var CategoryRepository $categoryRepository
     */
    private $categoryRepository;

    /**
     * ItemService constructor.
     * @param EntityManagerInterface $entityManager
     * @param ItemRepository $itemRepository
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        ItemRepository $itemRepository,
        CategoryRepository $categoryRepository
    )
    {
        $this->entityManager = $entityManager;
        $this->repository = $itemRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param ItemDto $itemDto
     * @throws \Exception|\App\Domain\ValidationException
     */
    public function create(ItemDto $itemDto): Item
    {
        $validator = $itemDto->getValidator();
        $validator->validate();

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            throw new ValidationException($errors, json_encode($errors));
        }

        $sameNameItem = $this->repository->findByName($itemDto->companyId, $itemDto->name);
        if (!empty($sameNameItem)) {
            throw new \Exception('Name already exists');
        }

        /**
         * @var Category $category
         */
        $category = $this->categoryRepository->find($itemDto->categoryId);

        if (empty($category)) {
            throw new \Exception('Category not exists');
        }

        $item = new Item();
        $item->setCompanyId($itemDto->companyId);
        $item->setName($itemDto->name);
        $item->setType($itemDto->type);
        $item->setCategory($category);
        $item->setIsActive(true);

        $this->entityManager->persist($item);
        $this->entityManager->flush();

        return $item;
    }

    /**
     * @param int $id
     * @param ItemDto $itemDto
     * @throws \Exception
     */
    public function update(int $id, ItemDto $itemDto): Item
    {
        $validator = $itemDto->getValidator();
        $validator->validate();

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            throw new ValidationException($errors, json_encode($errors));
        }

        $sameNameItem = $this->repository->findByName($itemDto->companyId, $itemDto->name);
        if (!empty($sameNameItem) && $sameNameItem->getId() !== $id) {
            throw new \Exception('Name already exists');
        }

        $category = $this->categoryRepository->find($itemDto->categoryId);

        if (empty($category)) {
            throw new \Exception('Category not exists');
        }

        $item = $this->repository->find($id);

        if (empty($item)) {
            throw new \Exception('Item not exists');
        }

        $item->setCompanyId($itemDto->companyId);
        $item->setName($itemDto->name);
        $item->setType($itemDto->type);
        $item->setCategory($category);
        $item->setIsActive($itemDto->isActive);

        $this->entityManager->persist($item);
        $this->entityManager->flush();

        return $item;
    }

    /**
     * @param int $id
     * @throws \Exception
     */
    public function delete(int $id)
    {
        $item = $this->repository->find($id);

        if (empty($item)) {
            throw new \Exception('Entity not exists');
        }

        $this->entityManager->remove($item);
        $this->entityManager->flush();
    }
}