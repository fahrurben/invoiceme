<?php
/**
 * Created by PhpStorm.
 * User: fahrur
 * Date: 18/11/20
 * Time: 5:37
 */

namespace App\Domain\Item\Services;

use App\Domain\Item\Models\Category;
use App\Domain\Item\Repositories\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Domain\ValidationException;
use App\Domain\Item\Models\CategoryDto;


class CategoryService implements CategoryServiceInterface
{
    /**
     * @var EntityManagerInterface $entityManager
     */
    private $entityManager;

    /**
     * @var CategoryRepository $repository
     */
    private $repository;

    public function __construct(
        EntityManagerInterface $entityManager,
        CategoryRepository $categoryRepository
    )
    {
        $this->entityManager = $entityManager;
        $this->repository = $categoryRepository;
    }

    /**
     * @param CategoryDto $categoryDto
     * @throws \Exception|ValidationException
     */
    public function create(CategoryDto $categoryDto): Category
    {
        $validator = $categoryDto->getValidator();
        $validator->validate();

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            throw new ValidationException($errors, json_encode($errors));
        }

        $sameCategory = $this->repository->findByName($categoryDto->name);
        if (!empty($sameCategory)) {
            throw new \Exception('Name already exists');
        }

        $category = new Category();
        $category->setName($categoryDto->name);
        $category->setCompanyId($categoryDto->companyId);
        $category->setIsActive(true);

        $this->entityManager->persist($category);
        $this->entityManager->flush();

        return $category;
    }

    /**
     * @param int $id
     * @param CategoryDto $categoryDto
     * @throws \Exception
     */
    public function update(int $id, CategoryDto $categoryDto): Category
    {
        $validator = $categoryDto->getUpdateValidator();
        $validator->validate();

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            throw new ValidationException($errors, json_decode($errors));
        }

        $sameCategory = $this->repository->findByName($categoryDto->name);
        if (!empty($sameCategory) && $sameCategory->getId() !== $id) {
            throw new \Exception('Name already exists');
        }

        $category = $this->repository->find($id);
        $category->setName($categoryDto->name);
        $category->setCompanyId($categoryDto->companyId);
        $category->setIsActive($categoryDto->isActive);

        $this->entityManager->persist($category);
        $this->entityManager->flush();

        return $category;
    }

    /**
     * @param int $id
     * @throws \Exception
     */
    public function delete(int $id)
    {
        $category = $this->repository->find($id);

        if (empty($category)) {
            throw new \Exception('Entity not exists');
        }

        $this->entityManager->remove($category);
        $this->entityManager->flush();
    }
}