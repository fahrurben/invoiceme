<?php

namespace Tests\Feature;

use App\Domain\Auth\Models\User;
use App\Domain\Company\Models\Company;
use App\Domain\Item\Models\Category;
use App\Domain\Item\Models\Item;
use App\Domain\Item\Models\ItemDto;
use App\Domain\Item\Repositories\CategoryRepository;
use App\Domain\Item\Repositories\ItemRepository;
use App\Domain\Item\Services\ItemService;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\App;

class ItemServiceTest extends TestCase
{
    use RefreshDatabase;

    const TEST_STRING = 'test';
    const TEST_EMAIL = 'test@test.com';

    /**
     * @var EntityManagerInterface $em
     */
    private $em;

    /**
     * @var ItemRepository $repository
     */
    private $repository;

    /**
     * @var CategoryRepository $categoryRepository
     */
    private $categoryRepository;

    /**
     * @var Company $company
     */
    private $company;

    /**
     * @var Category $category
     */
    private $category;

    /**
     * @var ItemService $service
     */
    private $service;

    protected function setUp():void
    {
        parent::setUp();
        $user = entity(User::class)->create();
        $this->company = entity(Company::class)->create(['user' => $user]);
        $this->category = entity(Category::class)->create(['name' => 'General', 'companyId' => $this->company->getId()]);
        $this->em = App::make('Doctrine\ORM\EntityManagerInterface');
        $this->repository = $this->em->getRepository(Item::class);
        $this->categoryRepository = $this->em->getRepository(Category::class);
        $this->service = new ItemService($this->em, $this->repository, $this->categoryRepository);
    }

    /**
     * @return void
     */
    public function testCreateItem()
    {
        $itemDto = new ItemDto();
        $itemDto->name = 'test';
        $itemDto->type = 1;
        $itemDto->categoryId = $this->category->getId();
        $itemDto->companyId = $this->company->getId();
        $itemDto->isActive = true;

        $this->service->create($itemDto);

        $item = $this->repository->findByName($itemDto->name);
        $this->assertNotNull($item);
    }
}
