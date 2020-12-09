<?php
/**
 * Created by PhpStorm.
 * User: fahrur
 * Date: 19/11/20
 * Time: 5:54
 */

namespace App\Domain\Item\Repositories;

use App\Domain\BaseRepository;
use App\Domain\Item\Models\Item;
use App\Domain\Item\Models\ItemDto;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;

class ItemRepository extends BaseRepository
{
    public function findByName($name)
    {
        $qb = $this->_em->createQueryBuilder();

        $qb->select('i')
            ->from(Item::class, 'i')
            ->where('i.name = ?1')
            ->setParameter(1, $name);

        $query = $qb->getQuery();

        return $query->getOneOrNullResult();
    }

    public function getAllActive($companyId)
    {
        $qb = $this->_em->createQueryBuilder();

        $qb->select('o')
            ->from(Item::class, 'o')
            ->where('o.isActive = true')
            ->andWhere('o.companyId = ?1')
            ->setParameter(1, $companyId);

        $query = $qb->getQuery();

        return $query->getResult();
    }

    /**
     * @param ItemDto $dto
     * @param QueryBuilder $qb
     */
    public function getSearchParameter($dto, QueryBuilder &$qb)
    {
        $qb->innerJoin('o.category', 'c');

        $param_key = 0;

        if (!empty($dto->name)) {
            $qb->andWhere($qb->expr()->like('o.name', "?{$param_key}"));
            $qb->setParameter($param_key, "%{$dto->name}%");
            $param_key++;
        }

        if (!empty($dto->type)) {
            $qb->andWhere($qb->expr()->eq('o.type', "?{$param_key}"));
            $qb->setParameter($param_key, $dto->type);
            $param_key++;
        }

        if (!empty($dto->categoryId)) {
            $qb->andWhere($qb->expr()->eq('c.id', "?{$param_key}"));
            $qb->setParameter($param_key, $dto->categoryId);
            $param_key++;
        }

        if (!empty($dto->isActive)) {
            $qb->andWhere($qb->expr()->eq('o.isActive', "?{$param_key}"));
            $qb->setParameter($param_key, "{$dto->isActive}");
        }
    }
}