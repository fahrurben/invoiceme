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
use Illuminate\Validation\ValidationException;
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
     * @throws \Exception
     */
    public function create(CategoryDto $categoryDto)
    {
        $validator = $categoryDto->getValidator();
        $validator->validate();

        if ($validator->fails()) {
            $errors = $validator->errors();
            $error = $errors->firstOfAll();
            throw ValidationException::withMessages($error);
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
    }

    /**
     * @param int $id
     * @param CategoryDto $categoryDto
     * @throws \Exception
     */
    public function update(int $id, CategoryDto $categoryDto)
    {
        $validator = $categoryDto->getUpdateValidator();
        $validator->validate();

        if ($validator->fails()) {
            $errors = $validator->errors();
            $error = $errors->firstOfAll();
            throw ValidationException::withMessages($error);
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