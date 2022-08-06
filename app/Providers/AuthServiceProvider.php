<?php

namespace App\Providers;

use App\AdvanceReplacement;
use App\Billty;
use App\Branch;
use App\Challan;
use App\ChallanAccessories;
use App\ChallanProduct;
use App\CompanyMaster;
use App\Complain;
use App\CreditNote;
use App\DeliveryChallanOut;
use App\Destroy;
use App\Invoice;
use App\Policies\AdvanceReplacementPolicy;
use App\Policies\BilltyPolicy;
use App\Policies\BranchMasterPolicy;
use App\Policies\ChallanAccessoriesPolicy;
use App\Policies\ChallanPolicy;
use App\Policies\ChallanProductPolicy;
use App\Policies\CompanyMasterPolicy;
use App\Policies\ComplainPolicy;
use App\Policies\CreditNotePolicy;
use App\Policies\DeliveryChallanOutPolicy;
use App\Policies\DestroyPolicy;
use App\Policies\InvoicePolicy;
use App\Policies\ReplacementExpensePolicy;
use App\Policies\ServiceStationPolicy;
use App\Policies\UserPolicy;
use App\ReplacementExpense;
use App\ServiceStation;
use App\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class => UserPolicy::class,
        AdvanceReplacement::class => AdvanceReplacementPolicy::class,
        Billty::class => BilltyPolicy::class,
        ReplacementExpense::class => ReplacementExpensePolicy::class,
        Branch::class => BranchMasterPolicy::class,
        ChallanAccessories::class => ChallanAccessoriesPolicy::class,
        Challan::class => ChallanPolicy::class,
        ChallanProduct::class => ChallanProductPolicy::class,
        CompanyMaster::class => CompanyMasterPolicy::class,
        Complain::class => ComplainPolicy::class,
        CreditNote::class => CreditNotePolicy::class,
        DeliveryChallanOut::class => DeliveryChallanOutPolicy::class,
        Destroy::class => DestroyPolicy::class,
        Invoice::class => InvoicePolicy::class,
        ServiceStation::class => ServiceStationPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('billty-policy', function ($user, $post) {
            return in_array($user->role_id,[1,2]);
        });
        Gate::define('credit-note-policy', function ($user, $post) {
            return in_array($user->role_id,[1,2]);
        });
        Gate::define('service-expense-policy', function ($user, $post) {
            return in_array($user->role_id,[1,2]);
        });
        Gate::define('advance-replacement-policy', function ($user, $post) {
            return in_array($user->role_id,[1,2]);
        });
        Gate::define('delivery-challan-policy', function ($user, $post) {
            return in_array($user->role_id,[1,2]);
        });
    }

}
