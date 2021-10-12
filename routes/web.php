<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
    Route::get('userlogin', 'Auth\LoginController@userlogin' );
    Route::get('lang/{lang}', ['uses' => 'LanguageController@store', 'as' => 'lang.switch']);

    Route::group(['middleware' => 'siteLocale'], function() {
        Route::get('/', ['uses' => 'SiteController@index', 'as' => 'home']);
        Route::get('/allestimenti-and-garanzia', ['uses' => 'SiteController@allestimenti', 'as' => 'allestimenti']);
        Route::get('/filters/{filterId}', ['uses' => 'SiteController@index', 'as' => 'filters']);
        Route::get('/filters/{filterId}/search', ['uses' => 'SiteController@search', 'as' => 'search']);
        Route::get('do-option/offer/{offerId}/option/{optionId}', ['uses' => 'SiteController@doOption', 'as' => 'do-option']);
        Route::post('do-option/offer/{offerId}/option/{optionId}', ['uses' => 'SiteController@doOptionPost', 'as' => 'do-option-post']);
        Route::get('product', ['uses' => 'SiteController@product', 'as' => 'product']);
        Route::get('product-detail/{id_offert}', ['uses' => 'SiteController@productdetail', 'as' => 'product-detail']);
        Route::get('product-bun-detail/{id_offert}', ['uses' => 'SiteController@productbundetail', 'as' => 'product-bun-detail']);
        Route::post('storemessage', ['uses' => 'SiteController@storemessage', 'as' => 'storemessage']);
        Route::post('valuemy', ['uses' => 'Admin\VtuController@valuemy', 'as' => 'valuemy']);
        Route::get('valuemy', ['uses' => 'Admin\VtuController@valuemy', 'as' => 'valuemy']);
        Route::post('storevtu', ['uses' => 'Admin\VtuController@storevtu', 'as' => 'storevtu']);
        Route::get('allbundles', ['uses' => 'SiteController@allbundles', 'as' => 'allbundles']);
        Route::get('mycatalog', ['uses' => 'SiteController@mycatalog', 'as' => 'mycatalog']);
        Route::get('addtomycatalog', ['uses' => 'Admin\MymachineController@addtomycatalog', 'as' => 'addtomycatalog']);
        Route::get('deletemycatalog', ['uses' => 'Admin\MymachineController@deletemycatalog', 'as' => 'deletemycatalog']);
        Route::get('formquotation', ['uses' => 'Admin\QuotationController@formquotation', 'as' => 'formquotation']);
        Route::get('formquotationven', ['uses' => 'Admin\QuotationController@formquotationven', 'as' => 'formquotationven']);
        Route::post('addtoquotation', ['uses' => 'Admin\QuotationController@addtoquotation', 'as' => 'addtoquotation']);
        Route::post('addtoquotationven', ['uses' => 'Admin\QuotationvenController@addtoquotationven', 'as' => 'addtoquotationven']);
        Route::get('myquotations', ['uses' => 'Admin\QuotationController@myquotations', 'as' => 'myquotations']);
        Route::get('registrazione', 'SiteController@register');
        Route::get('contatti',  ['uses' => 'SiteController@contatti', 'as' => 'contatti']);
        Route::get('richiesta', ['uses' => 'SiteController@richiesta', 'as' => 'richiesta']);
        Route::get('myquotationsven', ['uses' => 'Admin\QuotationvenController@myquotationsven', 'as' => 'myquotationsven']);
        Route::get('richiedi-info/{offerId}', ['uses' =>'SiteController@richiediInfo', 'as' => 'richiedi-info']);
        Route::post('storemoreinfo', ['uses' =>'Admin\MoreinfoController@storemoreinfo', 'as' => 'storemoreinfo']);
        Route::get('myoptions', ['uses' => 'Admin\OptionController@myoptions', 'as' => 'myoptions']);
        Route::get('deleteoptions', ['uses' => 'Admin\OptionController@deleteoptions', 'as' => 'deleteoptions']);
        Route::post('api/products', ['uses' => 'SiteController@productsSearch', 'as' => 'products-search']);
        Route::get('api/options', ['uses' => 'SiteController@options', 'as' => 'options']);
        Route::post('api/options', ['uses' => 'SiteController@addOption', 'as' => 'options']);
        Route::get('/export-offer/{offerId}', ['uses' => 'SiteController@exportOfferPdf', 'as' => 'export-offer-pdf']);
        Route::get('/export-offer-bun/{offerId}', ['uses' => 'SiteController@exportOfferBundlePdf', 'as' => 'export-offer-bun-pdf']);
        Route::get('/export-catalog/', ['uses' => 'SiteController@exportCatalog', 'as' => 'export-catalog-pdf']);
        Route::get('/save-filters/', ['uses' => 'SiteController@saveFilters', 'as' => 'save-filters']);
        Route::get('myfilters', ['uses' => 'SiteController@myfilters', 'as' => 'myfilters']);
        Route::get('checkquotation', ['uses' => 'SiteController@checkquotation', 'as' => 'checkquotation']);
        Route::get('changelist', ['uses' => 'SiteController@changelist', 'as' => 'changelist']);
        Route::get('searchclient', ['uses' => 'SiteController@searchclient', 'as' => 'searchclient']);

    });

