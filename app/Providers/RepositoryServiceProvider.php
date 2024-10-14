<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Customer\Repositories\Interfaces\CustomerRepositoryInterface;
use App\Models\Customer\Repositories\CustomerRepository;


class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            CustomerRepositoryInterface::class,
            CustomerRepository::class
        );
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
