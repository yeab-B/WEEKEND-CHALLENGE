<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Policies\GenericPolicy;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Role::class => GenericPolicy::class,
        Permission::class => GenericPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Apply Generic Policy for all models dynamically
        Gate::before(function ($user, $ability, $arguments) {
            if (!isset($arguments[0])) {
                return false;
            }
            return app(GenericPolicy::class)->{$ability}($user, $arguments[0]);
        });
    }
}
