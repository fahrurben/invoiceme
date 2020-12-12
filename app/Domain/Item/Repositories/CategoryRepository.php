<?php
/**
 * Created by PhpStorm.
 * User: fahrur
 * Date: 18/11/20
 * Time: 5:31
 */

namespace App\Domain\Item\Repositories;


use App\Constant;
use App\Domain\BaseRepository;
use App\Domain\Item\Models\Category;
use App\Domain\Item\Models\CategoryDto;
use App\SearchResult;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;

class CategoryRepository extends BaseRepository
{
    public function findByName($companyId, $name)
    {
        $qb = $this->_em->createQueryBuilder();

        $qb->select('c')
            ->from(Category::class, 'c')
            ->where('c.name = ?1')
            ->andWhere('c.companyId = ?2')
            ->setParameter(1, $name)
            ->setParameter(2, $companyId);

        $query = $qb->getQuery();

        return $query->getOneOrNullResult();
    }

    public function getAllActive($companyId)
    {
        $qb = $this->_em->createQueryBuilder();

        $qb->select('c')
            ->from(Category::class, 'c')
            ->where('c.isActive = true')
            ->andWhere('c.companyId = ?1')
            ->setParameter(1, $companyId);

        $query = $qb->getQuery();

        return $query->getResult();
    }

    public function getSearchParameter($dto, QueryBuilder &$qb)
    {
        $param_key = 0;

        if (!empty($dto->companyId)) {
            $qb->andWhere($qb->expr()->eq('o.companyId', "?{$param_key}"));
            $qb->setParameter($param_key, $dto->companyId);
        }

        if (!empty($dto->name)) {
            $qb->andWhere($qb->expr()->like('o.name', "?{$param_key}"));
            $qb->setParameter($param_key, "%{$dto->name}%");
            $param_key++;
        }

        if (!empty($dto->isActive)) {
            $qb->andWhere($qb->expr()->eq('o.isActive', "?{$param_key}"));
            $qb->setParameter($param_key, "{$dto->isActive}");
        }
    }
}