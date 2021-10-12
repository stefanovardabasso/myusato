<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Admin\User' => 'App\Policies\Admin\UserPolicy',
        'App\Models\Admin\Role' => 'App\Policies\Admin\RolePolicy',
        'App\Models\Admin\FaqCategory' => 'App\Policies\Admin\FaqCategoryPolicy',
        'App\Models\Admin\FaqQuestion' => 'App\Policies\Admin\FaqQuestionPolicy',
        'App\Models\Admin\MessengerTopic' => 'App\Policies\Admin\MessengerTopicPolicy',
        'App\Models\Admin\Notification' => 'App\Policies\Admin\NotificationPolicy',
        'App\Models\Admin\Event' => 'App\Policies\Admin\EventPolicy',
        'App\Models\Admin\MessengerMessage' => 'App\Policies\Admin\MessengerMessagePolicy',
        'App\Models\Admin\Revision' => 'App\Policies\Admin\RevisionPolicy',
        'App\Models\Admin\Report' => 'App\Policies\Admin\ReportPolicy',
        'App\Models\Admin\Permission' => 'App\Policies\Admin\PermissionPolicy',
        /* crud:create add policy */
        'App\Models\Admin\Vendorbadge' => 'App\Policies\Admin\VendorbadgePolicy',
        'App\Models\Admin\Tuttocarrelli' => 'App\Policies\Admin\TuttocarrelliPolicy',
        'App\Models\Admin\Suprlift' => 'App\Policies\Admin\SuprliftPolicy',
        'App\Models\Admin\Macu' => 'App\Policies\Admin\MacuPolicy',
        'App\Models\Admin\Place' => 'App\Policies\Admin\PlacePolicy',
        'App\Models\Admin\Vendorplace' => 'App\Policies\Admin\VendorplacePolicy',
        'App\Models\Admin\Component' => 'App\Policies\Admin\ComponentPolicy',
        'App\Models\Admin\Galrtc' => 'App\Policies\Admin\GalrtcPolicy',
        'App\Models\Admin\Quotationvens_line' => 'App\Policies\Admin\Quotationvens_linePolicy',
        'App\Models\Admin\Quotationven' => 'App\Policies\Admin\QuotationvenPolicy',
        'App\Models\Admin\Savedfilters_line' => 'App\Policies\Admin\Savedfilters_linePolicy',
        'App\Models\Admin\Savedfilter' => 'App\Policies\Admin\SavedfilterPolicy',
        'App\Models\Admin\Option' => 'App\Policies\Admin\OptionPolicy',
        'App\Models\Admin\Moreinfo' => 'App\Policies\Admin\MoreinfoPolicy',
        'App\Models\Admin\Quotation_line' => 'App\Policies\Admin\Quotation_linePolicy',
        'App\Models\Admin\Quotation' => 'App\Policies\Admin\QuotationPolicy',
        'App\Models\Admin\Mymachine' => 'App\Policies\Admin\MymachinePolicy',
        'App\Models\Admin\Vtu' => 'App\Policies\Admin\VtuPolicy',
        'App\Models\Admin\Caract' => 'App\Policies\Admin\CaractPolicy',
        'App\Models\Admin\Questions_filters_traduction' => 'App\Policies\Admin\Questions_filters_traductionPolicy',
        'App\Models\Admin\Questions_filter' => 'App\Policies\Admin\Questions_filterPolicy',
        'App\Models\Admin\Fam_select' => 'App\Policies\Admin\Fam_selectPolicy',
        'App\Models\Admin\Buttons_filter' => 'App\Policies\Admin\Buttons_filterPolicy',
        'App\Models\Admin\Cms' => 'App\Policies\Admin\CmsPolicy',
        'App\Models\Admin\Contactform' => 'App\Policies\Admin\ContactformPolicy',
        'App\Models\Admin\Gallery' => 'App\Policies\Admin\GalleryPolicy',
        'App\Models\Admin\Products_line' => 'App\Policies\Admin\Products_linePolicy',
        'App\Models\Admin\Questions_sap' => 'App\Policies\Admin\Questions_sapPolicy',
        'App\Models\Admin\Productline' => 'App\Policies\Admin\ProductlinePolicy',
        'App\Models\Admin\Sap' => 'App\Policies\Admin\SapPolicy',
        'App\Models\Admin\Offert' => 'App\Policies\Admin\OffertPolicy',
        'App\Models\Admin\Product' => 'App\Policies\Admin\ProductPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