Route::group(['middleware' => ['auth', 'AccountActivated', 'locale', 'UserLastActivityUpdater'], 'namespace' => 'Admin','prefix' => 'admin', 'as' => 'admin.',], function () {

    Route::group(['prefix' => 'place', 'as' => 'place.'], function() {
        Route::get('getrole', ['uses' => 'PlaceController@getrole', 'as' => 'getrole']);
    });

    Route::get('runimport', ['uses' => 'ProductController@importadhoc', 'as' => 'importadhoc']);
    Route::get('generatexml', ['uses' => 'OffertController@generatexml', 'as' => 'generatexml']);

    Route::get('dash', ['uses' => 'HomeController@index', 'as' => 'home']);
    Route::get('newsl', ['uses' => 'HomeController@newsl', 'as' => 'newsl']);
    Route::get('setupsmtp', ['uses' => 'HomeController@setupsmtp', 'as' => 'setupsmtp']);
    Route::post('storesmtp', ['uses' => 'HomeController@storesmtp', 'as' => 'storesmtp']);
    Route::get('statistics', ['uses' => 'HomeController@statistics', 'as' => 'statistics']);
    Route::get('/', ['uses' => 'ProductController@index', 'as' => 'index']);
    Route::resource('users', 'UserController');
    Route::resource('roles', 'RoleController');
    Route::resource('faq-categories', 'FaqCategoryController');
    Route::resource('faq-questions', 'FaqQuestionController');

    Route::group(['prefix' => 'extapi', 'as' => 'extapi.'], function() {
//        Route::get('storenew', ['uses' => 'MacuController@storenew', 'as' => 'storenew']);
//        Route::get('storenew', ['uses' => 'SuprliftController@storenew', 'as' => 'storenew']);
//        Route::get('storenew', ['uses' => 'TuttocarrelliController@storenew', 'as' => 'storenew']);
    });


    /* crud:create add resource route */
    Route::resource('vendorbadges', 'VendorbadgeController');
    Route::resource('tuttocarrellis', 'TuttocarrelliController');
    Route::resource('suprlifts', 'SuprliftController');
    Route::resource('macus', 'MacuController');
    Route::resource('places', 'PlaceController');
    Route::resource('vendorplaces', 'VendorplaceController');
    Route::resource('components', 'ComponentController');
    Route::resource('galrtcs', 'GalrtcController');
    Route::resource('quotationvens_lines', 'Quotationvens_lineController');
    Route::resource('quotationvens', 'QuotationvenController');
    Route::resource('savedfilters_lines', 'Savedfilters_lineController');
    Route::resource('savedfilters', 'SavedfilterController');
    Route::resource('options', 'OptionController');
    Route::resource('moreinfos', 'MoreinfoController');
    Route::resource('quotation_lines', 'Quotation_lineController');
    Route::resource('quotations', 'QuotationController');
    Route::resource('mymachines', 'MymachineController');
    Route::resource('vtus', 'VtuController');
    Route::resource('caracts', 'CaractController');
    Route::resource('questions_filters_traductions', 'Questions_filters_traductionController');
    Route::resource('questions_filters', 'Questions_filterController');
    Route::resource('fam_selects', 'Fam_selectController');
    Route::resource('buttons_filters', 'Buttons_filterController');
    Route::resource('cmss', 'CmsController');
    Route::resource('contactforms', 'ContactformController');
    Route::resource('gallerys', 'GalleryController');
    Route::resource('products_lines', 'Products_lineController');
    Route::resource('questions_saps', 'Questions_sapController');
    Route::resource('productlines', 'ProductlineController');
    Route::resource('saps', 'SapController');
    Route::resource('offerts', 'OffertController');
    Route::resource('products', 'ProductController');

    Route::post('addproduct', ['uses' => 'OffertController@addproduct', 'as' => 'addproduct']);
    Route::get('getoffertsrelations', ['uses' => 'OffertController@getoffertsrelations', 'as' => 'getoffertsrelations']);
    Route::get('vtus/show/{id}', ['uses' => 'VtuController@show', 'as' => 'show']);

    Route::group(['prefix' => 'musers', 'as' => 'musers.'], function() {
        Route::get('amministratori/{type}', ['uses' => 'UserController@list', 'as' => 'amministratori']);
        Route::get('amministratorib/{type}', ['uses' => 'UserController@list', 'as' => 'amministratorib']);
        Route::get('venditori/{type}', ['uses' => 'UserController@list', 'as' => 'venditori']);
        Route::get('commercianti/{type}', ['uses' => 'UserController@list', 'as' => 'commercianti']);
        Route::get('clientif/{type}', ['uses' => 'UserController@list', 'as' => 'clientif']);
        Route::get('venditoriav/{type}', ['uses' => 'UserController@list', 'as' => 'venditoriav']);
        Route::post('datatabledetail/{type}', ['uses' => 'UserController@datatabledetail', 'as' => 'datatabledetail']);

    });

    Route::group(['prefix' => 'product', 'as' => 'product.'], function() {

        Route::get('importproduct', ['uses' => 'ProductController@importproduct', 'as' => 'importproduct']);
        Route::post('editdata/{id}/{lang}', ['uses' => 'ProductController@editdata', 'as' => 'editdataproduct']);
        Route::get('datatableoff/{id_offert}', ['uses' => 'ProductController@datatableoff', 'as' => 'datatableoff']);

    });

    Route::group(['prefix' => 'offert', 'as' => 'offert.'], function() {

        Route::post('uploadimage/{id}', ['uses' => 'OffertController@uploadimage', 'as' => 'uploadimage']);
        Route::post('addtooffert/{id_offert}', ['uses' => 'OffertController@addtooffert', 'as' => 'addtooffert']);
        Route::get('addtooffert/{id_offert}', ['uses' => 'OffertController@addtooffert', 'as' => 'addtooffert']);
        Route::get('changestatus/{id_offert}', ['uses' => 'OffertController@changestatus', 'as' => 'changestatus']);
        Route::get('setordersgal/{offertid}/{target}', ['uses' => 'OffertController@setordersgal', 'as' => 'setordersgal']);
        Route::get('setordersgalleries/{offertid}/{target}', ['uses' => 'OffertController@setordersgalleries', 'as' => 'setordersgalleries']);
        Route::get('storenewapioffert', ['uses' => 'OffertController@storenewapioffert', 'as' => 'storenewapioffert']);
        Route::get('deleteoffert', ['uses' => 'OffertController@deleteoffert', 'as' => 'deleteoffert']);
        Route::get('sendoption', ['uses' => 'OffertController@sendoption', 'as' => 'sendoption']);
    });

    Route::group(['prefix' => 'messenger', 'as' => 'messenger.'], function() {
        Route::get('/', ['uses' => 'MessengerController@inbox', 'as' => 'index']);
        Route::post('/', ['uses' => 'MessengerController@store', 'as' => 'store']);
        Route::get('create', ['uses' => 'MessengerController@create', 'as' => 'create']);
        Route::get('inbox', ['uses' => 'MessengerController@inbox', 'as' => 'inbox']);
        Route::get('outbox', ['uses' => 'MessengerController@outbox', 'as' => 'outbox']);
        Route::post('{topic}/read', ['uses' => 'MessengerController@read', 'as' => 'read']);
        Route::get('{topic}', ['uses' => 'MessengerController@show', 'as' => 'show']);
        Route::put('{topic}', ['uses' => 'MessengerController@update', 'as' => 'update']);
    });

    Route::resource('notifications', 'NotificationController');

    Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
        Route::get('/', ['uses' => 'ProfileController@edit', 'as' => 'edit']);
        Route::put('/', ['uses' => 'ProfileController@update', 'as' => 'update']);
        Route::get('locale', ['uses' => 'ProfileController@setLocale', 'as' => 'locale']);
        Route::post('avatar/{user?}', ['uses' => 'ProfileController@postAvatar', 'as' => 'avatar']);
    });

    Route::get('calendar', ['uses' => 'CalendarController@index', 'as' => 'calendar']);
    Route::get('event', ['uses' => 'EventController@index', 'as' => 'event.index']);
    Route::post('event', ['uses' => 'EventController@store', 'as' => 'event.store']);
    Route::post('event/{event}', ['uses' => 'EventController@update', 'as' => 'event.update']);
    Route::delete('event/{event}', ['uses' => 'EventController@destroy', 'as' => 'event.destroy']);
    Route::post('event/{event}/read', ['uses' => 'EventController@read', 'as' => 'event.read']);

    Route::get('profile/locale', ['uses' => 'ProfileController@setLocale', 'as' => 'profile.locale']);
    Route::get('changelog', ['uses' => 'ChangelogController@index', 'as' => 'changelog.index']);
    Route::get('translations', ['uses' => 'TranslationController@index', 'as' => 'translations.index']);
    Route::post('translations/scan', ['uses' => 'TranslationController@postScanForStrings', 'as' => 'translations.scan']);
    Route::post('translations/export', ['uses' => 'TranslationController@postExportStrings', 'as' => 'translations.export']);
    Route::post('translations/import', ['uses' => 'TranslationController@postImportStrings', 'as' => 'translations.import']);

    Route::get('reports', ['uses' => 'ReportController@index', 'as' => 'reports.index']);
    Route::delete('reports/{report}', ['uses' => 'ReportController@destroy', 'as' => 'reports.destroy']);

    Route::get('revisions', ['uses' => 'RevisionController@index', 'as' => 'revisions.index']);

    Route::group(['prefix' => 'permissions', 'as' => 'permissions.'], function () {
        Route::get('/', ['uses' => 'PermissionController@index', 'as' => 'index']);
    });

    Route::delete('ajax/media/{media}', ['uses' => 'MediaController@destroy', 'as' => 'ajax.media.destroy']);
    Route::post('ajax/media/{media}', ['uses' => 'MediaController@download', 'as' => 'ajax.media.download']);

    Route::group(['prefix' => 'ajax', 'middleware' => ['ajax'], 'as' => 'ajax.'], function () {
        Route::post('translations/update-strings', ['uses' => 'TranslationController@postUpdateStrings', 'as' => 'translations.update-string']);

        Route::get('users', ['uses' => 'UserController@ajaxSearch', 'as' => 'users']);
        Route::post('users/give-permission/{user}', ['uses' => 'UserController@ajaxGivePermission', 'as' => 'users.give-permission']);
        Route::post('users/revoke-permission/{user}', ['uses' => 'UserController@ajaxRevokePermission', 'as' => 'users.revoke-permission']);

        Route::post('profile/dashboard-order', ['uses' => 'ProfileController@postDashboardOrder', 'as' => 'profile.dashboard-order']);

        Route::get('messenger/unread-topics', ['uses' => 'MessengerController@ajaxGetUnreadTopics', 'as' => 'messenger.unread-topics']);
        Route::get('notifications/unread-notifications', ['uses' => 'NotificationController@ajaxGetUnreadNotifications', 'as' => 'notifications.unread-notifications']);
        Route::get('notifications/latest-notification', ['uses' => 'NotificationController@ajaxGetLatestNotifications', 'as' => 'notifications.latest-notifications']);

        Route::post('notifications/{notification}/read', ['uses' => 'NotificationController@ajaxRead', 'as' => 'notifications.read']);


        Route::post('roles/give-permission/{role}', ['uses' => 'RoleController@ajaxGivePermission', 'as' => 'roles.give-permission']);
        Route::post('roles/revoke-permission/{role}', ['uses' => 'RoleController@ajaxRevokePermission', 'as' => 'roles.revoke-permission']);

        Route::get('permissions/table-view', ['uses' => 'PermissionController@ajaxGetTableView', 'as' => 'permissions.index']);

        Route::get('discussions/get-comments', ['uses' => 'DiscussionController@ajaxGetComments', 'as' => 'discussions.get-comments']);
        Route::post('discussions/save-comment', ['uses' => 'DiscussionController@ajaxSaveComment', 'as' => 'discussions.save-comment']);
    });

    Route::group(['prefix' => 'datatables', 'middleware' => ['ajax'], 'as' => 'datatables.'], function () {
        Route::post('users', ['uses' => 'UserController@datatable', 'as' => 'users']);
        Route::post('roles', ['uses' => 'RoleController@datatable', 'as' => 'roles']);
        Route::post('faq-categories', ['uses' => 'FaqCategoryController@datatable', 'as' => 'faq-categories']);
        Route::post('faq-questions', ['uses' => 'FaqQuestionController@datatable', 'as' => 'faq-questions']);
        Route::post('notifications', ['uses' => 'NotificationController@datatable', 'as' => 'notifications']);
        Route::post('revisions', ['uses' => 'RevisionController@datatable', 'as' => 'revisions']);
        Route::post('reports', ['uses' => 'ReportController@datatable', 'as' => 'reports']);

        /* crud:create add datatable route */
        Route::post('vendorbadges', ['uses' => 'VendorbadgeController@datatable', 'as' => 'vendorbadges']);
        Route::post('tuttocarrellis', ['uses' => 'TuttocarrelliController@datatable', 'as' => 'tuttocarrellis']);
        Route::post('suprlifts', ['uses' => 'SuprliftController@datatable', 'as' => 'suprlifts']);
        Route::post('macus', ['uses' => 'MacuController@datatable', 'as' => 'macus']);
        Route::post('places', ['uses' => 'PlaceController@datatable', 'as' => 'places']);
        Route::post('vendorplaces', ['uses' => 'VendorplaceController@datatable', 'as' => 'vendorplaces']);
        Route::post('components', ['uses' => 'ComponentController@datatable', 'as' => 'components']);
        Route::post('galrtcs', ['uses' => 'GalrtcController@datatable', 'as' => 'galrtcs']);
        Route::post('quotationvens_lines', ['uses' => 'Quotationvens_lineController@datatable', 'as' => 'quotationvens_lines']);
        Route::post('quotationvens', ['uses' => 'QuotationvenController@datatable', 'as' => 'quotationvens']);
        Route::post('savedfilters_lines', ['uses' => 'Savedfilters_lineController@datatable', 'as' => 'savedfilters_lines']);
        Route::post('savedfilters', ['uses' => 'SavedfilterController@datatable', 'as' => 'savedfilters']);
        Route::post('options', ['uses' => 'OptionController@datatable', 'as' => 'options']);
        Route::post('moreinfos', ['uses' => 'MoreinfoController@datatable', 'as' => 'moreinfos']);
        Route::post('quotation_lines', ['uses' => 'Quotation_lineController@datatable', 'as' => 'quotation_lines']);
        Route::post('quotations', ['uses' => 'QuotationController@datatable', 'as' => 'quotations']);
        Route::post('mymachines', ['uses' => 'MymachineController@datatable', 'as' => 'mymachines']);
        Route::post('vtus', ['uses' => 'VtuController@datatable', 'as' => 'vtus']);
        Route::post('caracts', ['uses' => 'CaractController@datatable', 'as' => 'caracts']);
        Route::post('questions_filters_traductions', ['uses' => 'Questions_filters_traductionController@datatable', 'as' => 'questions_filters_traductions']);
        Route::post('questions_filters', ['uses' => 'Questions_filterController@datatable', 'as' => 'questions_filters']);
        Route::post('fam_selects', ['uses' => 'Fam_selectController@datatable', 'as' => 'fam_selects']);
        Route::post('buttons_filters', ['uses' => 'Buttons_filterController@datatable', 'as' => 'buttons_filters']);
        Route::post('cmss', ['uses' => 'CmsController@datatable', 'as' => 'cmss']);
        Route::post('contactforms', ['uses' => 'ContactformController@datatable', 'as' => 'contactforms']);
        Route::post('gallerys', ['uses' => 'GalleryController@datatable', 'as' => 'gallerys']);
        Route::post('products_lines', ['uses' => 'Products_lineController@datatable', 'as' => 'products_lines']);
        Route::post('questions_saps', ['uses' => 'Questions_sapController@datatable', 'as' => 'questions_saps']);
        Route::post('productlines', ['uses' => 'ProductlineController@datatable', 'as' => 'productlines']);
        Route::post('saps', ['uses' => 'SapController@datatable', 'as' => 'saps']);
        Route::post('offerts', ['uses' => 'OffertController@datatable', 'as' => 'offerts']);
        Route::post('products', ['uses' => 'ProductController@datatable', 'as' => 'products']);


        Route::post('save-user-view', ['uses' => 'DataTableController@saveUserView', 'as' => 'save-user-view']);
        Route::delete('delete-user-view', ['uses' => 'DataTableController@deleteUserView', 'as' => 'delete-user-view']);
        });
    });

Route::group(['middleware' => ['GuestLocale']], function () {
    Auth::routes(['register' => false, 'verify' => false]);
    Route::get('guest-locale/{locale}', ['uses' => 'GuestController@getGuestLocale', 'as' => 'guest-locale']);
});
Route::get('logout', 'Auth\LoginController@logout');

Route::group(['middleware' => ['guest', 'GuestLocale'], 'prefix' => 'account', 'namespace' => 'Auth', 'as' => 'account.'], function () {
    Route::get('request-activation-link', ['uses' => 'AccountActivationController@requestActivationLink', 'as' => 'request-activation-link']);
    Route::post('send-activation-link', ['uses' => 'AccountActivationController@sendActivationLink', 'as' => 'send-activation-link']);
    Route::get('activate', ['uses' => 'AccountActivationController@activationForm', 'as' => 'activate']);
    Route::post('activate', ['uses' => 'AccountActivationController@activate']);
});
