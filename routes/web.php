<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes list
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
    ], function () {
// AJAX URLS
    Route::get('getServiceShowDetails/{id}', 'FrontController@getServiceShowDetails');
    Route::get('getServiceDetails/{id}', 'FrontController@getservicedetails')->name('getServiceDetails');
    Route::get('getPackages/{serviceID}/{countryId}', 'FrontController@getPackages')->name('getPackages');
    Route::get('getPackageServiceId/{serviceID}', 'FrontController@getPackageServiceId')->name('getPackageServiceId');;
    Route::get('getCountryClasses/{countryID}', 'FrontController@getClassesCountry')->name('getClassesCountry');
    Route::get('getServiceDocuments/{id}', 'FrontController@getServiceDocuments');
    Route::get('getClassDescription/{id}', 'FrontController@getClassDescription');
    Route::get('getRequiredDocuments/{id}', 'FrontController@getRequiredDocuments');
    Route::get('getClasses/{countryId}/{orderId}', 'FrontController@getClasses');
    Route::get('getLowestPackageFees/{serviceId}/{countryId}', 'FrontController@getLowestPackageFees');

// Not Found page Route [404,500]
    Route::get('pageNotFound', 'FrontController@pageNotFound')->name('notFound');

// First question before going to any process (Validation)
    Route::get('/validate-trademark/{packageId}/{serviceIid}/{countryId}/{countryPackageFees}', 'FrontController@validateTrademark')->name('validateTrademark');
    Route::post('/validate-trademark', 'FrontController@goToProcess')->name('goToProcess');
    Route::post('/redirect-service-process', 'FrontController@redirectServiceProcess')->name('redirectServiceProcess');

// Search Service
    Route::get('/search/{package_id}/{serviceId}/{countryId}/{countryPackages}', 'SearchServiceController@stepper')->name('searchProcess');
    Route::post('/checkout-search-service', 'SearchServiceController@store')->name('store-search-service');
    Route::get('/store-order-after-login', 'SearchServiceController@storeOrderAfterLogin')->name('store-order-after-login');

// Publication Service
    Route::get('/publication/{trademarkCountryId}/{countryId}/{trademarkId}', 'RegistrationServiceController@publicationForm')->name('publicationForm');
    Route::post('/store-publication', 'RegistrationServiceController@publicationStore')->name('publicationStore');

// final registration Service
    Route::get('/finalRegistration/{trademarkCountryId}/{countryId}/{trademarkId}', 'RegistrationServiceController@finalRegistrationForm')->name('finalRegistrationForm');
    Route::post('/store-finalRegistration', 'RegistrationServiceController@finalRegistrationStore')->name('finalRegistrationStore');

// Registration Service
    Route::get('/registration/{package_id}/{serviceId}/{countryId}/{countryPackages}', 'RegistrationServiceController@stepper')->name('registrationProcess');
    Route::post('/checkout-registration', 'RegistrationServiceController@store')->name('store_registration_service');
    Route::get('/store-registration-order-after-login', 'RegistrationServiceController@storeRegistrationOrderAfterLogin')->name('store-registration-order-after-login');

// Renewal Service
    Route::get('/renewal/{package_id}/{serviceId}/{countryId}/{countryPackages}', 'RenewalServiceController@stepper')->name('renewalProcess');
    Route::post('/checkout-renewal-service', 'RenewalServiceController@store')->name('store_renewal_service');
    Route::get('/store-renewal-order-after-login', 'RenewalServiceController@storeRenewalOrderAfterLogin')->name('store-renewal-order-after-login');

// Assignment Service
    Route::get('/assignment/{package_id}/{serviceId}/{countryId}/{countryPackages}', 'AssignmentServiceController@stepper')->name('assignmentProcess');
    Route::post('/checkout-assignment-service', 'AssignmentServiceController@store')->name('store_assignment_service');
    Route::get('/store-assignment-order-after-login', 'AssignmentServiceController@storeAssignmentOrderAfterLogin')->name('store-assignment-order-after-login');

// Name-Change Service
    Route::get('/name-change/{package_id}/{serviceId}/{countryId}/{countryPackages}', 'NameChangeServiceController@stepper')->name('nameChangeProcess');
    Route::post('/checkout-name-change', 'NameChangeServiceController@store')->name('store_nameChange_service');
    Route::get('/store-name-change-order-after-login', 'NameChangeServiceController@storeNameChangeOrderAfterLogin')->name('store-name-change-order-after-login');

// Address-Change Service
    Route::get('/address-change/{package_id}/{serviceId}/{countryId}/{countryPackages}', 'AddressChangeServiceController@stepper')->name('addressChangeProcess');
    Route::post('/checkout-address-change', 'AddressChangeServiceController@store')->name('store_addressChange_service');
    Route::get('/store-address-change-order-after-login', 'AddressChangeServiceController@storeAddressChangeOrderAfterLogin')->name('store-address-change-order-after-login');

// general route for static pages
Route::get('/', 'FrontController@home');
Route::get('/home', 'FrontController@home')->name('home');
Route::get('/contact-us', 'ContactUsController@contactUs')->name('contactUs');
Route::get('/about-us', 'AboutController@index')->name('about');
Route::post('/send-email', 'ContactUsController@store')->name('send-email');
Route::get('/resource-center ', 'RecourceCenterController@recourseCenter')->name('recourseCenter');
Route::get('/FAQs', 'RecourceCenterController@faq')->name('faq');
Route::get('/FAQ-Detail/{slug}', 'RecourceCenterController@faqDetails')->name('FAQ-Detail');
Route::get('/our-community', 'RecourceCenterController@community');
Route::get('/templates-and-forms', 'RecourceCenterController@templates');
Route::get('/templatesSearch', 'RecourceCenterController@templatesSearch')->name('templatesSearch');
Route::get('/news', 'RecourceCenterController@news')->name('news');
Route::get('/details/{new_slug}', 'RecourceCenterController@newsDetails')->name('newsDetails');
Route::get('/service', 'ServiceController@search')->name('services');
Route::get('/service-search/{serviceID}', 'ServiceController@searchId')->name('servicesId');
Route::get('/home-search', 'ServiceController@homeSearch')->name('home-search');
Route::get('/privacy', function () {
    return view('organization.privacy_policy');
});
Route::get('/terms-of-use', function () {
    return view('organization.termsOfUse');
});
Route::get('/terms-of-service', function () {
    return view('organization.termsOfService');
});

Route::get('/userguide', 'RecourceCenterController@userguide_list')->name('userguide');
Route::get('/userguidedetail/{ug_slug}', 'RecourceCenterController@userguide_Detail')->name('userguidedetail');
//RSS Feed Route
    Route::get('/feed/{id}', 'FeedController@display_all_feeds')->name('feed');
Route::get('/rsslist/{id}', 'RecourceCenterController@rss_feed_list')->name('rsslist');

    Auth::routes();

//Route::get('/', 'HomeController@index')->name('dashboard');

////////////////////////////////////////////////////////////////////////////////
////////////////////---Admin---////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////

    Route::prefix('adminpanel')->middleware(['admin'])->
    group(function () {


        Route::get('/dashboard', 'HomeController@index')->name('dashboard');



/////////////////services////////////////////////////////////////
        Route::get('/services', 'AdminController@show_all_services')->name('services');
        Route::get('/addserviceform', 'AdminController@add_service_form')->name('addserviceform');
        Route::post('/add_new_service', 'AdminController@add_new_service')->name('add_new_service');
        Route::get('/service_details/{id}', 'AdminController@service_details')->name('service_details');
        Route::post('/update_service', 'AdminController@update_service')->name('update_service');
        Route::get('/service_activation/{id}/{status}', 'AdminController@service_activation')->name('service_activation');

        Route::post('/add_how_detail', 'AdminController@add_how_detail')->name('add_how_detail');
        Route::post('/update_how_detail', 'AdminController@update_how_detail')->name('update_how_detail');
        Route::get('/delete_how_detail/{id}', 'AdminController@delete_how_detail')->name('delete_how_detail');
////////////////////////////////////////////////////////////////


///////////////Customer/////////////////////
        Route::get('/clients', 'AdminController@show_all_customers')->name('clients');


///////////////member/////////////////////

        Route::get('/members', 'AdminController@show_all_members')->name('members');
        Route::get('/addmemberform', 'AdminController@add_member_form')->name('addserviceform');
        Route::post('/add_new_member', 'AdminController@add_new_member')->name('add_new_member');
        Route::post('/update_member', 'AdminController@update_member')->name('update_member');


///////////////countries/////////////////
        Route::get('/countries', 'AdminController@add_country_form')->name('countries');
        Route::post('/add_new_country', 'AdminController@add_new_country')->name('add_new_country');
        Route::post('/update_country', 'AdminController@update_country')->name('update_country');
        Route::get('/country_activation/{id}/{status}', 'AdminController@country_activation')->name('country_activation');

///////////////classes/////////////////
        Route::get('classes', 'AdminController@show_all_classes')->name('classes');


///////////////packages///////////////////
        Route::get('packages', 'AdminController@show_all_package')->name('packages');
        Route::post('add_new_package', 'AdminController@add_new_package')->name('add_new_package');
        Route::post('/update_package', 'AdminController@update_package')->name('update_package');


///////////////countryfees/////////////////
        Route::get('/countryfees/{id}', 'AdminController@show_all_country_packages')->name('countryfees');
        Route::get('/country_packages_activation/{id}/{status}', 'AdminController@country_packages_activation')->name('country_packages_activation');
        Route::post('/update_govfees', 'AdminController@update_govfees')->name('update_govfees');


///////////////Country Required Documents/////////////////
        Route::get('countryreqdocs', 'AdminController@show_all_countryreqdocs')->name('countryreqdocs');
        Route::post('add_new_countryreqdocs', 'AdminController@add_new_countryreqdocs')->name('add_new_countryreqdocs');
        Route::post('update_countryreqdocs', 'AdminController@update_countryreqdocs')->name('update_countryreqdocs');

///////////////trademarkresponse/////////////////
        Route::get('trademarkresponse', 'AdminController@show_all_trademarkresponse')->name('trademarkresponse');
        Route::post('update_tmresponsemsg', 'AdminController@update_tmresponsemsg')->name('update_tmresponsemsg');



///////////////paymentcurrency/////////////////
        Route::get('paymentcurrency', 'AdminController@show_all_paymentcurrency')->name('paymentcurrency');

/////////////// Discounts /////////////////
Route::resource('discount', 'DiscountController');


///////////////RSS Feeds/////////////////
        Route::get('rssfeed', 'AdminController@show_all_rssfeed')->name('rssfeed');
        Route::post('add_new_rssfeed', 'AdminController@add_new_rssfeed')->name('add_new_rssfeed');
        Route::post('update_rssfeed', 'AdminController@update_rssfeed')->name('update_rssfeed');
        Route::get('/delete_rssfeed/{id}', 'AdminController@delete_rssfeed')->name('delete_rssfeed');

///////////////Resource Center - Community/////////////////
        Route::get('community', 'AdminController@show_all_communities')->name('community');
        Route::post('add_new_community', 'AdminController@add_new_community')->name('add_new_community');
        Route::post('/update_community', 'AdminController@update_community')->name('update_community');

///////////////Resource Center - FAQs/////////////////
        Route::get('FAQs', 'AdminController@show_all_FAQs')->name('FAQs');
        Route::post('add_new_FAQs', 'AdminController@add_new_FAQs')->name('add_new_FAQs');
        Route::post('/update_FAQs', 'AdminController@update_FAQs')->name('update_FAQs');
        Route::get('delete_faq/{id}', 'AdminController@delete_faq')->name('delete_faq');

///////////////Resource Center - News/////////////////
        Route::get('article', 'AdminController@show_all_articles')->name('article');
        Route::post('add_new_article', 'AdminController@add_new_article')->name('add_new_article');
        Route::get('editnewscms/{id}', 'AdminController@edit_article_cms')->name('editnewscms');
		Route::get('deletenews/{id}', 'AdminController@delete_article')->name('deletenews');
        Route::post('/update_article', 'AdminController@update_article')->name('update_article');


///////////////Resource Center - User Guide/////////////////
        Route::get('userguide', 'AdminController@show_all_user_guide')->name('userguide');
        Route::post('add_new_user_guide', 'AdminController@add_new_user_guide')->name('add_new_user_guide');
        Route::get('edituserguidecms/{id}', 'AdminController@edit_user_guide_cms')->name('edituserguidecms');
        Route::post('/update_user_guide', 'AdminController@update_user_guide')->name('update_user_guide');
        Route::get('deleteuserguide/{id}', 'AdminController@delete_user_guide')->name('deleteuserguide');

///////////////Resource Center - Document Template/////////////////
        Route::get('doctemplate', 'AdminController@show_all_doctemplates')->name('doctemplate');
        Route::post('add_new_doctemplate', 'AdminController@add_new_doctemplate')->name('add_new_doctemplate');
        Route::post('update_doc_template', 'AdminController@update_doc_template')->name('update_doc_template');
        Route::get('delete_doc_template/{id}/{doc_id}', 'AdminController@delete_doc_template')->name('delete_doc_template');
///////////////companies types/////////////////
        Route::get('companies', 'AdminController@show_all_companiestype')->name('companies');

///////////////applicants types/////////////////
        Route::get('applicants', 'AdminController@show_all_applicanttype')->name('applicants');

///////////////applicants occupation/////////////////
        Route::get('occupation', 'AdminController@show_all_occupation')->name('occupation');

    });


////////////////////////////////////////////////////////////////////////////////
////////////////////---Member---////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////
    Route::prefix('member')->middleware(['member'])->
    group(function () {

        Route::get('/mprofile', 'HomeController@index')->name('mprofile');

        Route::get('/trademarkscms', 'MemberController@trademark_display')->name('trademarkscms');

Route::get('/trademark_history_display/{tm_id}', 'MemberController@trademark_history_display')->name('trademark_history_display');

        Route::get('/orderscms', 'MemberController@display_all_orders')->name('orderscms');
        Route::get('/completedorderscms', 'MemberController@display_completed_orders')->name('completedorderscms');

        Route::get('/single_order_detail/{c_o_id}', 'MemberController@single_order_detail')->name('single_order_detail');

        Route::get('/unpaidordercms', 'MemberController@display_unpaid_orders')->name('unpaidordercms');

        Route::get('/recievedorder', 'MemberController@received_order_display')->name('recievedorder');
        Route::get('/orderdetail/{id}', 'MemberController@received_order_detail_display')->name('orderdetail');

        Route::get('/progressorder', 'MemberController@inprogress_order_display')->name('progressorder');
        Route::get('/completedorder', 'MemberController@completed_order_display')->name('completedorder');

        Route::post('/update_order_status', 'MemberController@update_order_status')->name('update_order_status');
        Route::post('/update_tm_representative', 'MemberController@update_tm_representative')->name('update_tm_representative');

        Route::post('add_tm_response_doc', 'MemberController@add_tm_response_doc')->name('add_tm_response_doc');
        Route::get('delete_tm_response_doc/{id}', 'MemberController@delete_tm_response_doc')->name('delete_tm_response_doc');

        Route::post('update_tm_response', 'MemberController@update_tm_response')->name('update_tm_response');

        Route::post('add_tm_comment', 'MemberController@add_tm_comment')->name('add_tm_comment');


        Route::post('set_filling_data', 'MemberController@set_filling_data')->name('set_filling_data');

        Route::post('set_country_order_dates', 'MemberController@set_country_order_dates')->name('set_country_order_dates');


        Route::get('/clientreminder', 'MemberController@display_all_clients')->name('clientreminder');

//Route::post('edit_date_of_action', 'MemberController@edit_date_of_action')->name('edit_date_of_action');

    });


    Route::middleware(['customer'])->
    group(function () {


        Route::get('trademarks', 'ProfileController@index')->name('profile');
        Route::get('trademark-search', 'ProfileController@trademarkSearch')->name('trademark-search');
        Route::get('order-search', 'ProfileController@orderSearch')->name('order-search');
        Route::get('order/details/{id}', 'ProfileController@details')->name('');
        Route::get('trademarks/{id}', 'ProfileController@trademarks')->name('trademarks');
        Route::get('stripe/{id}', 'StripePaymentController@stripe')->name('stripe.create');
        Route::post('stripe', 'StripePaymentController@stripePost')->name('stripe.post');

    // checkout route
    Route::get('/checkoutDetails/{tid}/{oid}', 'CheckoutController@checkoutDetails')->name('checkoutDetails');
    Route::post('applyDiscount', 'CheckoutController@applyDiscount');
    Route::delete('cancelDiscount/{id}', 'CheckoutController@cancelDiscount');

        // General routes for all services [ add country - delete country - add class - delete class - delete order  ]
        Route::post('/addAnotherCountry', 'CheckoutController@addAnotherCountry')->name('addAnotherCountry');
        route::get('/delete/country/{trademark_country_id}/{order_id}', 'CheckoutController@deleteCountry')->name('deleteCountry');
        route::get('/delete/order/{order_id}/{trademark_id}', 'CheckoutController@deleteOrder')->name('deleteOrder');
        Route::post('/addAnotherClass', 'CheckoutController@addAnotherClass')->name('addAnotherClass');
        route::get('/delete/class/{class_id}/{country_id}/{order_id}', 'CheckoutController@deleteClass')->name('deleteClass');

        // Required-Documents Process
        Route::get('/required-documents/{id}', 'DocumentController@required_document')->name('document_required');
        Route::post('/store_documents', 'DocumentController@storeRequiredDocument')->name('storeDocuments');
        Route::get('/download-country-documents/{id}', 'DocumentController@downloadCountryDocument')->name('download-country-document');

        // Translation Service Process
        Route::get('translationDocuments/{id}', 'DocumentController@translationDocuments')->name('translationDocuments');
        Route::post('storeTranslationDocuments/{id}', 'DocumentController@storeTranslationDocuments')->name('storeTranslationDocuments');

        // Comment box on profile
        Route::post('saveComment', 'CommentController@store')->name('comment.store');
        Route::delete('deleteComment/{id}', 'CommentController@destroy')->name('comment.destroy');



    ////////////////////////// AliPay - WeChat /////////////////////////////////////

    Route::post('alipay', 'AliWeChatPaymentController@alipay_paymentintent')->name('alipay');

    Route::post('/wechat', 'AliWeChatPaymentController@wechat_paymentsource')->name('wechat');

    Route::post('charge', 'AliWeChatPaymentController@chargeWeChat')->name('charge');

    Route::get('selectpayment/{order_id}/{isDocument}/{isTranslation}', 'AliWeChatPaymentController@select_payment')->name('selectpayment');

    Route::get('alipay_redirect/{order_id}/{isDocument}/{isTranslation}', 'AliWeChatPaymentController@alipay_redirect');
   /* Route::get('/selectpayment', function () {
    return view('client.payment.selectpayment');
});*/

//--------------------------------Existing Trademark Logic------------------------------

Route::get('existTrademark', 'ExistTrademarkController@Exist_trademark_details')->name('existTrademark');
Route::post('create_order_existTM', 'ExistTrademarkController@create_order_existTM')->name('create_order_existTM');

});

    Route::resource('survey', 'SurveyController');
    Route::post('survey-mail', 'SurveyController@mail')->name('survey.mail');
    Route::get('survey-result', 'SurveyController@result')->name('result');
    Route::post('/userCurrency', 'FrontController@userCurrency')->name('userCurrency');
    Route::get('/forceUserLogin', 'FrontController@forceUserLogin')->name('forceUserLogin');
}
);
