<?php

namespace App\Http\Middleware;

use App\Domain\Auth\Repositories\UserRepository;
use App\Domain\Company\Repositories\CompanyRepository;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckCompany
{
    /**
     * @var UserRepository $userRepository
     */
    protected $userRepository;

    protected $companyRepository;

    public function __construct(UserRepository $userRepository, CompanyRepository $companyRepository)
    {
        $this->userRepository = $userRepository;
        $this->companyRepository = $companyRepository;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $userId = Auth::user()->getAuthIdentifier();
        $user = $this->userRepository->find($userId);
        $company = $this->companyRepository->getByUser($user);
        $request->merge(['companyId' => $company->getId()]);

        return $next($request);
    }
}
