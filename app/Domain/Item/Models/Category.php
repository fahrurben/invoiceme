<?php
/**
 * Created by PhpStorm.
 * User: fahrur
 * Date: 13/11/20
 * Time: 6:29
 */

namespace App\Domain\Item\Models;

use App\Domain\ArrayExpressibleEntity;
use App\Domain\MultiTenantEntity;
use /** @noinspection PhpUnusedAliasInspection */
    Doctrine\ORM\Mapping as ORM;
use App\Domain\ArrayExpressible;

/**
 * @ORM\Entity(repositoryClass="\App\Domain\Item\Repositories\CategoryRepository")
 * @ORM\Table(name="item_category")
 */
class Category implements ArrayExpressible
{
    use MultiTenantEntity, ArrayExpressibleEntity;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    protected $isActive;

    public function __construct()
    {
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return bool
     */
    public function getisActive(): ?bool
    {
        return $this->isActive;
    }

    /**
     * @param bool $isActive
     */
    public function setIsActive(bool $isActive)
    {
        $this->isActive = $isActive;
    }

}