<?php

namespace Tests\Unit;

use App\Domain\Auth\Models\RegisterUserDto;
use App\Domain\Auth\Models\User;
use App\Domain\Auth\Repositories\UserRepository;
use App\Domain\Auth\Services\UserService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class UserServiceTest extends TestCase
{
    const TEST_STRING = 'test';
    const TEST_EMAIL = 'test@test.com';

    private $mockEm;
    private $mockRepository;

    /**
     * @var UserService $userService
     */
    private $userService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mockEm = $this->getMockBuilder(EntityManagerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mockRepository = $this->getMockBuilder(UserRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->userService = new UserService($this->mockEm, $this->mockRepository);
    }

    /**
     * @return void
     */
    public function testThrowExceptionWhenDtoIsNotValid()
    {
        $registerDto = new RegisterUserDto();

        $this->expectException("Exception");
        $this->userService->register($registerDto);
    }

    public function testThrowExceptionWhenUserEmailAlreadyExist()
    {
        $registerDto = new RegisterUserDto();
        $registerDto->name = self::TEST_STRING;
        $registerDto->email = self::TEST_EMAIL;
        $registerDto->password = self::TEST_STRING;
        $registerDto->companyName = self::TEST_STRING;
        $registerDto->address = self::TEST_STRING;
        $registerDto->city = self::TEST_STRING;
        $registerDto->phone = self::TEST_STRING;
        $registerDto->companyEmail = self::TEST_EMAIL;

        $userMock = $this->getMockBuilder(User::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->mockRepository
            ->expects($this->once())
            ->method('findBy')
            ->willReturn($userMock);

        $this->expectException("Exception");
        $this->userService->register($registerDto);
    }
}
