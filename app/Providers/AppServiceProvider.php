<?php

namespace App\Providers;

use App\Models\Picture;
use App\Models\Rating;
use App\Policies\PicturePolicy;
use App\Policies\RatingPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Services\TriviaService;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Picture::class => PicturePolicy::class,
        Rating::class => RatingPolicy::class,
    ];

    public function register()
    {
        $this->app->singleton(TriviaService::class, function ($app) {
            return new TriviaService();
        });
    }

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
