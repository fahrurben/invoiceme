<?php
/**
 * Created by PhpStorm.
 * User: fahrur
 * Date: 03/12/20
 * Time: 5:31
 */

namespace App\Domain\Company\Repositories;


use App\Domain\Auth\Models\User;
use Doctrine\ORM\EntityRepository;

class CompanyRepository extends EntityRepository
{
    public function getByUser(User $user)
    {
        return $this->createQueryBuilder('company')
            ->andWhere('company.user = :user')
            ->setParameter('user', $user)
            ->getQuery()->getSingleResult();
    }
}