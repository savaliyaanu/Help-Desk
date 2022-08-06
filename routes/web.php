<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/** Disable Register */
Auth::routes(['register' => false]);

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home-old', 'HomeController@oldHome');
Route::middleware(['auth'])->group(function () {
    /** Post Route */
    Route::post('getClientDetails/', 'ComplainController@getClientDetails');
    Route::post('getCityDetails/', 'ComplainController@getCityDetails');
    Route::post('get-Branch-Details', 'ServiceStationController@getBranchDetails');
    Route::post('get-products', 'ComplainController@getProducts');
    Route::post('get-branch', 'UsersController@getBranch');
    Route::post('complain-delete', 'ComplainController@destroy');
    Route::post('challan-delete', 'ChallanController@destroy');
    Route::post('invoice-delete', 'InvoiceController@destroy');
    Route::post('credit-note-delete', 'CreditNoteController@destroy');
    Route::post('complain-resolved', 'ComplainController@resolved');
    Route::post('complain-resolved-save', 'ComplainController@resolvedSave');
    Route::post('getBilltyDetails/', 'ChallanController@getBilltyDetails');
    Route::post('getChallanDetails', 'InvoiceController@getChallanDetails');
//Route::post('getCompanyDetails', 'BranchController@getCompanyDetails');
    Route::post('get-product', 'ChallanProductController@getProduct');
    Route::post('get-Bill-Detail', 'ChallanProductController@getBillDetails');
    Route::post('save-optional', 'ChallanProductController@saveOptional');
    Route::post('save-spare', 'ChallanProductController@saveSpare');
    Route::post('get-client', 'API\CommonController@getClient');
    Route::post('get-only-client', 'API\CommonController@getOnlyClient');
    Route::post('get-only-distributor', 'API\CommonController@getOnlyDistributor');
    Route::post('get-transport', 'API\CommonController@getTransport');
    Route::post('get-city', 'API\CommonController@getCity');
    Route::post('get-spare', 'API\CommonController@getSpareProductModel');
    Route::post('remove-image', 'ImageController@removeFile');
    Route::post('multifileuploads', 'ImageController@saveFile')->name('multifileuploads');
    Route::post('saveAssign', 'ComplainController@saveAssign');
    Route::post('followup-last-detail', 'ComplainController@getFollowUpLastDetail');
    Route::post('saveFollowUp', 'ComplainController@saveFollowUp');
    Route::post('get-last-complain', 'ComplainController@getLastComplain');
    Route::post('get-complain-detail-challan', 'ChallanProductController@getComplainDetailHistory');
    Route::post('get-client-info', 'ComplainController@getClientInfo');
    Route::post('faq-delete', 'SupportController@destroy');
    Route::post('get-category-id', 'EngineTestingController@getCategoryId');
    Route::post('get-order-no', 'AdvanceReplacementController@getOrderNo');
    Route::post('get-order-items', 'AdvanceReplacementController@getOrderItems');
    Route::post('get-old-data', 'ComplainController@getOldData');
    Route::post('get-complain-detail', 'ChallanProductController@getComplainDetail');
    Route::post('get-category-name', 'ChallanProductController@getCategoryName');
    Route::post('saveHandOverDate', 'BilltyController@saveHandOverDate');
    Route::post('get-complain-product', 'BilltyController@getComplainProduct');
    Route::post('get-particulars-name', 'ChallanShortageItemController@getParticulars');
    Route::post('get-complain-data', 'ReplacementExpenseController@getComplainData');
    Route::post('get-Qty', 'ReplacementExpenseImageController@getQty');
    Route::post('get-item-qty', 'ReplacementProductInController@getItemQty');
    Route::post('get-category', 'API\CommonController@getCategory');
    Route::post('get-product-name', 'API\CommonController@getProductname');
    Route::post('get-complain-list', 'API\CommonController@getComplainList');
    Route::post('get-client-name', 'API\CommonController@getClientName');

    /** End Post Route */

    /** Get Route */
    Route::get('update-status/{challan_id}', 'ChallanController@updateChallanStatus');
    Route::get('current-date/{billty_id}', 'BilltyController@getHandoverDate');
    Route::get('/complain-edit/{id?}', 'ComplainController@edit');
    Route::get('/complain-log/{id?}', 'ComplainController@log');
    Route::get('/challan-accessories-create/{challan_id?}', 'ChallanAccessoriesController@create');
    Route::get('/challan-panel-create/{id?}', 'ChallanPanelController@create');
    Route::get('/delete-optional-item/{id?}', 'ChallanProductController@deleteOptional');
//Route::get('/generate-challan-pdf/{id?}', 'ChallanController@generateChallanPdf');
    Route::get('print-fpdf/{id?}', 'ChallanController@printFpdf');
    Route::get('change-spare-pdf/{id?}', 'ChallanController@sparePdf');
    Route::get('challan-inspection-report/{id?}', 'ChallanController@inspectionReport');
    Route::get('delivery-challan-out/{id?}', 'InvoiceController@invoicecgstPdf');
    Route::get('delivery-challan-out-igst/{id?}', 'InvoiceController@invoiceigstPdf');
    Route::get('credit-note-pdf/{id?}', 'CreditNoteController@creditNoteFpdf');
    Route::get('destroy-pdf/{id?}', 'DestroyController@destroyFpdf');
    Route::get('service-report/{id?}', 'ReplacementExpenseController@serviceReport');
    Route::get('service-spare-report/{id?}', 'ReplacementExpenseController@spareReportDetail');
    Route::get('invoice-pdf/{id?}', 'InvoiceController@printPdf');
    Route::get('getComplainData', 'ComplainController@getComplainData');
    Route::get('multifileuploads', 'ImageController@multifileupload')->name('multifileuploads');
    Route::get('multifileuploads', 'ReplacementExpenseImageController@multifileupload')->name('multifileuploads');
    Route::get('/complain-assign/{id?}', 'ComplainController@assignComplain');
    Route::get('faq/{id?}', 'SupportController@question');
    Route::get('billty-pdf/{id?}', 'BilltyController@billtyFpdf');
    Route::get('search-for-help', 'SupportController@searchForHelp');
    Route::get('faq-edit/{id?}', 'SupportController@edit');
    Route::get('challan-engine-testing/{id?}', 'EngineTestingController@index');
    Route::get('replacement-in/{id?}', 'AdvanceReplacementInController@index');
    Route::get('inspection-report/{id?}', 'InspectionReportController@index');
    Route::get('callback-reason/{id?}', 'CallbackReasonController@index');
    Route::get('expense-spare-report/{id?}', 'ReplacementExpenseController@spareReport');
    Route::get('challan-shortage-item/{id?}', 'ChallanShortageItemController@create');
    Route::get('solution/{id?}', 'CaseSolutionController@index');
    Route::get('challan-image/{id?}', 'ImageController@index');
    Route::get('expense-product-in-image/{id?}', 'ReplacementExpenseImageController@index');
    Route::get('delivery-challan-product/{id?}', 'DeliveryChallanOutProductController@index');
    Route::get('delivery-product-inward/{delivery_challan_out_id?}', 'DeliveryProductInwardController@index');
    Route::get('advance-replacement-pdf/{id?}', 'AdvanceReplacementController@productOutPdf');
    Route::get('engine-testing-report/{id?}', 'ChallanController@testingReport');
    Route::get('supplier-delivery-challan/{out?}/{id?}', 'DeliveryChallanOutController@challanOutReport');
    Route::get('supplier-delivery-challan-in/{in?}/{id?}', 'DeliveryChallanOutController@challanInReport');
    Route::get('destroy-items/{id?}', 'DestroyItemController@index');
    Route::get('credit-note-items/{id?}', 'CreditNoteItemController@index');
    Route::get('multifileuploads', 'ReplacementExpenseImageController@saveFile')->name('multifileuploads');
    Route::get('complain-progress/{id?}', 'ComplainController@ComplainReport');
    Route::get('challan-product-create/{challan_id?}', 'ChallanProductController@create');
    Route::get('invoice-items-create/{invoice_id?}', 'InvoiceItemController@index');
    Route::get('change-spare-create/{challan_id?}', 'ChangeSpareController@index');



    /** End Get Route */

    /** Ajax DataTable Route Start */
    Route::get('get-company', 'CompanyMasterController@getData');
    Route::get('get-branch', 'BranchController@getData');
    Route::get('get-user', 'UsersController@getData');
    Route::get('get-client-data', 'ClientMasterController@getData');
    Route::get('get-complain', 'ComplainController@getData');
    Route::get('get-billty', 'BilltyController@getData');
    Route::get('get-challan', 'ChallanController@getData');
    Route::get('get-service-station', 'ServiceStationController@getData');
    Route::get('get-invoice', 'InvoiceController@getData');
    Route::get('get-credit-note', 'CreditNoteController@getData');
    Route::get('get-destroy', 'DestroyController@getData');
    Route::get('get-expense', 'ReplacementExpenseController@getData');
    Route::get('get-replacement', 'AdvanceReplacementController@getData');
    Route::get('get-delivery-challan', 'DeliveryChallanOutController@getData');
    Route::get('get-transport-detail', 'TransportMasterController@getData');
    Route::get('get-faq', 'SupportController@getData');
    /**Ajax DataTable Route End */


    /** Start Delete Route */
    Route::delete('delete-company', 'CompanyMasterController@destroy');
    Route::delete('delete-branch', 'BranchController@destroy');
    Route::delete('delete-user', 'UsersController@destroy');
    Route::delete('delete-billty', 'BilltyController@destroy');
    Route::delete('delete-challan', 'ChallanController@destroy ');
    Route::delete('delete-service-station/{id?}', 'ServiceStationController@destroy');
    Route::delete('delete-invoice/{id?}', 'InvoiceController@destroy');
    Route::delete('delete-credit-note', 'CreditNoteController@destroy');
    Route::delete('delete-destroy', 'DestroyController@destroy');
    Route::delete('delete-expense', 'ReplacementExpenseController@destroy');
    Route::delete('delete-replacement', 'AdvanceReplacementController@destroy');
    Route::delete('delete-delivery-challan', 'DeliveryChallanOutController@destroy');
    /** End Delete Route */


    /** Resource Route Start*/
    Route::resource('company', 'CompanyMasterController');
    Route::resource('complain-detail', 'ComplainController');
    Route::resource('complain', 'ComplainController');
    Route::resource('challan', 'ChallanController');
    Route::resource('invoice-items', 'InvoiceItemController');
    Route::resource('billty', 'BilltyController');
    Route::resource('change-spare-save', 'ChangeSpareController');
    Route::resource('invoice', 'InvoiceController');
    Route::resource('challan-product', 'ChallanProductController');
    Route::resource('challan-accessories', 'ChallanAccessoriesController');
    Route::resource('challan-shortage-item', 'ChallanShortageItemController');
    Route::resource('challan-panel', 'ChallanPanelController');
    Route::resource('branch', 'BranchController');
    Route::resource('users', 'UsersController');
    Route::resource('service-station', 'ServiceStationController');
    Route::resource('credit-note', 'CreditNoteController');
    Route::resource('credit-note-items', 'CreditNoteItemController');
    Route::resource('destroy', 'DestroyController');
    Route::resource('destroy-items', 'DestroyItemController');
    Route::resource('credit-note-report', 'CreditNoteReportController');
    Route::resource('challan-report', 'ChallanReportController');
    Route::resource('service-expense', 'ReplacementExpenseController');
    Route::resource('traveling-expense', 'TravelingExpenseController');
    Route::resource('other-expense', 'OtherExpenseController');
    Route::resource('party', 'PartyController');
    Route::resource('client-master', 'ClientMasterController');
    Route::resource('transport-master', 'TransportMasterController');
    Route::resource('challan-image', 'ImageController');
    Route::resource('support-menu', 'SupportController');
    Route::resource('case-solution', 'CaseSolutionController');
    Route::resource('engine-testing', 'EngineTestingController');
    Route::resource('shortage-item', 'ChallanShortageItemController');
    Route::resource('advance-replacement', 'AdvanceReplacementController');
    Route::resource('advance-replacement-in', 'AdvanceReplacementInController');
    Route::resource('advance-replacement-in', 'AdvanceReplacementInController');
    Route::resource('replacement-product', 'ReplacementProductInController');
    Route::resource('inspection-report', 'InspectionReportController');
    Route::resource('expense-product-in-image', 'ReplacementExpenseImageController');
    Route::resource('callback-reason', 'CallbackReasonController');
    Route::resource('delivery-out', 'DeliveryChallanOutController');
    Route::resource('delivery-challan-product-out', 'DeliveryChallanOutProductController');
    Route::resource('delivery-product-inward', 'DeliveryProductInwardController');
    Route::resource('complain-master-report', 'ComplainMasterReportController');
    Route::resource('delivery-product-pending', 'DeliveryChallanPendingReportController');
    Route::resource('challan-dispatch-report', 'ChallanDispatchController');
    Route::resource('billty-pending-statement', 'BilltyReportController');
    Route::resource('product-wise-report', 'ProductWiseReportController');
    Route::resource('mechanic-wise-report', 'MechanicWiseReportController');
    Route::resource('distributor-wise-report', 'DistributorWiseDispatchController');
    Route::resource('service-mechanic-wise-report', 'ServiceMechanicWiseReport');
    Route::resource('supplier-pending-report', 'SupplierPendingProductReportController');
    Route::resource('service-station-detail', 'ServiceStationMasterController');

    /** Resource Route End*/
});
Auth::routes();
