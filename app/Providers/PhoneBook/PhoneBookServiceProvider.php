<?php

namespace App\Providers\PhoneBook;

use App\Repositories\Interfaces\PhoneBook\Contact\ContactQueriesInterface;
use App\Repositories\Interfaces\PhoneBook\Number\NumberQueriesInterface;
use App\Repositories\PhoneBook\Contact\ContactQueries;
use App\Repositories\PhoneBook\Number\NumberQueries;
use App\Services\Interfaces\PhoneBook\Contact\ContactServiceInterface;
use App\Services\Interfaces\PhoneBook\Number\NumberServiceInterface;
use App\Services\PhoneBook\Contact\ContactServiceService;
use App\Services\PhoneBook\Number\NumberService;
use Illuminate\Support\ServiceProvider;

class PhoneBookServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(ContactServiceInterface::class, ContactServiceService::class);
        $this->app->bind(ContactQueriesInterface::class, ContactQueries::class);
        $this->app->bind(NumberServiceInterface::class, NumberService::class);
        $this->app->bind(NumberQueriesInterface::class, NumberQueries::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }
}
