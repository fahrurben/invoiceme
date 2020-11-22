<?php

namespace Tests\Unit;

use App\Domain\Invoice\Models\Invoice;
use App\Domain\Invoice\Models\InvoiceDto;
use App\Domain\Invoice\Models\LineDto;
use App\Domain\Invoice\Repositories\InvoiceRepository;
use App\Domain\Invoice\Repositories\LineRepository;
use App\Domain\Invoice\Services\InvoiceService;
use App\Domain\Item\Models\Item;
use App\Domain\Item\Repositories\ItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class InvoiceServiceTest extends TestCase
{

    const TEST_STRING = 'test';
    const TEST_EMAIL = 'test@test.com';

    private $mockEm;

    /**
     * @var InvoiceRepository $mockRepository
     */
    private $mockRepository;

    /**
     * @var InvoiceService $invoiceService;
     */
    private $invoiceService;

    /**
     * @var ItemRepository $mockItemRepository
     */
    private $mockItemRepository;

    /**
     * @var LineRepository $mockLineRepository
     */
    private $mockLineRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mockEm = $this->getMockBuilder(EntityManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mockRepository = $this->getMockBuilder(InvoiceRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mockItemRepository = $this->getMockBuilder(ItemRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mockLineRepository = $this->getMockBuilder(LineRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->invoiceService = new InvoiceService(
            $this->mockEm,
            $this->mockRepository,
            $this->mockItemRepository,
            $this->mockLineRepository
        );
    }

    /**
     * @return void
     */
    public function testCreateThrowExceptionWhenDtoIsNotValid()
    {
        $invoiceDto = new InvoiceDto();

        $this->expectException("Exception");
        $this->invoiceService->create($invoiceDto);
    }

    public function testCreateSuccessWhenDtoIsValid()
    {
        $invoiceDto = new InvoiceDto();
        $invoiceDto->companyId = 1;
        $invoiceDto->no = '1';
        $invoiceDto->issueDate = '2020-01-01';
        $invoiceDto->dueDate = '2020-01-01';
        $invoiceDto->customerName = self::TEST_STRING;
        $invoiceDto->customerEmail = self::TEST_EMAIL;
        $invoiceDto->tax = 10;

        $this->invoiceService->create($invoiceDto);
    }

    public function testCalculationTotalIsCorrect()
    {
        $invoiceDto = new InvoiceDto();
        $invoiceDto->companyId = 1;
        $invoiceDto->no = '1';
        $invoiceDto->issueDate = '2020-01-01';
        $invoiceDto->dueDate = '2020-01-01';
        $invoiceDto->customerName = self::TEST_STRING;
        $invoiceDto->customerEmail = self::TEST_EMAIL;
        $invoiceDto->tax = 10;

        $itemMock = $this->getMockBuilder(Item::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mockItemRepository
            ->expects($this->once())
            ->method('find')
            ->willReturn($itemMock);

        $line = new LineDto();
        $line->itemId = 1;
        $line->qty = 1;
        $line->price = 100;

        $invoiceDto->lines[] = $line;

        $invoice = $this->invoiceService->create($invoiceDto);
        $this->assertEquals(100, $invoice->getSubTotal());
        $this->assertEquals(10, $invoice->getTaxTotal());
        $this->assertEquals(90, $invoice->getTotal());
    }

    public function testUpdateSuccess()
    {
        $invoiceId = 1;

        $invoiceDto = new InvoiceDto();
        $invoiceDto->companyId = 1;
        $invoiceDto->no = '1';
        $invoiceDto->issueDate = '2020-01-01';
        $invoiceDto->dueDate = '2020-01-01';
        $invoiceDto->customerName = self::TEST_STRING;
        $invoiceDto->customerEmail = self::TEST_EMAIL;
        $invoiceDto->tax = 10;

        $invoiceMock = new Invoice();
        $invoiceMock->setId(1);

        $this->mockRepository
            ->expects($this->once())
            ->method('find')
            ->willReturn($invoiceMock);

        $itemMock = $this->getMockBuilder(Item::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mockItemRepository
            ->expects($this->once())
            ->method('find')
            ->willReturn($itemMock);

        $line = new LineDto();
        $line->itemId = 1;
        $line->qty = 1;
        $line->price = 100;

        $invoiceDto->lines[] = $line;

        $invoice = $this->invoiceService->update($invoiceId, $invoiceDto);

        $this->assertEquals(100, $invoice->getSubTotal());
        $this->assertEquals(10, $invoice->getTaxTotal());
        $this->assertEquals(90, $invoice->getTotal());
    }

    public function testDeleteSuccess()
    {
        $existingItem = new Invoice();
        $existingItem->setId(1);

        $this->mockRepository
            ->expects($this->once())
            ->method('find')
            ->willReturn($existingItem);

        $this->invoiceService->delete(1);
    }
}
