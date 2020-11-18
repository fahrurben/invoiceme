<?php

namespace Tests\Unit;

use App\Domain\Item\Models\Category;
use App\Domain\Item\Models\CategoryDto;
use App\Domain\Item\Repositories\CategoryRepository;
use App\Domain\Item\Services\CategoryService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class CategoryServiceTest extends TestCase
{
    const TEST_STRING = 'test';
    const TEST_EMAIL = 'test@test.com';

    private $mockEm;

    private $mockRepository;

    /**
     * @var CategoryService $categoryService
     */
    private $categoryService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mockEm = $this->getMockBuilder(EntityManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mockRepository = $this->getMockBuilder(CategoryRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->categoryService = new CategoryService($this->mockEm, $this->mockRepository);
    }

    /**
     * @return void
     */
    public function testCreateThrowExceptionWhenDtoIsNotValid()
    {
        $categoryDto = new CategoryDto();

        $this->expectException("Exception");
        $this->categoryService->create($categoryDto);
    }

    public function testCreateThrowExceptionWhenNameAlreadyExist()
    {
        $categoryDto = new CategoryDto();
        $categoryDto->companyId =  1;
        $categoryDto->name = self::TEST_STRING;
        $categoryDto->isActive = true;

        $categoryMock = $this->getMockBuilder(Category::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mockRepository
            ->expects($this->once())
            ->method('findByName')
            ->willReturn($categoryMock);

        $this->expectException("Exception");
        $this->categoryService->create($categoryDto);
    }

    public function testCreatePersistEntityWhenDtoIsValid()
    {
        $categoryDto = new CategoryDto();
        $categoryDto->companyId =  1;
        $categoryDto->name = self::TEST_STRING;
        $categoryDto->isActive = true;

        $this->mockRepository
            ->expects($this->once())
            ->method('findByName')
            ->willReturn(null);

        $this->mockEm->expects($this->exactly(1))
            ->method('persist');

        $this->mockEm->expects($this->exactly(1))
            ->method('flush');
        $this->categoryService->create($categoryDto);
    }

    public function testUpdateThrowExceptionWhenDtoIsNotValid()
    {
        $categoryDto = new CategoryDto();

        $this->expectException("Exception");
        $this->categoryService->update(1, $categoryDto);
    }

    public function testUpdateThrowExceptionWhenNameAlreadyExist()
    {
        $categoryDto = new CategoryDto();
        $categoryDto->companyId =  1;
        $categoryDto->name = self::TEST_STRING;
        $categoryDto->isActive = true;

        $sameNameCategory = $this->getMockBuilder(Category::class)
            ->disableOriginalConstructor()
            ->getMock();

        $sameNameCategory->setId(2);

        $this->mockRepository
            ->expects($this->once())
            ->method('findByName')
            ->willReturn($sameNameCategory);

        $this->expectException("Exception");
        $this->categoryService->update(1, $categoryDto);
    }

    public function testUpdateSuccessWhenDtoIsValid()
    {
        $categoryDto = new CategoryDto();
        $categoryDto->companyId =  1;
        $categoryDto->name = self::TEST_STRING;
        $categoryDto->isActive = true;

        $categoryMock = $this->getMockBuilder(Category::class)
            ->disableOriginalConstructor()
            ->getMock();

        $categoryMock->setId(1);

        $this->mockRepository
            ->expects($this->once())
            ->method('findByName')
            ->willReturn(null);

        $this->mockRepository
            ->expects($this->once())
            ->method('find')
            ->willReturn($categoryMock);

        $this->categoryService->update(1, $categoryDto);
    }

    public function testDeleteThrowExceptionWhenEntityNull()
    {
        $this->mockRepository
            ->expects($this->once())
            ->method('find')
            ->willReturn(null);

        $this->expectException("Exception");
        $this->categoryService->delete(1);
    }

    public function testDeleteSuccess()
    {
        $categoryMock = $this->getMockBuilder(Category::class)
            ->disableOriginalConstructor()
            ->getMock();

        $categoryMock->setId(1);

        $this->mockRepository
            ->expects($this->once())
            ->method('find')
            ->willReturn($categoryMock);

        $this->mockEm->expects($this->exactly(1))
            ->method('remove');

        $this->mockEm->expects($this->exactly(1))
            ->method('flush');

        $this->categoryService->delete(1);
    }
}
