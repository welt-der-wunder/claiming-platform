<?php

namespace App\Providers;

use App\Models\Investment\InvestmentRequest;
use App\Models\Transaction\Transaction;
use App\Models\User;
use App\Models\User\UserBalance;
use App\Policies\InvestmentPolicy;
use App\Policies\TransactionPolicy;
use App\Policies\UserBalancePolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
        InvestmentRequest::class => InvestmentPolicy::class,
        Transaction::class => TransactionPolicy::class,
        UserBalance::class => UserBalancePolicy::class,
    ];

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
