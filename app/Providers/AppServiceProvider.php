<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Services\DatabaseService;
use App\Services\CompanyService;
use App\Services\UnitService;
use App\Services\BankService;
use App\Services\ProductService;
use App\Services\ProductTypeService;
use App\Services\SupplierService;
use App\Services\PhoneProviderService;
use App\Services\TruckService;

use App\Services\Implementations\DatabaseServiceImpl;
use App\Services\Implementations\CompanyServiceImpl;
use App\Services\Implementations\UnitServiceImpl;
use App\Services\Implementations\BankServiceImpl;
use App\Services\Implementations\ProductServiceImpl;
use App\Services\Implementations\ProductTypeServiceImpl;
use App\Services\Implementations\SupplierServiceImpl;
use App\Services\Implementations\PhoneProviderServiceImpl;
use App\Services\Implementations\TruckServiceImpl;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(DatabaseService::class, function (){
            return new DatabaseServiceImpl();
        });

        $this->app->singleton(CompanyService::class, function (){
            return new CompanyServiceImpl();
        });

        $this->app->singleton(UnitService::class, function (){
            return new UnitServiceImpl();
        });

        $this->app->singleton(BankService::class, function (){
            return new BankServiceImpl();
        });

        $this->app->singleton(ProductService::class, function (){
            return new ProductServiceImpl();
        });

        $this->app->singleton(ProductTypeService::class, function (){
            return new ProductTypeServiceImpl();
        });

        $this->app->singleton(SupplierService::class, function (){
            return new SupplierServiceImpl();
        });

        $this->app->singleton(PhoneProviderService::class, function (){
            return new PhoneProviderServiceImpl();
        });

        $this->app->singleton(TruckService::class, function() {
            return new TruckServiceImpl();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'App\Services\DatabaseService',
            'App\Services\CompanyService',
            'App\Services\UnitService',
            'App\Services\BankService',
            'App\Services\ProductService',
            'App\Services\ProductTypeService',
            'App\Services\TruckService',
        ];
    }
}
