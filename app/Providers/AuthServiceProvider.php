<?php

namespace App\Providers;

use App\Models\Banner;
use App\Models\Menu;
use App\Models\User;
use App\Policies\BannerPolicy;
use App\Policies\MenuPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Menu::class => MenuPolicy::class,
        Banner::class => BannerPolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        //
    }
}
