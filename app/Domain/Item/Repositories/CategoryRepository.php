<?php
/**
 * Created by PhpStorm.
 * User: fahrur
 * Date: 18/11/20
 * Time: 5:31
 */

namespace App\Domain\Item\Repositories;


use App\Constant;
use App\Domain\Item\Models\Category;
use App\Domain\Item\Models\CategoryDto;
use App\SearchResult;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;

class CategoryRepository extends EntityRepository
{
    public function findByName($name)
    {
        $qb = $this->_em->createQueryBuilder();

        $qb->select('c')
            ->from(Category::class, 'c')
            ->where('c.name = ?1')
            ->setParameter(1, $name);

        $query = $qb->getQuery();

        return $query->getOneOrNullResult();
    }

    public function search(CategoryDto $dto, int $page = 1, int $size = Constant::DEFAULT_PAGING_SIZE,
                           string $sortBy = 'name', string $sortType = Constant::SORT_ASCENDING)
    {
        $param_key = 0;

        $qb = $this->_em->createQueryBuilder();

        $qb->select('c')
            ->from(Category::class, 'c');

        if (!empty($dto->name)) {
            $qb->andWhere($qb->expr()->like('c.name', "?{$param_key}"));
            $qb->setParameter($param_key, "%{$dto->name}%");
            $param_key++;
        }

        if (!empty($dto->isActive)) {
            $qb->andWhere($qb->expr()->eq('c.isActive', "?{$param_key}"));
            $qb->setParameter($param_key, "{$dto->isActive}");
        }

        $qb->orderBy("c.$sortBy", $sortType);

        $query = $qb->getQuery()
            ->setFirstResult(($page - 1) * $size)
            ->setMaxResults($size);

        $paginator = new Paginator($query);

        $total = $paginator->count();
        $total_page = (int)($total / $size);
        $total_page += $total % $size !== 0 ? 1 : 0;

        return new SearchResult($page, $size, $total, $total_page, $paginator->getIterator());
    }
}