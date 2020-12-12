<?php
/**
 * Created by PhpStorm.
 * User: fahrur
 * Date: 20/11/20
 * Time: 5:22
 */

namespace App\Domain\Invoice\Services;

use App\Domain\Invoice\Models\Invoice;
use App\Domain\Invoice\Models\InvoiceDto;
use App\Domain\Invoice\Models\Line;
use App\Domain\Invoice\Repositories\InvoiceRepository;
use App\Domain\Invoice\Repositories\LineRepository;
use App\Domain\Item\Repositories\ItemRepository;
use App\Domain\ValidationException;
use Doctrine\ORM\EntityManagerInterface;

class InvoiceService implements InvoiceServiceInterface
{
    /**
     * @var EntityManagerInterface $entityManager
     */
    private $entityManager;

    /**
     * @var InvoiceRepository $repository
     */
    private $repository;

    /**
     * @var ItemRepository $repository
     */
    private $itemRepository;

    /**
     * @var LineRepository $lineRepository
     */
    private $lineRepository;

    /**
     * InvoiceService constructor.
     * @param EntityManagerInterface $entityManager
     * @param InvoiceRepository $invoiceRepository
     * @param ItemRepository $itemRepository
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        InvoiceRepository $invoiceRepository,
        ItemRepository $itemRepository,
        LineRepository $lineRepository
    )
    {
        $this->entityManager = $entityManager;
        $this->repository = $invoiceRepository;
        $this->itemRepository = $itemRepository;
        $this->lineRepository = $lineRepository;
    }

    /**
     * @param InvoiceDto $invoiceDto
     * @throws \Exception
     */
    public function create(InvoiceDto $invoiceDto): Invoice
    {
        $validator = $invoiceDto->getValidator();
        $validator->validate();

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            throw new ValidationException($errors, json_encode($errors));
        }

        $issueDate = \DateTime::createFromFormat('Y-m-d', $invoiceDto->issueDate);
        $dueDate = \DateTime::createFromFormat('Y-m-d', $invoiceDto->dueDate);
        $subTotal = 0;

        $invoice = new Invoice();
        $invoice->setCompanyId($invoiceDto->companyId);
        $invoice->setNo($invoiceDto->no);
        $invoice->setIssueDate($issueDate);
        $invoice->setDueDate($dueDate);
        $invoice->setCustomerName($invoiceDto->customerName);
        $invoice->setCustomerEmail($invoiceDto->customerEmail);
        $invoice->setTax($invoiceDto->tax);

        foreach ($invoiceDto->lines as $lineDto) {
            $line = new Line();

            $item = $this->itemRepository->find($lineDto->itemId);
            $line->setItem($item);
            $line->setQty($lineDto->qty);
            $line->setPrice($lineDto->price);
            $amount = $line->getQty() * $line->getPrice();
            $line->setAmount($amount);

            $invoice->addLine($line);
            $subTotal += $amount;
        }

        $taxTotal = $invoice->getTax() / 100 * $subTotal;
        $total = $subTotal - $taxTotal;

        $invoice->setSubTotal($subTotal);
        $invoice->setTaxTotal($taxTotal);
        $invoice->setTotal($total);

        $this->entityManager->persist($invoice);
        $this->entityManager->flush();

        return $invoice;
    }

    public function update(int $id, InvoiceDto $invoiceDto): Invoice
    {
        $validator = $invoiceDto->getValidator();
        $validator->validate();

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            throw new ValidationException($errors, json_encode($errors));
        }

        $issueDate = \DateTime::createFromFormat('Y-m-d', $invoiceDto->issueDate);
        $dueDate = \DateTime::createFromFormat('Y-m-d', $invoiceDto->dueDate);
        $subTotal = 0;

        $invoice = $this->repository->find($id);

        if (empty($invoice)) {
            throw new \Exception('Invoice entity not found');
        }

        $invoice->setCompanyId($invoiceDto->companyId);
        $invoice->setNo($invoiceDto->no);
        $invoice->setIssueDate($issueDate);
        $invoice->setDueDate($dueDate);
        $invoice->setCustomerName($invoiceDto->customerName);
        $invoice->setCustomerEmail($invoiceDto->customerEmail);
        $invoice->setTax($invoiceDto->tax);

        foreach ($invoiceDto->lines as $lineDto) {
            $line = isset($lineDto->id) ? $this->lineRepository->find($lineDto->id) : new Line();

            $item = $this->itemRepository->find($lineDto->itemId);
            $line->setItem($item);
            $line->setQty($lineDto->qty);
            $line->setPrice($lineDto->price);
            $amount = $line->getQty() * $line->getPrice();
            $line->setAmount($amount);

            if (!isset($lineDto->id)) {
                $invoice->addLine($line);
            }
            $subTotal += $amount;
        }

        $taxTotal = $invoice->getTax() / 100 * $subTotal;
        $total = $subTotal - $taxTotal;

        $invoice->setSubTotal($subTotal);
        $invoice->setTaxTotal($taxTotal);
        $invoice->setTotal($total);

        $this->entityManager->persist($invoice);
        $this->entityManager->flush();

        return $invoice;
    }

    public function delete(int $id)
    {
        $invoice = $this->repository->find($id);

        if (empty($invoice)) {
            throw new \Exception('Entity not exists');
        }

        $this->entityManager->remove($invoice);
        $this->entityManager->flush();
    }
}