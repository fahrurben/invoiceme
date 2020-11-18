<?php
/**
 * Created by PhpStorm.
 * User: fahrur
 * Date: 18/11/20
 * Time: 5:31
 */

namespace App\Domain\Item\Repositories;


use App\Domain\Item\Models\Category;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;

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
}