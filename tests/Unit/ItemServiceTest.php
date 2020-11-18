<?php

namespace Tests\Unit;

use App\Domain\Item\Models\Category;
use App\Domain\Item\Models\Item;
use App\Domain\Item\Models\ItemDto;
use App\Domain\Item\Repositories\ItemRepository;
use App\Domain\Item\Services\ItemService;
use PHPUnit\Framework\TestCase;
use App\Domain\Item\Repositories\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;

class ItemServiceTest extends TestCase
{
    const TEST_STRING = 'test';
    const TEST_EMAIL = 'test@test.com';

    private $mockEm;

    private $mockRepository;

    /**
     * @var CategoryRepository $categoryRepository
     */
    private $mockCategoryRepository;

    /**
     * @var ItemService $categoryService
     */
    private $itemService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mockEm = $this->getMockBuilder(EntityManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mockRepository = $this->getMockBuilder(ItemRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mockCategoryRepository = $this->getMockBuilder(CategoryRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->itemService = new ItemService($this->mockEm, $this->mockRepository, $this->mockCategoryRepository);
    }

    /**
     * @return void
     */
    public function testCreateThrowExceptionWhenDtoIsNotValid()
    {
        $itemDto = new ItemDto();

        $this->expectException("Exception");
        $this->itemService->create($itemDto);
    }

    public function testCreateThrowExceptionWhenNameAlreadyExist()
    {
        $itemDto = new ItemDto();
        $itemDto->companyId =  1;
        $itemDto->name = self::TEST_STRING;
        $itemDto->type = 1;
        $itemDto->categoryId = 1;
        $itemDto->isActive = true;

        $itemMock = $this->getMockBuilder(Item::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mockRepository
            ->expects($this->once())
            ->method('findByName')
            ->willReturn($itemMock);

        $this->expectException("Exception");
        $this->itemService->create($itemDto);
    }

    public function testCreateThrowExceptionWhenCategoryNotExist()
    {
        $itemDto = new ItemDto();
        $itemDto->companyId =  1;
        $itemDto->name = self::TEST_STRING;
        $itemDto->type = 1;
        $itemDto->categoryId = 1;
        $itemDto->isActive = true;

        $this->mockRepository
            ->expects($this->once())
            ->method('findByName')
            ->willReturn(null);

        $this->mockCategoryRepository
            ->expects($this->once())
            ->method('find')
            ->willReturn(null);

        $this->expectException("Exception");
        $this->itemService->create($itemDto);
    }

    public function testCreateSuccessWhenDtoIsValid()
    {
        $itemDto = new ItemDto();
        $itemDto->companyId =  1;
        $itemDto->name = self::TEST_STRING;
        $itemDto->type = 1;
        $itemDto->categoryId = 1;
        $itemDto->isActive = true;

        $categoryMock = $this->getMockBuilder(Category::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mockRepository
            ->expects($this->once())
            ->method('findByName')
            ->willReturn(null);

        $this->mockCategoryRepository
            ->expects($this->once())
            ->method('find')
            ->willReturn($categoryMock);

        $this->itemService->create($itemDto);
    }

    public function testUpdateThrowExceptionWhenDtoIsNotValid()
    {
        $itemDto = new ItemDto();

        $this->expectException("Exception");
        $this->itemService->create($itemDto);
    }

    public function testUpdateThrowExceptionWhenNameAlreadyExist()
    {
        $itemDto = new ItemDto();
        $itemDto->companyId =  1;
        $itemDto->name = self::TEST_STRING;
        $itemDto->type = 1;
        $itemDto->categoryId = 1;
        $itemDto->isActive = true;

        $itemMock = $this->getMockBuilder(Item::class)
            ->disableOriginalConstructor()
            ->getMock();

        $itemMock->setId(2);

        $this->mockRepository
            ->expects($this->once())
            ->method('findByName')
            ->willReturn($itemMock);

        $this->expectException("Exception");
        $this->itemService->update(1, $itemDto);
    }

    public function testUpdateThrowExceptionWhenEntityNull()
    {
        $itemDto = new ItemDto();
        $itemDto->companyId =  1;
        $itemDto->name = self::TEST_STRING;
        $itemDto->type = 1;
        $itemDto->categoryId = 1;
        $itemDto->isActive = true;

        $categoryMock = $this->getMockBuilder(Category::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mockCategoryRepository
            ->expects($this->once())
            ->method('find')
            ->willReturn($categoryMock);

        $this->mockRepository
            ->expects($this->once())
            ->method('findByName')
            ->willReturn(null);

        $this->mockRepository
            ->expects($this->once())
            ->method('find')
            ->willReturn(null);

        $this->expectException("Exception");
        $this->itemService->update(1, $itemDto);
    }

    public function testUpdateSuccessWhenDtoIsValid()
    {
        $itemDto = new ItemDto();
        $itemDto->companyId =  1;
        $itemDto->name = self::TEST_STRING;
        $itemDto->type = 1;
        $itemDto->categoryId = 1;
        $itemDto->isActive = true;

        $existingItem = $this->getMockBuilder(Item::class)
            ->disableOriginalConstructor()
            ->getMock();

        $categoryMock = $this->getMockBuilder(Category::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mockRepository
            ->expects($this->once())
            ->method('findByName')
            ->willReturn(null);

        $this->mockRepository
            ->expects($this->once())
            ->method('find')
            ->willReturn($existingItem);

        $this->mockCategoryRepository
            ->expects($this->once())
            ->method('find')
            ->willReturn($categoryMock);

        $this->itemService->update(1, $itemDto);
    }

    public function testDeleteThrownExceptionWhenItemIsNull()
    {
        $this->mockRepository
            ->expects($this->once())
            ->method('find')
            ->willReturn(null);

        $this->expectException("Exception");
        $this->itemService->delete(1);
    }

    public function testDeleteSuccess()
    {
        $existingItem = $this->getMockBuilder(Item::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mockRepository
            ->expects($this->once())
            ->method('find')
            ->willReturn($existingItem);

        $this->itemService->delete(1);
    }
}
