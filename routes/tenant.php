<?php

use Illuminate\Support\Facades\Auth;

Route :: post('/register', 'Auth\RegisterController@createCompany');
Route :: group(['middleware' => ['web']], function () {
    Route ::namespace('App\\Http\\Controllers\\System\\') -> group(function () {
        Route ::get('/setup', 'SetupController@index') -> name('setup');
    });
    Route ::get('/check-new-environment-is-ready', 'App\Http\Controllers\AjaxController@newEnvironmentIsready');

    Route ::get('/', 'App\Http\Controllers\HomeController@redirectToMain');

    Route ::get('/jwtfreshdeskloginpage','App\Http\Controllers\System\FreshDeskController@setUserNameCookie' );

    Route ::namespace('App\\Http\\Controllers\\NovaController') -> group(function () {
        Route ::get('/getclientsinfo', 'ClientController@getclientsinfo');
    });
    Route ::namespace('App\\Http\\Controllers\\') -> group(function () {
        Auth ::routes(['register' => false]);
        Route ::get('/redirect/app', 'HomeController@redirectApp');
        Route ::get('/dropdown/account', 'AjaxController@getAccountOnCurrency');
        Route ::get('/dropdown/all-portfolio', 'AjaxController@getCostcenterAllPortfolio');
    });

    Route ::namespace('App\\Http\\Controllers\\System\\') -> middleware(['auth']) -> group(function () {

        // Invoices...
        Route ::get('/settings/' . Spark ::teamsPrefix() . '/{team}/invoices', 'CustomInvoiceController@all');
        Route ::get('/settings/' . Spark ::teamsPrefix() . '/{team}/invoice/{id}', 'CustomInvoiceController@download');

        //Subscription
        Route ::post('/settings/' . Spark ::teamsPrefix() . '/{team}/subscription/create', 'CustomPlanController@customStore');
        Route ::get('/settings/' . Spark ::teamsPrefix() . '/{team}/subscription/activeplan/get', 'CustomPlanController@getActivePlan');
        Route ::get('/settings/subscription/initial/package', 'CustomPlanController@getInitialPackage');

        //Team
        Route:: get('/settings/' . Spark ::teamsPrefix() . '/json/{team_id}', 'CustomTeamController@show');

        //leaseAcoounting.app subscription information
        Route:: get('/settings/subscription/info', 'CustomPlanController@getInitialPackage');


    });

    Route ::namespace('App\\Http\\Controllers\\') -> middleware(['auth']) -> group(function () {
        Route ::get('/audit-trail/{model}/{id}', 'AjaxController@getAudit') -> name('audit.lease');
        Route ::namespace('User') -> group(function () {
            Route ::get('/new-account-verification/{userId}', 'UserController@verify') -> name('new-account-verification');
            Route ::post('/new-account-verifications', 'UserController@postVerify') -> name('post-new-account-verification');
            Route ::resource('users', 'UserController');
            Route ::post('/update/{roleId}/{permissionId}', 'RoleController@update');
            Route ::get('/getroles', 'RoleController@getroles');
            Route ::resource('roles', 'RoleController', ['only' => ['index', 'show', 'create', 'store']]);
        });

        Route ::namespace('Report\\') -> group(function () {

//Lease Report
            Route ::get('/reporting/internal-lease', 'LeaseReportController@internalLease');
            Route ::post('/reporting/internal-lease', 'LeaseReportController@postInternalLease');
            Route ::get('/reporting/change-lease/{reportLibraryId?}', 'LeaseReportController@changeReportLease') -> name('reporting.change-lease');
            Route ::post('/reporting/change-lease', 'LeaseReportController@postChangeReportLease') -> name('post.reporting.change-lease');
            Route ::get('/reporting/month-payment/{reportLibraryId?}', 'LeaseReportController@monthReportLease') -> name('reporting.month-payment');
            Route ::post('/reporting/month-payment', 'LeaseReportController@postMonthReportLease') -> name('post.reporting.month-payment');
            Route ::get('/reporting/month-value/{reportLibraryId?}', 'LeaseReportController@monthValue') -> name('reporting.month-value');
            Route ::post('/reporting/month-value', 'LeaseReportController@postMonthValue') -> name('post.reporting.month-value');
            Route ::get('/reporting/notes-maturity/{reportLibraryId?}', 'LeaseReportController@notesMaturity') -> name('reporting.notes-maturity');
            Route ::post('/reporting/notes-maturity', 'LeaseReportController@postNotesMaturity') -> name('post.reporting.notes-maturity');
            Route ::get('/reporting/notes-periodical-depreciation', 'LeaseReportController@notesPeriodicalDepreciation') -> name('reporting.notes-periodical-depreciation');
            Route ::post('/reporting/notes-periodical-depreciation', 'LeaseReportController@postNotesPeriodicalDepreciation') -> name('post.reporting.notes-periodical-depreciation');
            Route ::get('/reporting/lease-valuation', 'LeaseReportController@leaseValuation') -> name('lease.valuation');
            Route ::post('/reporting/lease-valuation', 'LeaseReportController@postLeaseValuation') -> name('post.lease.valuation');
            Route ::get('/reporting/lease-summary/{reportLibraryId?}', 'LeaseReportController@leaseSummary') -> name('lease.summary');
            Route ::post('/reporting/lease-summary', 'LeaseReportController@postLeaseSummary') -> name('post.lease.summary');
            Route ::get('/reporting/lease-summary-ytd/{reportLibraryId?}', 'LeaseReportController@leaseSummaryYTD') -> name('lease.summary.ytd');
            Route ::post('/reporting/lease-summary-ytd', 'LeaseReportController@postLeaseSummaryYTD') -> name('post.lease.summary.ytd');
            Route ::get('/reporting/rou-asset-lease-type/{reportLibraryId?}', 'LeaseReportController@rouAssetByType') -> name('lease.asset-lease-type');
            Route ::post('/reporting/rou-asset-lease-type', 'LeaseReportController@postRouAssetByType') -> name('post.lease.asset-lease-type');
            Route ::get('/reporting/additions-lease-liability/{reportLibraryId?}', 'LeaseReportController@additionLeaseLiability') -> name('lease.additions-lease-liability');
            Route ::post('/reporting/additions-lease-liability', 'LeaseReportController@postAdditionLeaseLiability') -> name('post.lease.additions-lease-liability');
            Route ::get('/reporting/additions-right-asset/{reportLibraryId?}', 'LeaseReportController@rightAsset') -> name('lease.additions-rou-asset');
            Route ::post('/reporting/additions-right-asset', 'LeaseReportController@postRightAsset') -> name('post.lease.additions-rou-asset');
            Route ::get('/reporting/facility-overview/{reportLibraryId?}', 'LeaseReportController@facilityOverview') -> name('reporting.facility-overview');
            Route ::post('/reporting/facility-overview', 'LeaseReportController@postFacilityOverview') -> name('post.reporting.facility-overview');


//Audit Trail Report
            Route ::get('/reporting/audit-trail', 'AuditTrailController@index') -> name('audit-trail.report');
            Route ::post('/reporting/audit-trail', 'AuditTrailController@requestData') -> name('post.audit-trail.report');


//Report Library Report
            Route ::get('/reports-all', 'ReportLibraryController@allReport') -> name('reportcard-lease');;
            Route ::get('/report-library/index', 'ReportLibraryController@index') -> name('report-library.index');
            Route ::get('/report-library/delete/{id}', 'ReportLibraryController@delete') -> name('report-library.delete');
            Route ::get('/report-library/make/{id}', 'ReportLibraryController@makeReport') -> name('report-library.make');
            Route ::post('/report-library/multiple', 'ReportLibraryController@makeMultipleReport') -> name('report-library.multiple');

            Route ::get('/remove-encryption', 'ReportLibraryController@removeEncryption') -> name('remove-encryption');

            Route ::get('/trezone-api', 'ReportController@treZone') -> name('trezone-api.index');
            Route ::get('/trezone-api/data', 'ReportController@treZoneGet') -> name('get.trezone-api.index');

        });

        Route ::namespace('Setting\\') -> group(function () {

            Route ::resource('countries', 'CountryController');
            Route ::resource('currencies', 'CurrencyController');

            Route ::post('costcenter/import', 'CostCenterController@importPost') -> name('costcenter.import.post');
            Route ::get('costcenters/copy/{costcenter}', ['as' => 'costcenters.copy', 'uses' => 'CostCenterController@copy']);
            Route ::resource('costcenters', 'CostCenterController');


            Route ::get('counterparties/copy/{counterparty}', ['as' => 'counterparties.copy', 'uses' => 'CounterpartyController@copy']);
            Route ::resource('counterparties', 'CounterpartyController');
            Route ::get('counterparties/create/parent', 'CounterpartyController@createParentCompany') -> name('counterparties.create.parent');
            Route ::post('/company/import', 'CounterpartyController@handleImport');
            Route ::get('/admin/settings', 'AdminSettingController@index') -> name('admin-settings.index');
            Route ::post('/admin/settings', 'AdminSettingController@store') -> name('admin-settings.create');
            Route ::get('/dashboard/settings', 'DashboardController@index') -> name('dashboard.index');
            Route ::post('/dashboard/settings', 'DashboardController@store') -> name('dashboard.store');
            Route ::get('import', 'ImportController@index') -> name('import');
            Route ::get('/download/{module}/{id}/{file}', 'FileController@downloadFile');
            Route ::get('/delete/{module}/{id}/{file}', 'FileController@deleteFile');

            Route ::get('/import/{module}/{item}', 'ImportController@import') -> name('import.item');
            Route ::post('/lease/check', 'ImportController@leaseCheck') -> name('lease.check');
            Route ::post('/account/check', 'ImportController@accountCheck') -> name('account.check');
            Route ::post('/company/check', 'ImportController@counterpartyCheck') -> name('company.check');
            Route ::post('/fxrate/check', 'ImportController@fxrateCheck') -> name('fxrate.check');
            Route ::post('fxrate/import', 'FxRateController@importPost') -> name('fxrate.import.post');
            Route ::get('fxrates/copy/{fxrate}', ['as' => 'fxrates.copy', 'uses' => 'FxRateController@copy']);
            Route ::resource('fxrates', 'FxRateController');

            Route ::post('/mmrate/check', 'ImportController@mmrateCheck') -> name('mmrate.check');
            Route ::post('/securities/check', 'ImportController@securityCheck') -> name('securities.check');
            Route ::post('/360t/check', 'ImportController@threeSixtyTCheck') -> name('securities.check');
            Route ::post('/fxall/check', 'ImportController@fxAllCheck') -> name('securities.check');
            Route ::post('/chartOfAccount/check', 'ImportController@chartOfAccountCheck') -> name('chartOfAccount.check');
            Route ::post('/portfolio/check', 'ImportController@portfolioCheck') -> name('portfolio.check');
            Route ::post('/costcenter/check', 'ImportController@costcenterCheck') -> name('costcenter.check');

            Route ::post('portfolio/import', 'PortfolioController@importPost') -> name('portfolio.import.post');
            Route ::get('portfolios/copy/{portfolio}', ['as' => 'portfolios.copy', 'uses' => 'PortfolioController@copy']);
            Route ::resource('portfolios', 'PortfolioController');


            Route ::get('accounts/copy/{account}', ['as' => 'accounts.copy', 'uses' => 'AccountController@copy']);
            Route ::resource('accounts', 'AccountController');
            Route ::post('/account/import', 'AccountController@handleImport') -> name('account.import.post');
            Route ::get('/account/create/{companyId}', 'AccountController@createWithCompany') -> name('account.create.company');


        });

        Route ::namespace('Lease\\') -> group(function () {
            Route ::get('/delete/demo', 'LeaseController@deleteDemo') -> name('lease.remove-demo');
            Route ::get('/main', 'LeaseDashboardController@index') -> name('dashboard.lease');
            Route ::get('api/liability-per-type', 'LeaseController@liabilityPerType');
            Route ::get('api/liability-per-lessor', 'LeaseController@liabilityPerLessor');
            Route ::get('/dropdown/entity/lease', 'LeaseController@leaseDetail') -> name('entity-dropdown.lease');
            Route ::get('leases/copy/{lease}', ['as' => 'leases.copy', 'uses' => 'LeaseController@copy']);
            Route ::post('lease/import', 'LeaseController@importPost') -> name('leases.import.post');
            Route ::get('leases/archive', ['as' => 'leases.archive', 'uses' => 'LeaseController@archive']);
            Route ::resource('leases', 'LeaseController');
            Route ::get('api/asset-liability', 'LeaseController@assetLiability');
            Route ::get('/delete/lease-extension/{leaseExtension}', 'LeaseController@deleteExtension') -> name('lease-extension.delete');
            Route ::get('/lease-types/copy/{leaseType}', ['as' => 'lease-types.copy', 'uses' => 'LeaseTypeController@copy']);
            Route ::resource('lease-types', 'LeaseTypeController');
            Route ::get('api/stackedlinegraphleases', 'LeaseController@maturityGraph');
            Route ::get('/lease-test', 'LeaseController@maturityGraph');
            Route ::get('/lease-flows/generate/{id}', ['as' => 'lease-flows.generate', 'uses' => 'LeaseFlowController@generate']);
            Route ::post('/lease-flows/generate/store', ['as' => 'lease-flows.generate.store', 'uses' => 'LeaseFlowController@storeGeneratedPost']);
            Route ::post('/lease-flows/generate/post', ['as' => 'lease-flows.generate.post', 'uses' => 'LeaseFlowController@generatePost']);
            Route ::get('lease-flows/create/{lease}', 'LeaseFlowController@create') -> name('lease-flows.create');
            Route ::get('delete/lease-flows/{lease}', 'LeaseFlowController@deleteAll') -> name('lease-flows.delete.all');
            Route ::resource('lease-flows', 'LeaseFlowController', ['except' => ['create']]);
        });
    });
});

