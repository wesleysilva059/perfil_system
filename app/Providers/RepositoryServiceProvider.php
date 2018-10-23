<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\App\Repositories\ClientRepository::class, \App\Repositories\ClientRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\IncomeRepository::class, \App\Repositories\IncomeRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\CostRepository::class, \App\Repositories\CostRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ProductRepository::class, \App\Repositories\ProductRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\IncomeLauncheRepository::class, \App\Repositories\IncomeLauncheRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\CostLauncheRepository::class, \App\Repositories\CostLauncheRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\SaleRepository::class, \App\Repositories\SaleRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\EmployeeRepository::class, \App\Repositories\EmployeeRepositoryEloquent::class);
        //:end-bindings:
    }
}
