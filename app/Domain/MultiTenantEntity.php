<?php
/**
 * Created by PhpStorm.
 * User: fahrur
 * Date: 18/11/20
 * Time: 5:55
 */

namespace App\Domain;


use /** @noinspection PhpUnusedAliasInspection */
    Doctrine\ORM\Mapping as ORM;

trait MultiTenantEntity
{
    /**
     * @ORM\Column(name="company_id", type="integer")
     */
    protected $companyId;

    /**
     * @return int
     */
    public function getCompanyId(): ?int
    {
        return $this->companyId;
    }

    /**
     * @param int $companyId
     */
    public function setCompanyId(int $companyId): void
    {
        $this->companyId = $companyId;
    }
}