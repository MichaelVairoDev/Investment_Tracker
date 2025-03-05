<?php

namespace App\Providers;

use App\Models\Portfolio;
use App\Policies\PortfolioPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Portfolio::class => PortfolioPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
