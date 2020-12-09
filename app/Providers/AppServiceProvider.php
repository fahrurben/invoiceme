<?php

namespace App\Providers;

use App\Domain\Auth\Models\User;
use App\Domain\Company\Models\Company;
use App\Domain\Invoice\Models\Invoice;
use App\Domain\Invoice\Models\Line;
use App\Domain\Item\Models\Category;
use App\Domain\Item\Models\Item;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('App\Domain\Item\Repositories\CategoryRepository', function (
            $app
        ) {
            $entityManager = $app->make('Doctrine\ORM\EntityManagerInterface');
            return $entityManager->getRepository(Category::class);
        });

        $this->app->singleton('App\Domain\Auth\Repositories\UserRepository', function (
            $app
        ) {
            $entityManager = $app->make('Doctrine\ORM\EntityManagerInterface');
            return $entityManager->getRepository(User::class);
        });

        $this->app->singleton('App\Domain\Company\Repositories\CompanyRepository', function (
            $app
        ) {
            $entityManager = $app->make('Doctrine\ORM\EntityManagerInterface');
            return $entityManager->getRepository(Company::class);
        });

        $this->app->singleton('App\Domain\Item\Repositories\ItemRepository', function (
            $app
        ) {
            $entityManager = $app->make('Doctrine\ORM\EntityManagerInterface');
            return $entityManager->getRepository(Item::class);
        });

        $this->app->singleton('App\Domain\Invoice\Repositories\InvoiceRepository', function (
            $app
        ) {
            $entityManager = $app->make('Doctrine\ORM\EntityManagerInterface');
            return $entityManager->getRepository(Invoice::class);
        });

        $this->app->singleton('App\Domain\Invoice\Repositories\LineRepository', function (
            $app
        ) {
            $entityManager = $app->make('Doctrine\ORM\EntityManagerInterface');
            return $entityManager->getRepository(Line::class);
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
