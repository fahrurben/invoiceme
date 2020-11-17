<?php

namespace Tests\Feature;

use App\Domain\Auth\Models\RegisterUserDto;
use App\Domain\Auth\Models\User;
use App\Domain\Auth\Repositories\UserRepository;
use App\Domain\Auth\Services\UserService;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\App;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    const TEST_STRING = 'test';
    const TEST_EMAIL = 'test@test.com';

    /**
     * @var EntityManagerInterface $em
     */
    private $em;

    /**
     * @var UserRepository $repository
     */
    private $repository;

    /**
     * @var UserService $service
     */
    private $service;

    protected function setUp():void
    {
        parent::setUp();
        $this->em = App::make('Doctrine\ORM\EntityManagerInterface');
        $this->repository = $this->em->getRepository(User::class);
        $this->service = new UserService($this->em, $this->repository);
    }

    /**
     * @return void
     */
    public function testRegisterUser()
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

        $this->service->register($registerDto);

        $user = $this->repository->findOneBy(['email' => self::TEST_EMAIL]);

        $this->assertNotNull($user);
    }
}
