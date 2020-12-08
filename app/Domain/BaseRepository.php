<?php
/**
 * Created by PhpStorm.
 * User: fahrur
 * Date: 08/12/20
 * Time: 3:22
 */

namespace App\Domain;


use App\Constant;
use App\SearchResult;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;

class BaseRepository extends EntityRepository
{
    public function search($clazz, $dto, int $page = 1, int $size = Constant::DEFAULT_PAGING_SIZE,
                           string $sortBy = 'name', string $sortType = Constant::SORT_ASCENDING)
    {

        $qb = $this->_em->createQueryBuilder();

        $qb->select('o')
            ->from($clazz, 'o');

        $this->getSearchParameter($dto, $qb);

        $qb->orderBy("o.$sortBy", $sortType);

        $query = $qb->getQuery()
            ->setFirstResult(($page - 1) * $size)
            ->setMaxResults($size);

        $paginator = new Paginator($query);

        $total = $paginator->count();
        $total_page = (int)($total / $size);
        $total_page += $total % $size !== 0 ? 1 : 0;

        return new SearchResult($page, $size, $total, $total_page, $paginator->getIterator());
    }

    public function getSearchParameter($dto, QueryBuilder &$qb)
    {

    }
}