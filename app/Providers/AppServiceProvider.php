<?php

namespace App\Providers;

use App\Libraries\Notifications;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
//        $this->app->bind( 'App\Libraries\NotificationsInterface', function ( $app ) {
//            return new Notifications();
//        } );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        Schema::defaultStringLength( 191 );
    }
}
