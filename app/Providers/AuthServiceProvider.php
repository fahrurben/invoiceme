<?php

namespace App\Providers;

use App\Domain\Auth\Models\User;
use App\Domain\Company\Repositories\CompanyRepository;
use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $companyRepository = App::make(CompanyRepository::class);
        Gate::define('update-own', function (User $user, $entity) use ($companyRepository) {
            $company = $companyRepository->getByUser($user);

            return $company->getId() === $entity->getCompanyId()
                ? Response::allow()
                : Response::deny('You are not allowed to update this data');
        });

        Gate::define('view-own', function (User $user, $entity) use ($companyRepository) {
            $company = $companyRepository->getByUser($user);

            return $company->getId() === $entity->getCompanyId()
                ? Response::allow()
                : Response::deny('You are not allowed to view this data');
        });
    }
}
