<?php
/**
 * Created by PhpStorm.
 * User: fahrur
 * Date: 14/11/20
 * Time: 5:40
 */

namespace App\Domain\Invoice\Models;

use App\Domain\Item\Models\Item;
use /** @noinspection PhpUnusedAliasInspection */
    Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="\App\Domain\Invoice\Repositories\LineRepository")
 * @ORM\Table(name="invoice_line")
 */
class Line
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Invoice")
     * @ORM\JoinColumn(name="invoice_id", nullable=false)
     */
    protected $invoice;

    /**
     * @ORM\OneToOne(targetEntity="App\Domain\Item\Models\Item")
     * @ORM\JoinColumn(name="item_id")
     */
    protected $item;

    /**
     * @ORM\Column(name="qty", type="decimal", precision=9, scale=2)
     */
    protected $qty;

    /**
     * @ORM\Column(name="price", type="decimal", precision=9, scale=2)
     */
    protected $price;

    /**
     * @ORM\Column(name="amount", type="decimal", precision=9, scale=2)
     */
    protected $amount;

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
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return Invoice
     */
    public function getInvoice(): ?Invoice
    {
        return $this->invoice;
    }

    /**
     * @param Invoice $invoice
     */
    public function setInvoice(Invoice $invoice): void
    {
        $this->invoice = $invoice;
    }

    /**
     * @return Item
     */
    public function getItem(): ?Item
    {
        return $this->item;
    }

    /**
     * @param Item $item
     */
    public function setItem(Item $item): void
    {
        $this->item = $item;
    }

    /**
     * @return float
     */
    public function getQty(): ?float
    {
        return floatval($this->qty);
    }

    /**
     * @param float $qty
     */
    public function setQty(float $qty): void
    {
        $this->qty = $qty;
    }

    /**
     * @return float
     */
    public function getPrice(): ?float
    {
        return floatval($this->price);
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    /**
     * @return float
     */
    public function getAmount(): ?float
    {
        return floatval($this->amount);
    }

    /**
     * @param float $amount
     */
    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

}