<?php
/**
 * Created by PhpStorm.
 * User: fahrur
 * Date: 14/11/20
 * Time: 5:30
 */

namespace App\Domain\Invoice\Models;

use App\Domain\ArrayExpressible;
use App\Domain\MultiTenantEntity;
use /** @noinspection PhpUnusedAliasInspection */
    Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="\App\Domain\Invoice\Repositories\InvoiceRepository")
 * @ORM\Table(name="invoice")
 */
class Invoice implements ArrayExpressible
{
    use MultiTenantEntity;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $no;

    /**
     * @ORM\Column(name="issue_date", type="date")
     */
    protected $issueDate;

    /**
     * @ORM\Column(name="due_date", type="date")
     */
    protected $dueDate;

    /**
     * @ORM\Column(name="customer_name", type="string")
     */
    protected $customerName;

    /**
     * @ORM\Column(name="customer_email", type="string")
     */
    protected $customerEmail;

    /**
     * @ORM\OneToMany(targetEntity="Line", mappedBy="invoice", cascade={"persist", "merge"})
     * @var Invoice[] $lines
     */
    private $lines;

    /**
     * @ORM\Column(name="sub_total", type="decimal", precision=9, scale=2)
     */
    protected $subTotal;

    /**
     * @ORM\Column(name="tax", type="decimal", precision=9, scale=2)
     */
    protected $tax;

    /**
     * @ORM\Column(name="tax_total", type="decimal", precision=9, scale=2)
     */
    protected $taxTotal;

    /**
     * @ORM\Column(name="total", type="decimal", precision=9, scale=2)
     */
    protected $total;

    public function __construct()
    {
        $this->lines = [];
    }

    public function toArray()
    {
        $data = get_object_vars($this);
        $data['lines'] = [];
        foreach ($this->lines as $line) {
            $data['lines'][] = $line->toArray();
        }

        return $data;
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
     * @return string
     */
    public function getNo(): ?string
    {
        return $this->no;
    }

    /**
     * @param string $no
     */
    public function setNo(string $no): void
    {
        $this->no = $no;
    }

    /**
     * @return \DateTime
     */
    public function getIssueDate(): ?\DateTime
    {
        return $this->issueDate;
    }

    /**
     * @param \DateTime $issueDate
     */
    public function setIssueDate(\DateTime $issueDate): void
    {
        $this->issueDate = $issueDate;
    }

    /**
     * @return \DateTime
     */
    public function getDueDate(): ?\DateTime
    {
        return $this->dueDate;
    }

    /**
     * @param \DateTime $dueDate
     */
    public function setDueDate(\DateTime $dueDate): void
    {
        $this->dueDate = $dueDate;
    }

    /**
     * @return string
     */
    public function getCustomerName(): ?string
    {
        return $this->customerName;
    }

    /**
     * @param string $customerName
     */
    public function setCustomerName(string $customerName): void
    {
        $this->customerName = $customerName;
    }

    /**
     * @return mixed
     */
    public function getCustomerEmail(): ?string
    {
        return $this->customerEmail;
    }

    /**
     * @param string $customerEmail
     */
    public function setCustomerEmail(string $customerEmail): void
    {
        $this->customerEmail = $customerEmail;
    }

    /**
     * @return Invoice[]
     */
    public function getLines(): array
    {
        return $this->lines;
    }

    /**
     * @param Invoice[] $lines
     */
    public function setLines(array $lines): void
    {
        $this->lines = $lines;
    }

    /**
     * @param Line $line
     */
    public function addLine(Line $line): void
    {
        $line->setInvoice($this);
        $this->lines[] = $line;
    }

    /**
     * @return float
     */
    public function getSubTotal(): ?float
    {
        return floatval($this->subTotal);
    }

    /**
     * @param mixed $subTotal
     */
    public function setSubTotal($subTotal): void
    {
        $this->subTotal = $subTotal;
    }

    /**
     * @return float
     */
    public function getTax(): ?float
    {
        return floatval($this->tax);
    }

    /**
     * @param float $tax
     */
    public function setTax(float $tax): void
    {
        $this->tax = $tax;
    }

    /**
     * @return float
     */
    public function getTaxTotal(): ?float
    {
        return floatval($this->taxTotal);
    }

    /**
     * @param float $taxTotal
     */
    public function setTaxTotal(float $taxTotal): void
    {
        $this->taxTotal = $taxTotal;
    }

    /**
     * @return float
     */
    public function getTotal(): ?float
    {
        return floatval($this->total);
    }

    /**
     * @param float $total
     */
    public function setTotal(float $total): void
    {
        $this->total = $total;
    }

}