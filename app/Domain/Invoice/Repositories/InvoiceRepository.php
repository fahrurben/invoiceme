<?php
/**
 * Created by PhpStorm.
 * User: fahrur
 * Date: 20/11/20
 * Time: 5:14
 */

namespace App\Domain\Invoice\Repositories;

use App\Domain\BaseRepository;
use Doctrine\ORM\QueryBuilder;

class InvoiceRepository extends BaseRepository
{
    public function getSearchParameter($dto, QueryBuilder &$qb)
    {
        $param_key = 0;

        if (!empty($dto->companyId)) {
            $qb->andWhere($qb->expr()->eq('o.companyId', "?{$param_key}"));
            $qb->setParameter($param_key, $dto->companyId);
        }

        if (!empty($dto->customerName)) {
            $qb->andWhere($qb->expr()->like('o.customerName', "?{$param_key}"));
            $qb->setParameter($param_key, "%{$dto->customerName}%");
            $param_key++;
        }

        if (!empty($dto->issueFrom)) {
            $qb->andWhere($qb->expr()->gte('o.issueDate', "?{$param_key}"));
            $qb->setParameter($param_key, $dto->issueFrom);
            $param_key++;
        }

        if (!empty($dto->issueTo)) {
            $qb->andWhere($qb->expr()->lte('o.issueDate', "?{$param_key}"));
            $qb->setParameter($param_key, $dto->issueTo);
            $param_key++;
        }

        if (!empty($dto->dueFrom)) {
            $qb->andWhere($qb->expr()->gte('o.dueDate', "?{$param_key}"));
            $qb->setParameter($param_key, $dto->dueFrom);
            $param_key++;
        }

        if (!empty($dto->dueTo)) {
            $qb->andWhere($qb->expr()->lte('o.dueDate', "?{$param_key}"));
            $qb->setParameter($param_key, $dto->dueTo);
            $param_key++;
        }
    }
}