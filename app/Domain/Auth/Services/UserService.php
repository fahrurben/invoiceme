<?php
/**
 * Created by PhpStorm.
 * User: fahrur
 * Date: 14/11/20
 * Time: 10:27
 */

namespace App\Domain\Auth\Services;

use App\Domain\Auth\Models\RegisterUserDto;
use App\Domain\Auth\Models\User;
use App\Domain\Auth\Repositories\UserRepository;
use App\Domain\Company\Models\Company;
use App\Domain\ValidationException;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Support\Facades\Hash;

class UserService implements UserServiceInterface
{
    /**
     * @var EntityManagerInterface $entityManager
     */
    private $entityManager;

    /**
     * @var \Doctrine\Persistence\ObjectRepository $repository
     */
    private $repository;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserRepository $userRepository
    )
    {
        $this->entityManager = $entityManager;
        $this->repository = $userRepository;
    }

    public function register(RegisterUserDto $registerUserDto)
    {
        $validator = $registerUserDto->getCreateValidator();
        $validator->validate();

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            throw new ValidationException($errors, json_encode($errors));
        }

        $sameEmailUsers = $this->repository->findBy(['email' => $registerUserDto->email]);
        if (!empty($sameEmailUsers)) {
            throw new \Exception('Email already registered');
        }

        $newUser = new User();
        $newUser->setName($registerUserDto->name);
        $newUser->setEmail($registerUserDto->email);
        $newUser->setPassword(Hash::make($registerUserDto->password));
        $this->entityManager->persist($newUser);

        $company = new Company();
        $company->setName($registerUserDto->companyName);
        $company->setEmail($registerUserDto->companyEmail);
        $company->setAddress($registerUserDto->address);
        $company->setCity($registerUserDto->city);
        $company->setPhone($registerUserDto->phone);
        $company->setUser($newUser);
        $this->entityManager->persist($company);
        $this->entityManager->flush();
    }
}