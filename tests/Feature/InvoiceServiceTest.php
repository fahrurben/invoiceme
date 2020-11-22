<?php

namespace Tests\Feature;

use App\Domain\Auth\Models\User;
use App\Domain\Company\Models\Company;
use App\Domain\Invoice\Models\Invoice;
use App\Domain\Invoice\Models\InvoiceDto;
use App\Domain\Invoice\Models\Line;
use App\Domain\Invoice\Models\LineDto;
use App\Domain\Invoice\Repositories\InvoiceRepository;
use App\Domain\Invoice\Services\InvoiceService;
use App\Domain\Item\Models\Category;
use App\Domain\Item\Models\Item;
use App\Domain\Item\Models\ItemDto;
use App\Domain\Item\Repositories\ItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\App;

class InvoiceServiceTest extends TestCase
{
    use RefreshDatabase;

    const TEST_STRING = 'test';
    const TEST_EMAIL = 'test@test.com';

    /**
     * @var EntityManagerInterface $em
     */
    private $em;

    /**
     * @var ItemRepository $itemRepository
     */
    private $itemRepository;

    /**
     * @var InvoiceRepository $repository
     */
    private $repository;

    /**
     * @var InvoiceService $service
     */
    private $service;

    /**
     * @var Company $company
     */
    private $company;

    /**
     * @var Category $category
     */
    private $category;

    /**
     * @var Item $item
     */
    private $item;

    protected function setUp():void
    {
        parent::setUp();
        $user = entity(User::class)->create();
        $this->company = entity(Company::class)->create(['user' => $user]);
        $this->category = entity(Category::class)->create(['name' => 'General', 'companyId' => $this->company->getId()]);
        $this->item = entity(Item::class)->create([
            'companyId' => $this->company->getId(),
            'name' => 'Product 1',
            'type' => 1,
            'category' => $this->category,
        ]);
        $this->em = App::make('Doctrine\ORM\EntityManagerInterface');
        $this->itemRepository = $this->em->getRepository(Item::class);
        $this->repository = $this->em->getRepository(Invoice::class);
        $this->service = new InvoiceService($this->em, $this->repository, $this->itemRepository);
    }

    /**
     * @return void
     */
    public function testCreateInvoice()
    {
        $invoiceDto = new InvoiceDto();
        $invoiceDto->companyId = $this->company->getId();
        $invoiceDto->no = '123';
        $invoiceDto->issueDate = '2020-01-01';
        $invoiceDto->dueDate = '2020-01-01';
        $invoiceDto->customerName = self::TEST_STRING;
        $invoiceDto->customerEmail = self::TEST_EMAIL;
        $invoiceDto->tax = 10;

        $lineDto = new LineDto();
        $lineDto->itemId = $this->item->getId();
        $lineDto->qty = 1;
        $lineDto->price = 100;

        $invoiceDto->lines[] = $lineDto;

        $this->service->create($invoiceDto);
    }
}
