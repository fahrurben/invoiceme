<?php
/**
 * Created by PhpStorm.
 * User: fahrur
 * Date: 19/11/20
 * Time: 5:54
 */

namespace App\Domain\Item\Repositories;

use App\Domain\Item\Models\Item;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

class ItemRepository extends EntityRepository
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
}