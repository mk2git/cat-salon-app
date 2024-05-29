<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    // boot()内で定義をしたら、composer dump-autoloadで内容を適用させる
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('admin', function (User $user) {
            if ($user->role === 'admin') {
                return true;
            } else {
                return false;
            }
        });

    }
}