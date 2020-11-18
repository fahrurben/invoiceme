<?php

namespace Tests\Feature;

use App\Domain\Auth\Models\User;
use App\Domain\Company\Models\Company;
use App\Domain\Item\Models\Category;
use App\Domain\Item\Models\CategoryDto;
use App\Domain\Item\Repositories\CategoryRepository;
use App\Domain\Item\Services\CategoryService;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\App;

class CategoryServiceTest extends TestCase
{
    use RefreshDatabase;

    const TEST_STRING = 'test';
    const TEST_EMAIL = 'test@test.com';

    /**
     * @var EntityManagerInterface $em
     */
    private $em;

    /**
     * @var CategoryRepository $repository
     */
    private $repository;

    /**
     * @var Company $company
     */
    private $company;

    /**
     * @var CategoryService $service
     */
    private $service;

    protected function setUp():void
    {
        parent::setUp();
        $user = entity(User::class)->create();
        $this->company = entity(Company::class)->create(['user' => $user]);
        $this->em = App::make('Doctrine\ORM\EntityManagerInterface');
        $this->repository = $this->em->getRepository(Category::class);
        $this->service = new CategoryService($this->em, $this->repository);
    }

    /**
     * @return void
     */
    public function testCreateCategory()
    {
        $categoryDto = new CategoryDto();
        $categoryDto->name = 'test';
        $categoryDto->companyId = $this->company->getId();
        $categoryDto->isActive = true;

        $this->service->create($categoryDto);

        $category = $this->repository->findByName($categoryDto->name);
        $this->assertNotNull($category);
    }
}
