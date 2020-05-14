<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
	{

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if(app()->isLocal()){
            $this->app->register(\VIACreative\SudoSu\ServiceProvider::class);
        }

        // \API::error(function (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException  $excetion) {
        //     throw new  \Symfony\Component\HttpKernel\Exception\HttpException(404, '404 Not Found');
        // });

        \API::error(function (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            abort(404);
        });

        \API::error(function (\Illuminate\Auth\Access\AuthorizationException $exception ){
            abort(403,$exception->getMessage());
        });
    }
}