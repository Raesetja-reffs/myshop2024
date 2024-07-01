<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SalesForm;
use App\Http\Controllers\TabletLoadingApp;
use App\Http\Controllers\ArtificialCrud;
use App\Http\Controllers\RecentRegistered;
use App\Http\Controllers\DimsCommon;
use App\Http\Controllers\DriversController;
use App\Http\Controllers\SalesFormFunctions;
use App\Http\Controllers\ApisController;
use App\Http\Controllers\OnlineOrders;
use App\Http\Controllers\ConsoleManagement;
use App\Http\Controllers\LoadingAppAPIs;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\UserFeature;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\DimsReports;
use App\Http\Controllers\BackOrderController;
use App\Http\Controllers\OnlineOrdersReconController;
use App\Http\Controllers\ControlPanelController;
use App\Http\Controllers\ExternalFunctions;
use App\Http\Controllers\JasperReports;
use App\Http\Controllers\TestControllerReg;
use App\Http\Controllers\WareHouseManagementController;
use App\Http\Controllers\SalesManBriefcase;
use App\Http\Controllers\KerstonSpecialController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CallList;
use App\Http\Controllers\WareHouseController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect(route('login'));
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::post('getLiveDriversInfo', [ExternalFunctions::class, 'getLiveDriversInfo'] );

Route::get('home',[SalesForm::class, 'index'])->name('home');
Route::get('/sales',[SalesForm::class, 'index']);
Route::get('pl', [SalesForm::class,'pl']);
Route::get('returns',[SalesForm::class,'returns']);
Route::get('getProductsStopedBuyingJSon',[SalesForm::class,'getProductsStopedBuyingJSon']);
Route::get('getProductsStopedBuying',[SalesForm::class,'getProductsStopedBuying'] );
Route::get('getCustomerStoppedBuyingJSon',[SalesForm::class,'getCustomerStoppedBuyingJSon'] );
Route::get('getCustomerStoppedBuying',[SalesForm::class,'getCustomerStoppedBuying']);
Route::get('/getCustomers', [SalesForm::class,'getCustomers']);
Route::get('/prod', [SalesForm::class,'getProducts']);
Route::get('ordersreport', [SalesForm::class,'ordersreport']);
Route::get('getOrdersreportinfo/{date1}/{date2}',[SalesForm::class,'getOrdersreportinfo']);
Route::get('/registered', [RecentRegistered::class,'index'])->name('registered');
Route::post('/updatecart', [ArtificialCrud::class,'updateCart']);
Route::post('/updatereordering',[ArtificialCrud::class,'updatereordering'] );
Route::post('/emptyCart', [ArtificialCrud::class,'deleteCartItems']);
Route::post('/cartreorderingremoveitem', [ArtificialCrud::class,'deleteReorderingItems']);
Route::get('/invoiceXXX/{invoiceno}/{type}',[ArtificialCrud::class,'invoiceDetails']);
Route::post('/reordering/', [ArtificialCrud::class,'reorderBasedOnSelectedInvoice']);
Route::get('/incompletOrders', [IncompletOrders::class,'incompletOrders']);
Route::get('testPhpgrid', [RecentRegistered::class,'testPhpgrid']);
Route::get('instocksheet',[RecentRegistered::class,'instocksheet']);


//Route::post('ItemSearchCreate', 'ItemSearchController@create');
Route::resource('shop', 'HomeController', ['only' => ['show']]);
Route::resource('cart', 'CartController');
Route::resource('cart', 'CartController');

Route::get('dimsgloballandingpage',[HomeController::class, 'dimsgloballandingpage']);



Route::get('getExportForm', [DimsExportController::class,'getExportForm']);
Route::get('getDimsUsers', [UserFeature::class,'getDimsUsers']);

//DIMS COMMON STARTS HERE!!!!
Route::get('getCommonRoutes', [DimsCommon::class,'getCommonRoutes']);
Route::post('verifyAuthMario', [DimsCommon::class,'verifyAuthMario']);

Route::get('PointGrid', [DimsCommon::class,'PointGrid']);
Route::get('stocktakecountspage',[DimsCommon::class,'stocktakecountspage']);
Route::get('grvgridpage',[DimsCommon::class,'grvgridpage']);
Route::post('getPoLineGrid',[DimsCommon::class,'getPoLineGrid']);
Route::get('customerPointsTrends', [DimsCommon::class,'customerPointsTrends']);
Route::get('cardsList', [DimsCommon::class,'cardsList']);
Route::get('getCartsGrid', [DimsCommon::class,'getCartsGrid']);
Route::get('getPointGrid', [DimsCommon::class,'getPointGrid']);
Route::post('increasePoints',[DimsCommon::class,'increasePoints'] );
Route::post('updatecustomerwebstoreinfo',[DimsCommon::class,'updatecustomerwebstoreinfo'] );
Route::get('viewStatusReport', [DimsCommon::class,'viewStatusReport'] );
Route::get('getConsolidatedStatsReport', [DimsCommon::class,'getConsolidatedStatsReport']);
Route::get('massCustomer', [DimsCommon::class,'massCustomer']);

Route::get('getCostsPerdate',[DimsCommon::class,'getCostsPerdate']);
Route::get('viewdailycash',[DimsCommon::class,'viewdailycash']);
Route::get('viewDeletedOrders',[DimsCommon::class,'viewDeletedOrders'] );
Route::get('deleteordersJson/{datefrom}/{dateto}', [DimsCommon::class,'deleteordersJson']);
Route::get('customersalesperiod/{datefrom}/{dateto}', [DimsCommon::class,'customersalesperiod']);
Route::get('getdailycash/{datefrom}/{dateTo}',[DimsCommon::class,'getdailycash'] );
Route::get('customersalesperiodwebpage', [DimsCommon::class,'customersalesperiodwebpage']);
Route::get('advancedcustomerspecials',[DimsCommon::class,'advancedcustomerspecials'] );
Route::get('advancedcustomerspecialsJson',[DimsCommon::class,'advancedcustomerspecialsJson'] );
Route::post('masscustomerdatatable', [DimsCommon::class,'masscustomerdatatable'] );
Route::post('massproductdatatable',[DimsCommon::class,'massproductdatatable']);
Route::post('customerOrderListingHeader',[DimsCommon::class,'customerOrderListingHeader']);
Route::post('credentialsmatch', [DimsCommon::class,'credentialsmatch']);
Route::post('getAvailable', [DimsCommon::class,'getAvailable']);
Route::post('clearorderlocksperorder', [DimsCommon::class,'clearorderlocksperorder'] );
Route::get('massCustomerUpdate/{custId}', [DimsCommon::class,'massCustomerUpdate'] );
Route::get('customerorderpattern/{custId}',[DimsCommon::class,'customerorderpattern'] );
Route::get('spGetCostsPerDate/{date1}/{date2}', [DimsCommon::class,'spGetCostsPerDate'] );
Route::post('deletepatternline', [DimsCommon::class,'deletepatternline'] );
Route::get('getDeliveryDate', [DimsCommon::class,'getDeliveryDate']);
Route::get('dimsAdminUsers',[DimsCommon::class,'dimsAdminUsers']);
Route::post('restFullOrderLock',[DimsCommon::class,'restFullOrderLock']);
Route::post('restFullUnLockOrder', [DimsCommon::class,'restFullUnLockOrder']);
Route::post('deleteuserOrderLocks',[DimsCommon::class,'deleteuserOrderLocks']);
Route::post('updatebasicinfo', [DimsCommon::class,'updatebasicinfo']);
Route::post('updateContactInfo', [DimsCommon::class,'updateContactInfo']);
Route::post('updatePayments',[DimsCommon::class,'updatePayments']);
Route::post('insertIntoPushProducts', [DimsCommon::class,'insertIntoPushProducts']);
Route::post('insertIntoProhibitProducts',[DimsCommon::class,'insertIntoProhibitProducts']);
Route::post('removePushProducts', [DimsCommon::class,'removePushProducts']);
Route::post('removeProhibitProducts',[DimsCommon::class,'removeProhibitProducts']);
Route::get('productOnPush/{customerId}',[DimsCommon::class,'productOnPush']);
Route::get('productOnprohibit/{customerId}', [DimsCommon::class,'productOnprohibit']);
Route::get('specials',[DimsCommon::class,'specials']);
Route::get('customerspecialsbulkediting/{customercode}/{datefrom}/{dateto}', [DimsCommon::class,'customerspecialsbulkediting']);
Route::get('groupspecialsbulkediting/{customercode}/{datefrom}/{dateto}', [DimsCommon::class,'groupspecialsbulkediting']);
Route::get('getbulkeditingLandingage/{customercode}/{datefrom}/{dateto}', [DimsCommon::class,'getbulkeditingLandingage']);
Route::get('getgroupspecialbulkeditingLandingage/{groupId}/{datefrom}/{dateto}',[DimsCommon::class,'getgroupspecialbulkeditingLandingage']);
Route::get('groupspecials', [DimsCommon::class,'groupspecials']);
Route::get('overallspecials',[DimsCommon::class,'overallspecials']);
Route::get('combospecials',[DimsCommon::class,'combospecials']);
Route::post('combospecialsjson',[DimsCommon::class,'combospecialsjson']);
Route::post('xmlSaveComboHeaders',[DimsCommon::class,'xmlSaveComboHeaders']);
Route::post('xmlSaveComboLines',[DimsCommon::class,'xmlSaveComboLines']);
Route::post('combospecialsjsonlines',[DimsCommon::class,'combospecialsjsonlines']);
Route::get('andNewSpecial', [DimsCommon::class,'andNewSpecial']);
Route::get('customerspecialTemplate', [DimsCommon::class,'customerspecialTemplate']);
Route::get('checkifcustomerspecial/{date1}/{date2}', [DimsCommon::class,'checkifcustomerspecials']);
Route::get('getcheckifcustomerspecials', [DimsCommon::class,'getcheckifcustomerspecials']);
Route::get('addNewGroupSpecial', [DimsCommon::class,'addNewGroupSpecial']);
Route::get('managementSearch', [DimsCommon::class,'managementSearch']);
Route::post('updateDelvAdress', [DimsCommon::class,'updateDelvAdress']);
Route::post('XmlBulkEditingCustomerSpecials',[DimsCommon::class,'XmlBulkEditingCustomerSpecials']);
Route::post('XmlBulkEditingGroupSpecials', [DimsCommon::class,'XmlBulkEditingGroupSpecials']);
Route::get('managementcosoleresult/{consoletype}/{OrderId}/{InvoiceNo}/{ProductCode}', [ConsoleManagement::class,'managementcosoleresult']);
Route::post('createCustomerSpecials', [DimsCommon::class,'createCustomerSpecials']);
Route::post('overallSpecialHeader', [DimsCommon::class,'overallSpecialHeader']);
Route::post('createGroupSpecials',  [DimsCommon::class,'createGroupSpecials']);
Route::post('createOverallSpecials',  [DimsCommon::class,'createOverallSpecials']);
Route::post('customerByDateOrContract',  [DimsCommon::class,'customerByDateOrContract']);
Route::post('customerGroupByDateOrContract',  [DimsCommon::class,'customerGroupByDateOrContract']);
Route::get('viewgroupinexcel/{from}/{to}/{groupid}', [DimsCommon::class,'viewgroupinexcel'] );
Route::get('jsonViewgroupspecialExcel/{from}/{to}/{groupid}', [DimsCommon::class,'jsonViewgroupspecialExcel']);
Route::post('overallSpecailByDateOrContract', [DimsCommon::class,'overallSpecailByDateOrContract']);
Route::post('updatespeciialLine', [DimsCommon::class,'updatespeciialLine']);
Route::post('updategGroupSpecialLine', [DimsCommon::class,'updategGroupSpecialLine']);
Route::post('updateOverallSpecialLine', [DimsCommon::class,'updateOverallSpecialLine']);
Route::post('insertIntoTblPicking', [DimsCommon::class,'insertIntoTblPicking']);
Route::post('insertIntoTblPickingPerRoute',  [DimsCommon::class,'insertIntoTblPickingPerRoute']);
Route::post('startcopyingorderpatternhistorytoaccount', [DimsCommon::class,'startcopyingorderpatternhistorytoaccount']);
Route::post('deleteaddressonthecustomerdeliveryaddresstbl',  [DimsCommon::class,'deleteaddressonthecustomerdeliveryaddresstbl']);
Route::get('getDataFromManagementConsole', [DimsCommon::class,'getDataFromManagementConsole']);
Route::get('getDataFromManagementConsoleForAuditors', [DimsCommon::class,'getDataFromManagementConsoleForAuditors']);
Route::get('customerAddressLandingPage', [DimsCommon::class,'customerAddressLandingPage']);
Route::get('customerDeliveryAddress/{custcode}',[DimsCommon::class,'customerDeliveryAddress']);
Route::get('selectCustomerAddressToUpdate/{addressid}/{address1}/{address2}/{address3}/{address4}/{address5}/{customercode}', [DimsCommon::class,'deleteaddressonthecustomerdeliveryaddresstbl']);
Route::post('intoTblPrintedDoc', [DimsCommon::class,'intoTblPrintedDoc']);
Route::post('invoicedoc', [DimsCommon::class,'invoicedoc']);
Route::post('uploader',[DimsCommon::class,'uploader']);
Route::post('warehouseProductStockLookUp',[DimsCommon::class,'warehouseProductStockLookUp']);
Route::post('intoTblPrintedDocPickingSlips',[DimsCommon::class,'intoTblPrintedDocPickingSlips']);
Route::post('emailOrder',[DimsCommon::class,'InsertToEmail']);
Route::post('printInvoiceNow',[DimsCommon::class,'printInvoiceNow']);
Route::post('printTruckControlID', [DimsCommon::class,'printTruckControlID']);
Route::post('increasePriceUsingMargin',[DimsCommon::class,'increasePriceUsingMargin']);
Route::get('masscusterspecialdatefilter/{datefrom}/{dateto}/{marginless}/{margingreater}/{rep}',[DimsCommon::class,'masscusterspecialdatefilter']);
Route::get('changefiltereddatamassspecials/{dateFromFilter}/{dateToFilter}/{marginfilterless}/{marginfiltergreater}/{rep}', [DimsCommon::class,'changefiltereddatamassspecials']);
Route::get('getJsonCustomerGrid',[DimsCommon::class,'getJsonCustomerGrid']);
Route::post('removeGroupSpecial',[DimsCommon::class,'removeGroupSpecial']);
Route::post('deleteselectedgroupspeciallines', [DimsCommon::class,'deleteselectedgroupspeciallines']);
Route::post('deleteselectedcustomerspeciallines',[DimsCommon::class,'deleteselectedcumassCustomerstomerspeciallines']);
Route::post('removeOverallSpecial',[DimsCommon::class,'removeOverallSpecial']);
Route::post('verifyAuth', [DimsCommon::class,'verifyAuth']);
Route::post('changesalesman', [DimsCommon::class,'changesalesman']);
Route::post('changerouteonorder',[DimsCommon::class,'changerouteonorder']);
Route::get('customerflexgrid',[DimsCommon::class,'customerflexgrid']);
Route::get('getCustomerDataForGrid',[DimsCommon::class,'getCustomerDataForGrid']);
Route::post('updateCustomerGrid',[DimsCommon::class,'updateCustomerGrid']);
Route::post('masscustomerspecialupgrade',[DimsCommon::class,'masscustomerspecialupgrade']);
Route::post('verifyAuthOnAdmin', [DimsCommon::class,'verifyAuthOnAdmin']);
Route::post('verifyAuthCreditors',[DimsCommon::class,'verifyAuthCreditors']);
Route::post('AuthBulkZeroCost',[DimsCommon::class,'AuthBulkZeroCost']);
Route::post('updateallOrderlinestocostauth',[DimsCommon::class,'updateallOrderlinestocostauth']);
Route::post('AuthExternaOrders', [DimsCommon::class,'AuthExternaOrders']);
Route::post('verifyAuthOnAdminMargin', [DimsCommon::class,'verifyAuthOnAdminMargin']);
Route::post('verifyAuthGroupLeaders', [DimsCommon::class,'verifyAuthGroupLeaders']);
Route::post('communications', [DimsCommon::class,'communications']);
Route::post('clearAllLocksRestFull', [DimsCommon::class,'clearAllUserLocks']);
Route::post('doneextending',[DimsCommon::class,'doneextending']);
Route::post('doneextendinggroupspecials',[DimsCommon::class,'doneextendinggroupspecials']);
Route::post('updatecustomergridpricing',[DimsCommon::class,'updatecustomergridpricing']);
Route::get('invoiceLookUp', [DimsCommon::class,'invoiceLookUp']);
Route::get('customerLookUp',[DimsCommon::class,'customerLookUp']);
Route::get('marginControl',[DimsCommon::class,'marginControl']);
Route::get('viewCreditLimit', [DimsCommon::class,'viewCreditLimit']);
Route::get('customernoteshistory/{customerid}',[DimsCommon::class,'customernoteshistory']);
Route::get('getCreditLimitJson',[DimsCommon::class,'getCreditLimitJson']);
Route::get('getAgeAnalysis/{customerid}', [DimsCommon::class,'getAgeAnalysis']);
Route::POST('customernoteshistoryupdate',[DimsCommon::class,'customernoteshistoryupdate']);
Route::POST('customernoteshistoryinsert',[DimsCommon::class,'customernoteshistoryinsert']);
Route::POST('assignRouteToTheCustomer',[DimsCommon::class,'assignRouteToTheCustomer']);
Route::get('blnCompanyReports', [DimsCommon::class,'blnCompanyReports']);
Route::get('massgridspecialscustomer', [DimsCommon::class,'massgridspecialscustomer']);
Route::get('userpickingloadingperformancereport',[DimsCommon::class,'userpickingloadingperformancereport']);
Route::get('userpickingloadingperformancereportJson/{datefrom}/{dateto}', [DimsCommon::class,'userpickingloadingperformancereportJson']);
Route::get('pickingLiveGrid', [DimsCommon::class,'pickingLiveGrid']);
Route::get('driverLiveGrid', [DimsCommon::class,'driverLiveGrid']);
Route::get('custometPricingPage/{customerid}',[DimsCommon::class,'custometPricingPage']);
Route::get('custometPricingJson/{customerid}', [DimsCommon::class,'custometPricingJson']);
Route::get('viewCreditLimit',[DimsCommon::class,'viewCreditLimit']);
Route::get('customersalespage',[DimsCommon::class,'customersalespage']);
Route::get('getDeliveryAddressOrderPattern/{account}/{addressid}',[DimsCommon::class,'getDeliveryAddressOrderPattern']);
Route::get('customersalesJson/{datefrom1}/{dateto1}/{datefrom2}/{dateto3}',[DimsCommon::class,'customersalesJson']);
Route::get('customerupdatepricingfromcustomerssalespage/{custcode}/{datefrom}/{dateto}/{datefrom2}/{dateto2}',[DimsCommon::class,'customerupdatepricingfromcustomerssalespage']);

Route::get('bulpickingbyBatch/{timestamp}',[DimsCommon::class,'bulpickingbyBatch']);
Route::get('UpdateDocument',[DimsCommon::class,'UpdateDocument']);
Route::post('updateDocumentupdate',[DimsCommon::class,'UpdateDocumentupdate']);
Route::get('/WebstoreMessages',[DimsCommon::class,'WebstoreMessages']);
Route::get('/getMessageGrid',[DimsCommon::class,'getMessageGrid'] );
Route::get('viewcustomerpricingjson/{custcode}/{datefrom}/{dateto}/{datefrom2}/{dateto2}',[DimsCommon::class,'viewcustomerpricingjson'] );
Route::get('printcustomerpricingjson/{custcode}/{datefrom}/{dateto}/{datefrom2}/{dateto2}',[DimsCommon::class,'printcustomerpricingjson']);
Route::post('updateMessage',[DimsCommon::class,'updateMessage'] );
Route::post('checkifhasmultiaddress',[DimsCommon::class,'checkifhasmultiaddress'] );
Route::get('backorders',[DimsCommon::class,'backorders']);

Route::get('customerSpecials', [DimsCommon::class,'customerSpecials']);
Route::get('getOverallCustomerSpecials', [DimsCommon::class,'getOverallCustomerSpecials']);
Route::post('XmlCreateCustomerSpecials',  [DimsCommon::class,'XmlCreateCustomerSpecials']);
Route::post('removeCustomerSpecial',[DimsCommon::class,'removeCustomerSpecial']);

//DIMS COMMON ENDS HERE HERE!!!!

//SALES FORM FUNCTIONS STARTS HERE!!!

Route::get('custCode',[SalesFormFunctions::class, 'CustomerCode']);
Route::get('copyorder/{orderid}',[SalesFormFunctions::class, 'copyorder']);
Route::post('insertCopyorder',[SalesFormFunctions::class, 'insertCopyorder']);
Route::post('checkZeroCostOnOrder',[SalesFormFunctions::class, 'checkZeroCostOnOrder']);
Route::post('checkstockonorders',[SalesFormFunctions::class, 'checkstockonorders']);
Route::get('getorderlocksdeleterpage',[SalesFormFunctions::class,'getorderlocksdeleterpage']);
Route::get('getOrderLocksForDeletePageData',[SalesFormFunctions::class,'getOrderLocksForDeletePageData']);
Route::post('deleteDataForOrderLockPage',[SalesFormFunctions::class,'deleteDataForOrderLockPage']);
Route::post('custID', [SalesFormFunctions::class,'getCustomerID']);
Route::get('getAllProductsAndCosts', [SalesFormFunctions::class,'getAllProductsAndCosts']);
Route::get('getProductCodes',[SalesFormFunctions::class,'getProductCodes']);
Route::get('custDescription',[SalesFormFunctions::class,'CustomerDescription']);
Route::get('prodCode', [SalesFormFunctions::class,'ProductCode']);
Route::get('prodDesciption',[SalesFormFunctions::class,'ProductDescription']);
Route::get('deliveryTypes',[SalesFormFunctions::class,'getDeliverTypes']);
Route::post('updateCContactsOnOrder', [SalesFormFunctions::class,'updateCContactsOnOrder']);
Route::post('orderheaderAndOrderLines', [SalesFormFunctions::class,'orderheaderAndOrderLines']);
Route::post('getCutomerPriceOnOrderForm', [SalesFormFunctions::class,'returnProductPrice']);
Route::post('getextracomunsforItems', [SalesFormFunctions::class,'getextracomunsforItems']);
Route::post('getCutomerPastInvoices', [SalesFormFunctions::class,'getCustomerPast10Invoices']);
// Route::post('customerSpecials', [SalesFormFunctions::class,'getCustomerSpecials']);
Route::post('groupSpecials', [SalesFormFunctions::class,'getGroupSpecials']);
Route::post('combinedSpecials',[SalesFormFunctions::class,'combinedSpecials']);
Route::post('priceSearch', [SalesFormFunctions::class,'priceLookUpOntab']);
Route::post('insertOrderHeader',[SalesFormFunctions::class,'insertOrderHearder']);
Route::post('insertHeaderForOtherTrans', [SalesFormFunctions::class,'insertHeaderForOtherTrans']);
Route::post('insertOrderDetails',[SalesFormFunctions::class,'insertOrderDetails']);
Route::post('insertNewAddress',[SalesFormFunctions::class,'insertNewAddress']);
Route::post('jsonOrderDetails',[SalesFormFunctions::class,'postOrderDetailsAsJsonArray']);
Route::post('jsonOtherTransactionsLinesDetails', [SalesFormFunctions::class,'postOrderDetailsAsJsonArrayForOtherTransactions']);
Route::post('jsonOrderDetailsPos',[SalesFormFunctions::class,'postOrderDetailsAsJsonArrayPOS']);
Route::post('createbackorderonsplit',[SalesFormFunctions::class,'createbackorderonsplit']);
Route::post('printPickingSlipPerOrder', [SalesFormFunctions::class,'printPickingSlipPerOrder']);
Route::post('productsOnOrder', [SalesFormFunctions::class,'productsOnOrder']);
Route::post('deleteOrderLine', [SalesFormFunctions::class,'deleteOrderLine']);
Route::post('deleteOrderLinedetails', [SalesFormFunctions::class,'deleteOrderLinedetails']);
Route::get('getOnOrder', [SalesFormFunctions::class,'getOnOrder']);
Route::post('countOnSalesOrder', [SalesFormFunctions::class,'countOnSalesOrder']);
Route::post('productsOnInvoiced',[SalesFormFunctions::class,'productsOnInvoiced']);
Route::post('getOrderPattern', [SalesFormFunctions::class,'getCustomerOderpattern']);
Route::post('getCustomerRoutes', [SalesFormFunctions::class,'getCustomerRouteWithOtherRoutesByPriority']);
Route::post('getOrderListing',[SalesFormFunctions::class,'getOrderListing']);
Route::post('getOrderListingOtherTrans',[SalesFormFunctions::class,'getOrderListingOtherTrans']);
Route::post('onCheckOrderHeader', [SalesFormFunctions::class,'onCheckOrderHeader']);
Route::post('checkIfOrderExistsWithOrderType', [SalesFormFunctions::class,'checkIfOrderExists']);
Route::post('onCheckOrderHeaderDetails', [SalesFormFunctions::class,'onCheckOrderHeaderDetails']);
Route::post('isClosedRoute',[SalesFormFunctions::class,'isClosedRoute']);
Route::post('onCheckOrderHeaderForOtherTrans', [SalesFormFunctions::class,'onCheckOrderHeaderForOtherTrans']);
Route::post('checkIfOrderExistsWithOrderTypeForOtherTrans', [SalesFormFunctions::class,'checkIfTransactionsExists']);
Route::post('onCheckOrderHeaderDetailsForOtherTrans', [SalesFormFunctions::class,'onCheckOrderHeaderDetailsForOtherTrans']);
Route::post('convertToSalesOrder', [SalesFormFunctions::class,'convertToSalesOrder']);
Route::post('treatAsQuote', [SalesFormFunctions::class,'treatAsQuote']);
Route::post('markitawaitingstock', [SalesFormFunctions::class,'markitawaitingstock']);
Route::post('generalPriceChecking',[SalesFormFunctions::class,'generalPriceChecking']);
Route::post('advancedorderno', [SalesFormFunctions::class,'advancedOrderNo']);
Route::post('generalPriceCheckAndLastCost', [SalesFormFunctions::class,'generalPriceCheckAndLastCost']);
Route::post('getCallList',[SalesFormFunctions::class,'getCallList'] );
Route::post('getCallListNew',[SalesFormFunctions::class,'getCallListNew'] );
Route::post('insertCallistFilters', [SalesFormFunctions::class,'insertCallistFilters']);
Route::post('isCalled',[SalesFormFunctions::class,'insertCallID']);
Route::post('selectCustomerMultiAddress',[SalesFormFunctions::class,'selectCustomerMultiAddress']);
Route::post('selectCustomerMultiAddressconfirm',[SalesFormFunctions::class,'selectCustomerMultiAddressconfirm']);
Route::post('submitchangeddeliveryaddress',[SalesFormFunctions::class,'submitchangeddeliveryaddress']);
Route::post('copyOrdersToCustomers', [SalesFormFunctions::class,'copyOrdersToCustomers']);
Route::post('generatePDFForOrders',[SalesFormFunctions::class,'generatePDFForOrders']);
Route::post('countAddress', [SalesFormFunctions::class,'countAddress']);
Route::post('countomerSingleAddress', [SalesFormFunctions::class,'countomerSingleAddress']);
Route::post('createNewCustomDelvDate',[SalesFormFunctions::class,'spCreateNewtblCustomerDeliveryAddress']);
Route::post('getLastInsertedDate',[SalesFormFunctions::class,'getLastInsertedDate']);
Route::post('getProductStockOnHand', [SalesFormFunctions::class,'getProductStockOnHand']);
Route::post('deleteOrderDetails', [SalesFormFunctions::class,'DeleteOrderDetails']);
Route::post('DeleteOrderDetailsOrtherTrans',[SalesFormFunctions::class,'DeleteOrderDetailsOrtherTrans']);
Route::post('updateAuthHeader', [SalesFormFunctions::class,'updateAuthHeader']);
Route::post('selectAddressFromMultiAddressDeliveruyAddressId', [SalesFormFunctions::class,'selectAddressFromMultiAddressDeliveruyAddressId']);
Route::post('updateOrderHeader', [SalesFormFunctions::class,'UpdateOrderHearder']);
Route::post('splitorders', [SalesFormFunctions::class,'splitorders']);
Route::post('splitordersmake', [SalesFormFunctions::class,'splitordersmake']);
Route::post('deleteByHiddenToken', [SalesFormFunctions::class,'deleteByHiddenToken']);
Route::post('updateOrderHeaderForOtherTransactions', [SalesFormFunctions::class,'updateOrderHeaderForOtherTransactions']);
Route::post('tempDeliverAddress', [SalesFormFunctions::class,'tempDeliverAddress']);
Route::get('pointofsale',[SalesFormFunctions::class,'pointOfSale'] );
Route::post('posCashFloat',[SalesFormFunctions::class,'posCashFloat']);
Route::post('postPOSfloat',[SalesFormFunctions::class,'postPOSfloat']);
Route::post('deletePOSfloat',[SalesFormFunctions::class,'deletePOSfloat']);
Route::post('updateDiscount', [SalesFormFunctions::class,'updateDiscount']);
Route::post('copyInvoice', [SalesFormFunctions::class,'copyOrderToNewOrder']);
Route::post('adjustDispatch', [SalesFormFunctions::class,'adjustTheDispatchQtyOnPickingOrder']);
Route::post('printAdjustmentDispatch',[SalesFormFunctions::class,'printInvoiceFromPickingFormAdjustment']);
Route::post('createAbackOrder',[SalesFormFunctions::class,'createAbackOrder']);
Route::post('waitingForInvoiceNo', [SalesFormFunctions::class,'waitingForInvoiceNo']);
Route::post('checkifInvoiced',[SalesFormFunctions::class,'checkifInvoiced']);
Route::post('AssignInvoiceNumber', [SalesFormFunctions::class,'AssignInvoiceNumber']);
Route::post('toProcessPosTenderLines', [SalesFormFunctions::class,'toProcessPosTenderLines']);
Route::get('updatePosRoute', [SalesFormFunctions::class,'updatePosRoute']);
Route::get('getAllOrderIDs', [SalesFormFunctions::class,'getAllOrderIDs']);
Route::post('getCustomerOrderId', [SalesFormFunctions::class,'getCustomerOrderId']);
Route::post('productPriceLookUp', [SalesFormFunctions::class,'productPriceLookUp']);
Route::post('associatedItem',[SalesFormFunctions::class,'associatedItem']);
Route::post('changeDeliveryAddressOnNoInvoiceNo', [SalesFormFunctions::class,'changeDeliveryAddressOnNoInvoiceNo']);
Route::get('getordertorelease', [SalesFormFunctions::class,'getordertorelease']);
Route::get('getbelowgp', [SalesFormFunctions::class,'getbelowgp']);
Route::get('getbelowgpheader', [SalesFormFunctions::class,'getbelowgpheader']);
Route::get('getbelowgplines/{orderdeid}', [SalesFormFunctions::class,'getbelowgplines']);
Route::get('getorderheadertorelease', [SalesFormFunctions::class,'getorderheadertorelease']);
Route::get('getorderlineslist/{orderid}', [SalesFormFunctions::class,'getorderlineslist']);
Route::post('postreleaseorder', [SalesFormFunctions::class,'postreleaseorder']);
Route::post('removeorderfromawaitingstock', [SalesFormFunctions::class,'removeorderfromawaitingstock']);
Route::get('viewordersonawaiting/{orderid}', [SalesFormFunctions::class,'viewordersonawaiting']);



//SALES FORM FUNCTIONS ENDS HERE!!!


//CONSOLE MANAGEMENT STARTS HERE !!!
Route::post('logMessageAjax',[ConsoleManagement::class,'logMessageAjax']);
Route::post('logMessageAuth', [ConsoleManagement::class,'logMessageAuth']);
Route::post('deleteallLinesOnOrder', [ConsoleManagement::class,'deleteallLinesOnOrder']);
Route::post('logMessageAuthMargin',[ConsoleManagement::class,'logMessageAuthMargin'] );

//CONSOLE MANAGEMENT ENDS HERE!!!

//TABLET LOADING APP STARTS HERE !!!
Route::get('routePlannerSuggestions/{date}/{ordertype}/{route}/{status}', [TabletLoadingApp::class,'routePlannerSuggestions']);
Route::post('getRouteData',[TabletLoadingApp::class,'getRouteData']);
Route::post('sequenceOrdersByMode', [TabletLoadingApp::class,'sequenceOrdersByMode']);
Route::post('sequenceOrdersByMode',[TabletLoadingApp::class,'sequenceOrdersByMode'] );
Route::post('resequenceOrders', [TabletLoadingApp::class,'resequenceOrders']);
Route::post('deselectIsPressed', [TabletLoadingApp::class,'deselectIsPressed']);
Route::get('truckControlId',[TabletLoadingApp::class,'truckControlId']);
Route::get('routePlannerPrintPreview/{date}/{dateTo}/{ordertype}/{route}/{status}',[TabletLoadingApp::class,'routePlannerPrintPreview']);
Route::post('moveTheOrder',[TabletLoadingApp::class,'moveTheOrder']);
Route::post('moveTheOrderArray', [TabletLoadingApp::class,'moveTheOrderArray']);
Route::get('truckControlFromDate',[TabletLoadingApp::class,'truckControlFromDate']);
Route::get('amalgamation',[TabletLoadingApp::class,'amalgamation']);
Route::get('retrieve/{del}/{route}/{ordertype}',[TabletLoadingApp::class,'retrieve']);
Route::get('driverFleetInfo/{del}/{route}/{ordertype}', [TabletLoadingApp::class,'driverFleetInfo']);
Route::get('bulkPickingPerUserJSON/{from}/{to}',[TabletLoadingApp::class,'bulkPickingPerUserJSON']);
Route::get('bulkPickingPerUserView', [TabletLoadingApp::class,'bulkPickingPerUserView']);
Route::get('designPickingInformationPerTeam/{del}/{route}/{ordertype}', [TabletLoadingApp::class,'designPickingInformationPerTeam']);
Route::get('truckControlSheetDetails', [TabletLoadingApp::class,'truckControlSheetDetails']);
Route::post('stopsUnmapped', [TabletLoadingApp::class,'stopsUnmapped']);
Route::post('getRouteDataMultiSelected', [TabletLoadingApp::class,'getRouteDataMultiSelected']);

Route::get('routePlannerExt', [TabletLoadingApp::class,'routePlannerExt']);
Route::get('invoicesnotprinting', [TabletLoadingApp::class,'invoicesnotprinting']);
Route::post('notifypickers',[TabletLoadingApp::class,'notifypickers']);
Route::get('liveBulkPicking', [TabletLoadingApp::class,'liveBulkPicking']);
Route::get('printLoadingSheet/{routingId}', [TabletLoadingApp::class,'printLoadingSheet']);
Route::get('getDrivers', [TabletLoadingApp::class,'getDrivers']);
Route::get('getTrucks', [TabletLoadingApp::class,'getTrucks']);
Route::get('getData/{orderdate}/{ordertype}/{routename}/{driver}/{assistant}/{truckname}/{assistanttwo}/{userid}',[TabletLoadingApp::class,'getData']);
Route::get('liveFleetDeliveries',[TabletLoadingApp::class,'liveFleetDeliveries']);
Route::get('driverreq_report',[TabletLoadingApp::class,'driverreq_report']);
Route::get('driverreq_reportJson/{date1}/{date2}', [TabletLoadingApp::class,'driverreq_reportJson']);
Route::get('driverreq_perrouteJson/{routeid}',[TabletLoadingApp::class,'driverreq_perrouteJson']);
Route::get('updatelogisticsinformation', [TabletLoadingApp::class,'updatelogisticsinformation']);
Route::get('ligisticsplan/{dates}', [TabletLoadingApp::class,'ligisticsplan']);
Route::get('LogisticsInsertMapRoute/{routingId}/{ot}/{route}',[TabletLoadingApp::class,'LogisticsInsertMapRoute']);
Route::get('createtripsheet', [TabletLoadingApp::class,'createtripsheet']);
Route::get('createtripsheetnotes', [TabletLoadingApp::class,'createtripsheetnotes']);
Route::post('getRoutingIdNotes',[TabletLoadingApp::class,'getRoutingIdNotes']);
Route::post('saveRoutingIdNotes', [TabletLoadingApp::class,'saveRoutingIdNotes']);
Route::get('routePlannerExtParam/{date}/{ordertype}/{route}/{status}', [TabletLoadingApp::class,'routePlannerExtParam']);
Route::get('routeplannermap',[TabletLoadingApp::class,'routeplannermap']);
Route::get('geoJson',[TabletLoadingApp::class,'geoJson']);
Route::get('drone',[TabletLoadingApp::class,'drone']);
Route::get('getRouteDifference',[TabletLoadingApp::class,'getRouteDifference']);
Route::get('ordersNotONDefaultRoutes', [TabletLoadingApp::class,'ordersNotONDefaultRoutes']);
Route::get('productontheminiorderform/{orderId}',[TabletLoadingApp::class,'spTabletLoading']);
Route::get('updateTableLoadingAppProducts', [TabletLoadingApp::class,'updateTableLoadingAppProducts']);
Route::post('sequencingTheStops', [TabletLoadingApp::class,'sequencingTheStops']);
Route::post('orderDetailsWithDeliveryAddress', [TabletLoadingApp::class,'orderDetailsWithDeliveryAddress']);
Route::post('orderDetailsWithDeliveryAddressOnOrder',[TabletLoadingApp::class,'orderDetailsWithDeliveryAddressOnOrder'] );
Route::post('forceinvoicetoprint', [TabletLoadingApp::class,'forceinvoicetoprint']);
Route::post('updateIQInvoices',[TabletLoadingApp::class,'updateIQInvoices']);
Route::post('forcecredits',[TabletLoadingApp::class,'forcecredits']);
Route::post('combineroutes',[TabletLoadingApp::class,'combineroutes']);
Route::get('creditNoteReasonsJSonWithBook/{dateFrom}/{dateTo}',[TabletLoadingApp::class,'creditNoteReasonsJSonWithBook']);
Route::get('ordermapvisualisation/{route}/{otype}/{deldate}',[TabletLoadingApp::class,'ordermapvisualisation']);
Route::post('ordervisualjson',[TabletLoadingApp::class,'ordervisualjson']);
Route::get('getShortLoadedReport',[TabletLoadingApp::class,'getShortLoadedReport']);
Route::get('getDriverBIReport',[TabletLoadingApp::class,'getDriverBIReport']);
Route::get('driverbireportget',[TabletLoadingApp::class,'driverbireportget']);
Route::get('jsonshortloadedreport',[TabletLoadingApp::class,'jsonshortloadedreport']);
Route::get('pickingslipsbydep',[TabletLoadingApp::class,'pickingslipsbydep']);
Route::post('getPickingSlipbyDeptInfo', [TabletLoadingApp::class,'getPickingSlipbyDeptInfo']);
Route::post('printselectedCustomers', [TabletLoadingApp::class,'printselectedCustomers']);
Route::get('routePlannerExtParamdrivers/{date}/{ordertype}/{route}/{status}', [TabletLoadingApp::class,'routePlannerExtParamDrivers']);

//TABLET LOADING APP ENDS HERE !!!

//PRODUCT CONTROLLER STARTS HERE!!!
Route::get('viewproductbydate', [ProductsController::class,'viewproductbydate']);
Route::get('devexpressproducts', [ProductsController::class,'devExpressProductsgrid']);
Route::get('listProdutsToBePrinted', [ProductsController::class,'listProdutsToBePrinted']);
Route::get('listProdutsToBePrintedJson', [ProductsController::class,'listProdutsToBePrintedJson']);
Route::get('getQrcode', [ProductsController::class,'getQrcode']);
Route::get('productbydatejson/{date1}/{date2}/{productId}', [ProductsController::class,'productbydatejson']);

Route::get('gridEditViewProducts', [ProductsController::class,'gridEditViewProducts']);
Route::get('selectPricelists', [ProductsController::class,'selectPricelists']);
Route::post('getPriceListUsed', [ProductsController::class,'getPriceListUsed']);
Route::get('getListPriceListPrices/{id}/{pricelistusedid}',[ProductsController::class,'getListPriceListPrices']);
Route::get('createnewpricelist/{newname}/{pricelistcopyfrom}/{groups}/{gp}/{effectivedate}',[ProductsController::class,'createnewpricelist']);
Route::post('postupdatepricelistinfo', [ProductsController::class,'postupdatepricelistinfo']);
Route::get('createpricelist',[ProductsController::class,'createpricelist']);
Route::get('getPriceListTemplate', [ProductsController::class,'getPriceListTemplate']);
Route::get('importexcelpricelist',[ProductsController::class,'importexcelpricelist']);
Route::get('getPricelistNamesAndViewInBulk', [ProductsController::class,'getPricelistNamesAndViewInBulk']);
Route::get('getBulkPriceLists',[ProductsController::class,'getBulkPriceLists']);
Route::get('extraProdInfoView/{prodid}/{code}',[ProductsController::class,'extraProdInfoView']);
Route::get('crowdpromotion',[ProductsController::class,'crowdpromotion']);
Route::get('updateproductsummary',[ProductsController::class,'updateproductsummary']);
Route::get('productdevexpress',[ProductsController::class,'productdevexpress']);
Route::get('getPickingTeams',[ProductsController::class,'getPickingTeams']);
Route::post('printbarcode', [ProductsController::class,'printbarcode']);
Route::post('sendstickerstoprinter', [ProductsController::class,'sendstickerstoprinter']);
Route::get('printPriceList',[ProductsController::class,'printPriceList']);
Route::get('printstickers',[ProductsController::class,'PrintProductBarcodeStickers']);
Route::get('viewlabelstickerstoprint', [ProductsController::class,'viewlabelstickerstoprint']);
Route::get('listChangedProducts/{dateFrom}/{dateTo}/{PriceList}',[ProductsController::class,'listChangedProducts']);
Route::post('printbulklabels',[ProductsController::class,'printbulklabels'] );
Route::post('printbulklabelsbyPricelist',[ProductsController::class,'printbulklabelsbyPricelist']);
Route::get('bulkgridforlabels', [ProductsController::class,'bulkgridforlabels']);
Route::get('getproductextrainformation/{prductId}',[ProductsController::class,'getproductextrainformation']);
Route::post('updategridproductsAndTeams',[ProductsController::class,'updategridproductsAndTeams']);
Route::post('savedatafromimport', [ProductsController::class,'savedatafromimport']);
Route::get('itemsOutOfStockBeforePicking',[ProductsController::class,'itemsOutOfStockBeforePicking']);
Route::get('getViewItemsOutOfStock', [ProductsController::class,'getViewItemsOutOfStock']);
Route::get('getProductsAndPrices', [ProductsController::class,'getProductsAndPrices']);
Route::post('printAllBarcode', [ProductsController::class,'printAllBarcode']);
//PRODUCT CONTROLLER ENDS HERE!!!

//SALES QUOTE CONTROLLER STARTS HERE !!!
Route::get('salesquote',[SalesQuotes::class,'salesquote']);
Route::post('generateSalesQuote', [SalesQuotes::class,'generateSalesQuote']);
Route::post('createQuotesHeader',[SalesQuotes::class,'createQuotesHeader']);
Route::post('previewSaleQuotes',[SalesQuotes::class,'previewSaleQuotes']);
Route::post('viewSalesQuotes',[SalesQuotes::class,'viewSalesQuotes']);
Route::post('viewSalesQuotesConverted', [SalesQuotes::class,'viewSalesQuotesConverted']);
Route::post('startConvertingQuoteToOrder',[SalesQuotes::class,'startConvertingQuoteToOrder']);
Route::get('printTheQuote/{quoteId}', [SalesQuotes::class,'printTheQuote']);

//SALES QUOTE CONTROLLER ENDS HERE !!!

//EMAIL CONTROLLER STARTS HERE !!!
Route::post('email', [EmailController::class,'email']);
Route::post('emailSalesOrder', [EmailController::class,'emailSalesOrder']);

//EMAIL CONTROLLER ENDS HERE !!!


//DIMS REPORTS CONTROLLER STARTS HERE !!!
Route::get('reports', [DimsReports::class,'reports']);
Route::get('getuseractionsBydate', [DimsReports::class,'getuseractionsBydate']);
Route::get('getAwaitingStock', [DimsReports::class,'getAwaitingStock']);
Route::get('getAwaitingStockbycustomer', [DimsReports::class,'getAwaitingStockbycustomer']);
Route::get('jsonawaitingstockorders', [DimsReports::class,'jsonawaitingstockorders']);
Route::get('jsonuseractionsbydate', [DimsReports::class,'jsonuseractionsbydate']);
Route::get('jsonawaitingstockorderlistbycustomer', [DimsReports::class,'jsonawaitingstockorderlistbycustomer']);
Route::get('jsonawaitingstock', [DimsReports::class,'jsonawaitingstock']);
Route::post('backordersandawaiting', [DimsReports::class,'backordersandawaiting']);
Route::get('LoadLogs/{routingId}',[DimsReports::class,'LoadLogs']);
Route::post('updateReviewedStatus',[DimsReports::class,'updateReviewedStatus']);
Route::get('outstandingDriversCashoff', [DimsReports::class,'outstandingDriversCashoff']);
Route::get('getreportLayout',[DimsReports::class,'getreportLayout']);
Route::get('getreportAuthBelowMargin',[DimsReports::class,'getreportAuthBelowMargin']);
Route::get('getJsonAuthBelowMargin/{dateFrom}/{dateTo}', [DimsReports::class,'getJsonAuthBelowMargin']);
Route::get('getOrderPlacedAfterCutOff',[DimsReports::class,'getOrderPlacedAfterCutOff']);
Route::get('getJsonCutOffTime/{dateFrom}',[DimsReports::class,'getJsonCutOffTime']);
Route::get('dshb', [DimsReports::class,'dashboardSalesPerformance']);
Route::post('getPickingTeamsByDept', [DimsReports::class,'getPickingTeamsByDept']);
Route::post('getPickingTeamsByDeptPalladium',[DimsReports::class,'getPickingTeamsByDeptPalladium'] );
Route::get('getPickingDept', [DimsReports::class,'getPickingDept']);
Route::get('getPickingDeptPalladium',[DimsReports::class,'getPickingDeptPalladium']);
Route::get('printQuatation', [DimsReports::class,'quotationLayout']);
Route::get('showTripSheets', [DimsReports::class,'showTripSheets']);
Route::get('getTripSheetDetails/{routingId}',[DimsReports::class,'getTripSheetDetails']);
Route::get('reprintTripSheet/{routingId}',[DimsReports::class,'reprintTripSheet']);
Route::post('authorisationActions',[DimsReports::class,'Authorised']);
Route::post('getDayTripSheetList',[DimsReports::class,'getDayTripSheetList']);
Route::get('bulpickingPerRoutePreview/{pickingid}',[DimsReports::class,'bulpickingPerRoutePreview']);
Route::get('pickingbyteam/{array}/{deldate}/{ordertype}/{routeId}',[DimsReports::class,'pickingbyteam']);
Route::post('fetchData', [DimsReports::class,'fetchData']);
Route::post('selectBulkPickingHeader',[DimsReports::class,'selectBulkPickingHeader']);
Route::post('selectBulkBatchPickingHeader', [DimsReports::class,'selectBulkBatchPickingHeader']);
Route::post('createBulkpicking', [DimsReports::class,'createBulkpicking']);
Route::get('slackUser/{oType}/{route}/{Ddate}', [DimsReports::class,'slackUser']);
Route::post('getBinLocationByPickingTimes',[DimsReports::class,'getBinLocationByPickingTimes'] );
Route::post('gridResult',[DimsReports::class,'gridResult']);
Route::post('gridResultPalladium',[DimsReports::class,'gridResultPalladium']);
Route::get('top30Orders', [DimsReports::class,'top30Orders']);
Route::get('creditNoteReasonsView',[DimsReports::class,'creditNoteReasonsView'] );
Route::get('pickingmain', [DimsReports::class,'pickingSlipManue']);
Route::get('rptToSeeInTockVsOrders', [DimsReports::class,'rptToSeeInTockVsOrders']);
Route::get('getJsonSrockVsOrdered/{date1}/{date2}/{percentage}',[DimsReports::class,'getJsonSrockVsOrdered']);
Route::post('topOrdersOfACustomer',[DimsReports::class,'topOrdersOfACustomer']);
Route::post('contactDetailsOnOrder', [DimsReports::class,'contactDetailsOnOrder']);
Route::get('pricelistview', [DimsReports::class,'pricelistview']);
Route::get('getProductsMappedToThePriceList', [DimsReports::class,'getProductsMappedToThePriceList']);
Route::get('exportorder/{orderid}',[DimsReports::class,'exportorder'] );
Route::get('exportRoutePlanDetails/{routeid}/{deliverydatefrom}/{deliverydateto}/{ordertype}/{status}',[DimsReports::class,'exportRoutePlanDetails']);

//DIMS REPORTS CONTROLLER ENDS HERE !!!

//LOADING APP API CONTROLLER STARTS HERE !!!
Route::get('sendMessages', [LoadingAppAPIs::class,'sendMessages']);
Route::get('sendMessageJson',[LoadingAppAPIs::class,'sendMessageJson']);
Route::get('sendMessagePicking',[LoadingAppAPIs::class,'sendMessagePicking']);
Route::get('batchPrinting',[LoadingAppAPIs::class,'batchPrinting']);
Route::post('stockApi', [LoadingAppAPIs::class,'stockApi']);
Route::get('slack', [LoadingAppAPIs::class,'slack']);

//LOADING APP API CONTROLLER ENDS  HERE !!!

//PALLADIUMDIMSSTATUS CONTROLLER STARTS HERE !!!

Route::get('salesHeaderExported', [PalladiumDimsStatus::class,'salesHeaderExported']);
Route::post('updateSalesHeaderExportedStatus',[PalladiumDimsStatus::class,'updateSalesHeaderExportedStatus']);

//PALLADIUMDIMSSTATUS CONTROLLER ENDS HERE !!!

//CALL LIST CONTROLLER STARTS HERE !!!
Route::get('callist', [CallList::class,'index']);
Route::get('getViewCallLogger',[CallList::class,'getViewCallLoger']);
Route::get('callLogger',[CallList::class,'callLogger']);
Route::get('getphonebook', [CallList::class,'getPhoneBook']);
Route::get('savephonebook',[CallList::class,'savephonebook']);
Route::get('removePhoneBookContact',[CallList::class,'removePhoneBookContact']);
Route::get('customerphonebookcontacts',[CallList::class,'customerphonebookcontacts']);
Route::get('luck/{date}/{ext}/{file}',[CallList::class,'luck']);

//CALL LIST CONTROLLER ENDS HERE !!!


//CONFIGURATIONMANGER CONTROLLER STARTS HERE !!!

Route::get('..config',[ConfigurationManger::class,'index']);
Route::post('editconfig', [ConfigurationManger::class,'editconfig']);

//CONFIGURATIONMANGER CONTROLLER ENDS HERE !!!

// PICKING MANAGEMENT COTROLLER CONTROLLER STARTS HERE !!!
Route::get('gridPickingSlipCollectios', [PickingManagementCotroller::class,'gridPickingSlipCollectios']);
Route::post('updateiscollected', [PickingManagementCotroller::class,'updateiscollected']);
Route::post('reprintPickingSlip',[PickingManagementCotroller::class,'reprintPickingSlip']);

// PICKING MANAGEMENT COTROLLER CONTROLLER ENDS HERE !!!

/**********************************************************CRUD****************************************************************/

//DRIVERSCONTROLLER CONTROLLER BEGINS HERE !!!
Route::get('driverspage', [DriversController::class,'readItems']);
Route::get('deliveryaddresspage',[DriversController::class,'deliveryaddresspage']);
Route::post('updateDeliveryAddressesGrid',[DriversController::class,'updateDeliveryAddressesGrid']);
Route::get('getRoutingIds', [DriversController::class,'getRoutingIds']);
Route::get('printDriversCashOff/{ref}', [DriversController::class,'printDriversCashOff']);
Route::get('creditRequisitionByRoutingId/{routingId}',[DriversController::class,'creditRequisitionByRoutingId']);
Route::get('getdriverscashoff',[DriversController::class,'getdriverscashoff']);
Route::get('CreditDeptComment/{orderdetailid}',[DriversController::class,'CreditDeptComment']);
Route::post('CreditDeptCommentUpdate',[DriversController::class,'CreditDeptCommentUpdate']);
Route::post('getDriversCashOffJson',[DriversController::class,'getDriversCashOffJson']);
Route::post('exportCashOff', [DriversController::class,'exportCashOff']);
Route::post('postDriversCashOff',[DriversController::class,'postDriversCashOff']);
Route::post('invoicessignedaroundpremises',[DriversController::class,'invoicessignedaroundpremises']);
Route::post('createnewsheet',[DriversController::class,'createnewsheet']);
Route::get('LiveDriverStops',[DriversController::class,'LiveDriverStops']);
Route::post('/addItem', [DriversController::class,'addItem']);
Route::post('/editItem', [DriversController::class,'editItem']);
Route::post('/deleteItem', [DriversController::class,'deleteItem']);
Route::get('trucks', [DriversController::class,'readTrucksItems']);
Route::post('/addTrucksItem',[DriversController::class,'addTrucksItem']);
Route::post('/editTrucksItem', [DriversController::class,'editTrucksItem']);
Route::post('/deleteTrucksItem',[DriversController::class,'deleteTrucksItem']);
Route::get('routes1',[DriversController::class,'readRoutesItems']);
Route::post('/addRoutesItem', [DriversController::class,'addRoutesItem']);
Route::post('/editRoutesItem',[DriversController::class,'editRoutesItem']);
Route::post('/deleteRoutesItem',[DriversController::class,'deleteRoutesItem']);
Route::get('glcodes', [DriversController::class,'readGLCode']);
Route::get('driversperformancereport', [DriversController::class,'driversperformancereport']);
Route::get('getdriversandinfo/{date1}/{date2}', [DriversController::class,'getdriversandinfo']);
Route::get('getNoOfDelPerCustomer/{date1}/{date2}',[DriversController::class,'getNoOfDelPerCustomer']);
Route::get('driverspdfdocs',[DriversController::class,'driverspdfdocs']);
Route::get('cashupscheckinvoice/{invoice}', [DriversController::class,'cashupscheckinvoice']);
Route::post('postcashupscheckinvoice', [DriversController::class,'postcashupscheckinvoice']);
Route::get('noOfStops', [DriversController::class,'noOfStops']);
Route::get('getCashCollected',[DriversController::class,'getCashCollected']);
Route::get('cashCollectedReport/{dateFrom}/{dateTo}',[DriversController::class,'cashCollectedReport']);
Route::post('driverspdfdocsByInv', [DriversController::class,'driverspdfdocsByInv']);
Route::post('postPODSToTheAccounting',[DriversController::class,'postPODSToTheAccounting']);
Route::post('driverspdfdocsByInvsubinfo',[DriversController::class,'driverspdfdocsByInvsubinfo']);
Route::post('driverspdfdocsBytripsheet',[DriversController::class,'driverspdfdocsBytripsheet']);
Route::post('driverpdfdocrequisition',[DriversController::class,'driverpdfdocrequisition'] );
Route::post('isCheckedCashUp',[DriversController::class,'isCheckedCashUp']);
Route::post('/addGLCode', [DriversController::class,'addGLCode']);
Route::post('/editGLCode', [DriversController::class,'editGLCode']);
Route::post('/deleteGLCode',[DriversController::class,'deleteGLCode']);
Route::get('checkingDriversStockAndComment/{orderdetailId}', [DriversController::class,'checkingDriversStockAndComment']);
Route::post('updatereturndispatchmessage',[DriversController::class,'updatereturndispatchmessage']);
Route::post('getResendEmailJson',[DriversController::class,'getResendEmailJson']);
Route::get('getResendEmail', [DriversController::class,'getResendEmail']);
Route::post('postResendEmailJson',[DriversController::class,'postResendEmailJson']);

//DRIVERSCONTROLLER CONTROLLER ENDS HERE !!!

//USERS CONTROLLER CONTROLLER STARTS HERE !!!retrieve
Route::get('usersCrud', [UsersController::class,'readUser']);
Route::get('viewUserRole',[UsersController::class,'viewUserRole'] );
Route::post('systemrolesandgrouproles',[UsersController::class,'systemrolesandgrouproles'] );
Route::post('updateremoverole',[UsersController::class,'updateremoverole'] );
Route::get('salesPerformanceview', [UsersController::class,'salesPerformanceview']);
Route::get('userorders/{from}/{to}/{userid}/{username}', [UsersController::class,'userorders']);
Route::get('userorderslines/{orderid}', [UsersController::class,'userorderslines']);
Route::get('getUserOrders/{from}/{to}/{user}', [UsersController::class,'getUserOrders']);
Route::get('gridCustomermanagement/{users}/{routes}', [UsersController::class,'gridCustomermanagement']);
Route::get('salesPerformance/{datefrom}/{dateTo}', [UsersController::class,'salesPerformance']);
Route::post('/addUser', [UsersController::class,'addUser']);
Route::post('updategridroutes', [UsersController::class,'updategridroutes']);
Route::post('/editUser',[UsersController::class,'editUser'] );
Route::post('/deleteUser', [UsersController::class,'deleteUser']);
Route::get('grid_Users',[UsersController::class,'gridUsers']);
Route::get('jsonGetUsers',[UsersController::class,'jsonGetUsers']);
Route::post('updateUsers',[UsersController::class,'updateUsers']);
Route::post('updateuserpassword',[UsersController::class,'updateuserpassword']);
Route::post('updateuserinfo',[UsersController::class,'updateuserinfo']);
Route::get('PathEditor', [UsersController::class,'PathsAndEmails']);
Route::post('editUsers',[UsersController::class,'editUsers'] );

//USERS CONTROLLER CONTROLLER ENDS HERE !!!

//CONTROLPANEL CONTROLLER STARTS HERE !!!
Route::get('ordertypes',[ControlPanelController::class,'readOrderType'] );
Route::post('/addOrderType',[ControlPanelController::class,'addOrderType'] );
Route::post('/editOrderType', [ControlPanelController::class,'editOrderType']);
Route::post('/deleteOrderType',[ControlPanelController::class,'deleteOrderType'] );
Route::get('brands', [ControlPanelController::class,'readBrand']);
Route::post('/addBrand', [ControlPanelController::class,'addBrand']);
Route::post('/editBrand', [ControlPanelController::class,'editBrand']);
Route::post('/deleteBrand', [ControlPanelController::class,'deleteBrand']);
Route::get('groups',[ControlPanelController::class,'readGroup'] );
Route::post('/addGroup', [ControlPanelController::class,'addGroup']);
Route::post('/editGroup',[ControlPanelController::class,'editGroup'] );
Route::post('/deleteGroup',[ControlPanelController::class,'deleteGroup'] );
Route::get('taxes',[ControlPanelController::class,'readTax']);
Route::post('/addTax', [ControlPanelController::class,'addTax']);
Route::post('/editTax', [ControlPanelController::class,'editTax']);
Route::post('/deleteTax', [ControlPanelController::class,'deleteTax']);
Route::get('pickingteam',[ControlPanelController::class,'readPickingTeam'] );
Route::post('/addPickingTeam', [ControlPanelController::class,'addPickingTeam']);
Route::post('/editPickingTeam',[ControlPanelController::class,'editPickingTeam'] );
Route::post('/deletePickingTeam', [ControlPanelController::class,'deletePickingTeam']);
Route::get('groupbrands',[ControlPanelController::class,'readGroupBrand'] );
Route::post('/addGroupBrand', [ControlPanelController::class,'addGroupBrand']);
Route::post('/editGroupBrand', [ControlPanelController::class,'editGroupBrand']);
Route::post('/deleteGroupBrand',[ControlPanelController::class,'deleteGroupBrand'] );

//CONTROLPANEL CONTROLLER ENDS  HERE !!!

/**********************************************************APPS**************************************************************************************/

//JASPERREPORTS CONTROLLER STARTS HERE !!!
Route::get('testJaspr/{id}', [JasperReports::class,'testJaspr'] );
Route::get('CashOffPDF/{ref}/{type}',[JasperReports::class,'CashOffPDF']  );
Route::get('specialnsJasper/{id}/{dateFrom}/{dateTo}', [JasperReports::class,'specialnsJasper'] );
Route::get('pdforder/{id}',[JasperReports::class,'PDFOrders']  );
Route::get('getOrderLines',[JasperReports::class,'getOrderLines']  );
Route::get('getOrderLinesDeliveryNote',[JasperReports::class,'getOrderLinesDeliveryNote']);
Route::get('pdfpricelist/{id}',[JasperReports::class,'PDFPricelist']  );
Route::get('bulkpickingslip/{id}',[JasperReports::class,'bulkpickingslip']  );
Route::get('PDFDelDate/{id}',[JasperReports::class,'PDFDelDate'] );
Route::get('overallSpecailJasper/{datefrom}/{dateto}',[JasperReports::class,'overallSpecailJasper']  );
Route::get('excelorders/{id}',[JasperReports::class,'EXCELOrders']  );
Route::get('groupSpecailJasper/{datefrom}/{dateto}/{groupid}',[JasperReports::class,'groupSpecailJasper']  );
Route::get('compilereports',[JasperReports::class,'compileExample']  );
Route::get('FreshOrders',[JasperReports::class,'FreshOrders']  );

//JASPERREPORTS CONTROLLER ENDS HERE !!!

//DEALSFROMTHEAPP CONTROLLER STARTS HERE !!!
Route::get('getDeals', [DealsFromTheApp::class,'getDealsNotYetApproved'] );
Route::get('approveadeal/{token}',[DealsFromTheApp::class,'approveADeal']  );
Route::get('rejectadeal/{token}', [DealsFromTheApp::class,'rejectADeal'] );
Route::get('approveddeal',[DealsFromTheApp::class,'approvedDeals']  );
Route::get('rejecteddeal',[DealsFromTheApp::class,'rejectedDeals']  );

//DEALSFROMTHEAPP CONTROLLER ENDS HERE !!!

//EXTERNAL FUNCTIONS  STARTS HERE !!!
Route::get('briefcaseDamages',[ExternalFunctions::class,'briefcaseDamages'] );
Route::get('getTransfers',[ExternalFunctions::class,'getTransfers'] );
Route::get('getInvoices/{customercode}/{from}/{to}',[ExternalFunctions::class,'getInvoices'] );
Route::get('transferblade',[ExternalFunctions::class,'transferblade'] );
Route::get('getTransfersJson/{date}/{dateTo}',[ExternalFunctions::class,'getTransfersJson'] );
Route::post('openorderdetailsformergedtransfers',[ExternalFunctions::class,'openorderdetailsformergedtransfers']);
Route::get('getTransfersJsonbydate/{date}', [ExternalFunctions::class,'getTransfersJsonbydate']);
Route::post('updateCheckedOrNotTrasfers',[ExternalFunctions::class,'updateCheckedOrNotTrasfers'] );
Route::post('checkUnCheckTransfers',[ExternalFunctions::class,'checkUnCheckTransfers'] );
Route::get('getWebstoreCustomers', [ExternalFunctions::class,'getWebstoreCustomers']);
Route::get('officemap', [ExternalFunctions::class,'officemap']);
Route::get('getWebstoreFile',[ExternalFunctions::class,'getWebstoreFile'] );
Route::get('brifcaseCustomerEdits',[ExternalFunctions::class,'brifcaseCustomerEdits'] );
Route::get('synchProducts', [ExternalFunctions::class,'synchProducts']);
Route::get('testWebstoreSpeed',[ExternalFunctions::class,'testWebstoreSpeed'] );
Route::get('damageshistory',[ExternalFunctions::class,'damageshistory'] );
Route::get('transfersstatus', [ExternalFunctions::class,'transfersstatus']);
Route::get('print_damages/{id}',[ExternalFunctions::class,'printDamages'] );
Route::get('process_damage/{id}',[ExternalFunctions::class,'processDamage'] );
Route::post('getDamgedLines', [ExternalFunctions::class,'getDamgedLines']);
Route::post('updatevisits', [ExternalFunctions::class,'updatevisits']);
Route::post('getDamagesHistoryHeader',[ExternalFunctions::class,'getDamagesHistoryHeader'] );
Route::post('updateWebstoremasterFileInfo',[ExternalFunctions::class,'updateWebstoremasterFileInfo'] );
Route::post('deleteDamagedLine',[ExternalFunctions::class,'deleteDamagedLine'] );
Route::post('saveupdateasset',[ExternalFunctions::class,'saveupdateasset'] );
Route::get('viewVisits',[ExternalFunctions::class,'viewVisits'] );
Route::get('viewDeals',[ExternalFunctions::class,'viewDeals'] );
Route::get('assets',[ExternalFunctions::class,'assets'] );
Route::get('crudasset/{id}',[ExternalFunctions::class,'crudasset'] );
Route::get('missedvisit', [ExternalFunctions::class,'viewMissedVisit']);
Route::get('notVisitedView',[ExternalFunctions::class,'notVisitedView'] );
Route::get('visitsdates/{datefrom}/{dateto}',[ExternalFunctions::class,'visitsdates'] );
Route::get('dealsdates/{datefrom}/{dateto}',[ExternalFunctions::class,'dealsdates'] );
Route::get('webstore', [ExternalFunctions::class,'webstore']);
Route::post('synchwebstore', [ExternalFunctions::class,'synchwebstore']);
Route::post('syncproducts', [ExternalFunctions::class,'syncproducts']);
Route::post('syncpricelistPrices',[ExternalFunctions::class,'syncpricelistPrices'] );
Route::post('syncpricelistStock',[ExternalFunctions::class,'syncpricelistStock'] );
Route::post('syncoverallspecials',[ExternalFunctions::class,'syncoverallspecials'] );
Route::post('synccustomers',[ExternalFunctions::class,'synccustomers'] );
Route::post('syncorderpattern',[ExternalFunctions::class,'syncorderpattern'] );
Route::post('syncpricelist', [ExternalFunctions::class,'syncpricelist']);
Route::post('syncgroupspecials',[ExternalFunctions::class,'syncgroupspecials'] );
Route::post('synccustomerspecials',[ExternalFunctions::class,'synccustomerspecials'] );
Route::get('restFullInvoices/{month}/{year}/{custcode}', [ExternalFunctions::class,'restFullInvoices']);
Route::get('returnPDF/{invoicenumber}',[ExternalFunctions::class,'returnPDF'] );
Route::get('visitsLog/{date1}/{date2}',[ExternalFunctions::class,'visitsLog'] );
Route::get('notVisitedLog/{date1}/{date2}',[ExternalFunctions::class,'notVisitedLog'] );
// EXTERNAL FUNCTIONS ENDS HERE !!!


//ONLINE ORDERS STARTS HERE!!!
Route::get('remoteorders',[OnlineOrders::class,'remoteorders'] );
Route::get('mymarketGetSales',[OnlineOrders::class,'mymarketGetSales'] );
Route::post('getMymarketOrdersToDealWith',[OnlineOrders::class,'getMymarketOrdersToDealWith'] );
Route::get('viewMyMarketOrders',[OnlineOrders::class,'viewMyMarketOrders'] );
Route::get('orderScreening', [OnlineOrders::class,'orderScreening']);
Route::post('testAPI',[OnlineOrders::class,'testAPI'] );
Route::post('deleteRemoteOrder', [OnlineOrders::class,'deleteRemoteOrder']);
Route::post('updateOnlineLinesAndHeaders',[OnlineOrders::class,'updateOnlineLinesAndHeaders'] );
Route::get('outstandingorders', [OnlineOrders::class,'outstandingorders']);
Route::get('onlineOrderHistory/{date1}/{date2}', [OnlineOrders::class,'onlineOrderHistory']);
Route::get('getFreshOrderHeadersOutstanding', [OnlineOrders::class,'getFreshOrderHeadersOutstanding']);
Route::post('Xmlcommitremoteorder',[OnlineOrders::class,'Xmlcommitremoteorder']);
Route::get('getFreshOrderHeaders ',[OnlineOrders::class,'getFreshOrderHeaders']);
Route::get('getOrderLines/{id}',[OnlineOrders::class,'getOrderLines']);
Route::get('getNewDealToAuth/{id}',[OnlineOrders::class,'getNewDealToAuth']);
Route::post('postauthdeal',[OnlineOrders::class,'postauthdeal']);
Route::post('postMyMarketOrders',[OnlineOrders::class,'postMyMarketOrders']);
Route::post('UpdateOrderStatus',[OnlineOrders::class,'UpdateOrderStatus']);
Route::get('UpdateOrderStatusmanually/{orderid}',[OnlineOrders::class,'UpdateOrderStatusmanually']);

//ONLINE ORDERS ENDS HERE!!!

//ONLINE ORDERS RECON CONTROLLER STARTS HERE !!!

Route::get('returnRefunds', [OnlineOrdersReconController::class,'returnRefunds']);
Route::get('viewRefunds', [OnlineOrdersReconController::class,'viewRefunds']);

//ONLINE ORDERS RECON CONTROLLER ENDS HERE !!!

/******************************************BACK ORDERS**********************************************************************************/
//BACK ORDERCONTROLLER CONTROLLER STARTS HERE
Route::get('remoteordersbackorders', [BackOrderController::class,'remoteordersbackorders']);
Route::post('testAPIbackorders',[BackOrderController::class,'testAPIbackorders'] );
Route::post('deleteRemoteOrderbackorders',[BackOrderController::class,'deleteRemoteOrderbackorders'] );
Route::post('updateOnlineLinesAndHeadersbackorder', [BackOrderController::class,'updateOnlineLinesAndHeadersbackorder']);
Route::get('outstandingordersbackorder', [BackOrderController::class,'outstandingordersbackorder']);
Route::get('onlineOrderHistorybackorder/{date1}/{date2}',[BackOrderController::class,'onlineOrderHistorybackorder'] );
Route::get('getFreshOrderHeadersOutstandingbackorder',[BackOrderController::class,'getFreshOrderHeadersOutstandingbackorder'] );
Route::post('Xmlcommitremoteorderbackorder',[BackOrderController::class,'Xmlcommitremoteorderbackorder'] );
Route::get('getFreshOrderHeadersbackorder',[BackOrderController::class,'getFreshOrderHeadersbackorder'] );
Route::get('getNoStockItem',[BackOrderController::class,'getNoStockItem']);
Route::get('getItemWithNoStock',[BackOrderController::class,'getItemWithNoStock'] );
Route::get('getOrderLinesbackorder/{id}',[BackOrderController::class,'getOrderLinesbackorder'] );
Route::get('getNewDealToAuthbackorder/{id}',[BackOrderController::class,'getNewDealToAuthbackorder'] );
Route::post('postauthdealbackorder', [BackOrderController::class,'postauthdealbackorder']);
Route::get('productsonbackorderjson',[BackOrderController::class,'productsonbackorderjson'] );
Route::get('productsOnBackOrders',[BackOrderController::class,'productsOnBackOrders'] );
Route::get('getBriefcaseBackorderHeaders',[BackOrderController::class,'getBriefcaseBackorderHeaders'] );
Route::get('getBriefcaseBackorderLines',[BackOrderController::class,'getBriefcaseBackorderLines'] );
Route::post('commitBackOrdersToDims',[BackOrderController::class,'commitBackOrdersToDims'] );
Route::get('getcommitedlogs',[BackOrderController::class,'getcommitedlogs'] );
Route::get('markbackordertobeawaitingstock',[BackOrderController::class,'markbackordertobeawaitingstock'] );

//BACK ORDERCONTROLLER CONTROLLER ENDS HERE
/********************************************************END **************************************************************************/



//WAREHOUSECONTROLLER CONTROLLER STARTS HERE !!!
Route::get('warehouseitems', [WareHouseController::class,'warehouseInvetoryItems']);
Route::get('onOrderAdvanced', [WareHouseController::class,'onOrderAdvanced']);


//WareHouseManagementController
Route::get('productscats', [WareHouseManagementController::class,'productscats']);
Route::get('productsgrid', [WareHouseManagementController::class,'productsgrid']);
Route::get('getProductgriddata', [WareHouseManagementController::class,'getProductgriddata']);
Route::post('postProductInfo',[WareHouseManagementController::class,'postProductInfo']);
Route::get('getProductsnames/{cat}', [WareHouseManagementController::class,'getProductsnames']);
Route::get('recordbarcode/{code}', [WareHouseManagementController::class,'recordbarcode']);
Route::post('savebarcode', [WareHouseManagementController::class,'savebarcode']);
Route::get('stocksheetforstocktake', [WareHouseManagementController::class,'stocksheetforstocktake']);
Route::get('stocksheetforstocktakejson', [WareHouseManagementController::class,'stocksheetforstocktakejson']);
Route::post('stocksheetforstocktakexml', [WareHouseManagementController::class,'stocksheetforstocktakexml']);

Route::get('reprinting',[WareHouseManagementController::class,'reprintingInvoicesPage']);
Route::post('reprintPrintedInvoicesParameters',[WareHouseManagementController::class,'reprintPrintedInvoicesParameters']);
Route::get('stockmover', [WareHouseManagementController::class,'stockmover']);
Route::get('getwarehouseinventorygrid', [WareHouseManagementController::class,'getwarehouseinventorygrid']);
Route::get('jsonWarehouseGrid', [WareHouseManagementController::class,'jsonWarehouseGrid']);
Route::get('scanshelffrom', [WareHouseManagementController::class,'scanshelffrom']);
Route::post('goscanproductfrom', [WareHouseManagementController::class,'goscanproductfrom']);
Route::post('goscanshelfto', [WareHouseManagementController::class,'goscanshelfto']);
Route::post('goscanproductto', [WareHouseManagementController::class,'goscanproductto']);
Route::post('gofinish', [WareHouseManagementController::class,'gofinish']);
Route::get('getbininfo', [WareHouseManagementController::class,'getbininfo']);
Route::get('jsonbininfoGrid', [WareHouseManagementController::class,'jsonbininfoGrid']);
Route::get('jsonGetProductsInTheBin', [WareHouseManagementController::class,'jsonGetProductsInTheBin']);
Route::get('bininfoGridProducts', [WareHouseManagementController::class,'bininfoGridProducts']);
Route::get('jsonbininfoGridProducts', [WareHouseManagementController::class,'jsonbininfoGridProducts']);
Route::get('binlocatons', [WareHouseManagementController::class,'binlocatons']);
Route::get('seewhatscountedjson', [WareHouseManagementController::class,'seewhatscountedjson']);
Route::get('seewhatscounted/{stocktakeid}', [WareHouseManagementController::class,'seewhatscounted']);
Route::get('qrcodeimage/{binlocation}', [WareHouseManagementController::class,'qrcodeimage']);
Route::get('getBinLocationsJson', [WareHouseManagementController::class,'getBinLocationsJson']);
Route::get('binandqrcodes', [WareHouseManagementController::class,'binandqrcodes']);
Route::post('savenewbin', [WareHouseManagementController::class,'savenewbin']);

Route::get('getStockTakeName',[WareHouseManagementController::class,'getStockTakeName']);
Route::get('selectStockTake',[WareHouseManagementController::class,'selectStockTake']);
Route::post('updateStockTakeOnSelector',[WareHouseManagementController::class,'updateStockTakeOnSelector']);
Route::get('stocktakegrid',[WareHouseManagementController::class,'stocktakegrid']);
Route::post('savestocktakename',[WareHouseManagementController::class,'savestocktakename']);
Route::get('getStockTakeNameLines',[WareHouseManagementController::class,'getStockTakeNameLines']);

Route::get('massProducts', [WareHouseManagementController::class,'massProducts']);
Route::get('getProductgriddata', [WareHouseManagementController::class,'getProductgriddata']);
Route::post('postProductInfo', [WareHouseManagementController::class,'postProductInfo']);
Route::get('qtyadjustmentsstagingimoveit', [WareHouseManagementController::class,'qtyadjustmentsstagingimoveit']);
Route::get('qtyadjustmentspicking', [WareHouseManagementController::class,'qtyadjustmentspicking']);
Route::get('jsonadjustmentstagingtoimoveit/{from}/{to}', [WareHouseManagementController::class,'jsonadjustmentstagingtoimoveit']);
Route::get('jsonadjustmentspicking/{from}/{to}', [WareHouseManagementController::class,'jsonadjustmentspicking']);

//WAREHOUSECONTROLLER CONTROLLER STARTS HERE !!!

//COMPANYAUTHCONTROLLER CONTROLLER STARTS HERE !!!
Route::get('getBlockedAccountToAuth', [CompanyAuthController::class,'getBlockedAccountToAuth']);
Route::get('viewBlockedAccount',[CompanyAuthController::class,'viewBlockedAccount'] );
Route::get('getSpecificOrdersBlocked/{customerId}', [CompanyAuthController::class,'getSpecificOrdersBlocked']);
Route::get('getSpecificBlockedOrdersJson/{orderid}',[CompanyAuthController::class,'getSpecificBlockedOrdersJson'] );
Route::get('getoutstandingorderstoauthjson/{orderid}', [CompanyAuthController::class,'getoutstandingorderstoauthjson']);

//COMPANYAUTHCONTROLLER CONTROLLER ENDS HERE !!!

//POS CONTROLLER STARTS HERE !!!
Route::get('viewassignuserstotill',[POS::class,'viewassignuserstotill']);
Route::post('submittillusers',[POS::class,'submittillusers'] );
Route::post('closedrawer',[POS::class,'closedrawer'] );

//POS CONTROLLER ENDS HERE !!!

//GOOGLE MAPS CONTROLLER STARTS HERE !!!

Route::get('mappage/{date}/{routeid}/{ordertype}', [GoogleMapsController::class,'mappage']);

//GOOGLE MAPS CONTROLLER STARTS HERE !!!

//IMPORT EXCEL CONTROLLER STARTS HERE !!!
Route::get('/import_excel', [ImportExcelController::class,'mappage']);
Route::post('/import_excel/import', [ImportExcelController::class,'mappage']);

//IMPORT EXCEL CONTROLLER ENDS HERE !!!

//LAYALTYPROGRAMCONTROLLER CONTROLLER STARTS HERE !!!
Route::group(['middleware' => 'auth'], function() {

    Route::get('registercards', [LayaltyProgramController::class,'MapACardToTheUsers']);
    Route::get('cardnumberlookup',[LayaltyProgramController::class,'CardNumberLookUp'] );
    Route::get('saveinfocard',[LayaltyProgramController::class,'saveinfocard'] );
    Route::get('registercardswalking', [LayaltyProgramController::class,'MapACardToTheUsersWalking']);
    Route::get('cardnumberlookupWalking',[LayaltyProgramController::class,'CardNumberLookUpWalking'] );
    Route::get('saveinfocardwalking', [LayaltyProgramController::class,'saveinfocardWalking']);
    Route::get('verifyemail', [LayaltyProgramController::class,'verifyemail']);
    Route::get('checkifIdexists',[LayaltyProgramController::class,'checkifIdexists'] );
    Route::get('routeplanner',[TabletLoadingApp::class,'routeplanner']);
    Route::get('getRouteMassOnPlanner',[TabletLoadingApp::class,'getRouteMassOnPlanner']);



});
//KERSTON SPECIAL CONTROLLER STARTS HERE !!!
Route::group(['middleware' => 'auth'], function() {

    Route::get('kerstonspecial', [KerstonSpecialController::class,'kerstonspecial']);
    Route::get('andNewSpecialKF', [KerstonSpecialController::class,'andNewSpecialKF']);
    Route::get('spItemLooKupDevXtreme', [KerstonSpecialController::class,'spItemLooKupDevXtreme']);
    Route::post('getCurrentPricesProductsCustomerSpecialsKF',[KerstonSpecialController::class,'getCurrentPricesProductsCustomerSpecialsKF']);
    Route::post('convertCurrentContractPricelist',[KerstonSpecialController::class,'convertCurrentContractPricelist']);
    Route::get('validatethecontractId', [KerstonSpecialController::class,'validatethecontractId']);
    Route::post('postCurrentHistoryCustomerSpecialsKF', [KerstonSpecialController::class,'postCurrentHistoryCustomerSpecialsKF']);
    Route::post('customerByDateOrContractSpecKF', [KerstonSpecialController::class,'customerByDateOrContractSpecKF']);
    Route::post('getContractsPerCustomerID',[KerstonSpecialController::class,'getContractsPerCustomerID']);
    Route::post('getContractsPerCustomerIDWithDates',[KerstonSpecialController::class,'getContractsPerCustomerIDWithDates']);
    Route::post('importexcel',[KerstonSpecialController::class,'importexcel']);
    Route::get('dialogtoimportspecials/{customerid}/{contractid}/{datefrom}/{dateto}',[KerstonSpecialController::class,'dialogtoimportspecials']);
    Route::get('export/{SpecialHeaderId}',[KerstonSpecialController::class,'export']);
    Route::post('convertContractPriceBulk',[KerstonSpecialController::class,'convertContractPriceBulk']);
    Route::post('getCurrentContractCustomerSpecialsKF',[KerstonSpecialController::class,'getCurrentContractCustomerSpecialsKF']);
    Route::post('XmlCreateCustomerSpecialsKFValid',[KerstonSpecialController::class,'XmlCreateCustomerSpecialsKFValid']);
    Route::post('XmlCreateCustomerSpecialsKF',[KerstonSpecialController::class,'XmlCreateCustomerSpecialsKF']);
    Route::get('searchSpecialKF',[KerstonSpecialController::class,'searchSpecialKF']);
    Route::post('getCurrentSpecialsSearch',[KerstonSpecialController::class,'getCurrentSpecialsSearch']);
    Route::get('getDuplicateProductsCS',[KerstonSpecialController::class,'getDuplicateProductsCS']);
    Route::post('getCustomerAvgQty',[KerstonSpecialController::class,'getCustomerAvgQty']);
    Route::post('copycontract',[KerstonSpecialController::class,'copycontract']);
    Route::post('getcontractDates',[KerstonSpecialController::class,'getcontractDates']);
    Route::post('createnewcustomercontract', [KerstonSpecialController::class , 'createnewcustomercontract']);
    Route::post('deletecontractlines',[KerstonSpecialController::class, 'deletecontractlines']);
    Route::post('deleteALLBasedContract',[KerstonSpecialController::class, 'deleteALLBasedContract']);

});




/***********************SalesManBriefcase**********************************************************************/
Route::group(['middleware' => 'auth'], function() {

    Route::get('landingBriefcase', [SalesManBriefcase::class,'landingBriefcase']);
    Route::get('visits', [SalesManBriefcase::class,'visits']);
    Route::get('jsonVisistsBriefcase', [SalesManBriefcase::class,'jsonVisistsBriefcase']);
    Route::get('visualvisits', [SalesManBriefcase::class,'visualvisits']);
    Route::get('getmarkerinfobriefcase', [SalesManBriefcase::class,'getmarkerinfobriefcase']);
    Route::get('customercomments', [SalesManBriefcase::class,'customercomments']);
    Route::get('jsonCustomerComments', [SalesManBriefcase::class,'jsonCustomerComments']);
    Route::get('createrandomquestions', [SalesManBriefcase::class,'createrandomquestions']);
    Route::get('saveQuestions', [SalesManBriefcase::class,'saveQuestions']);
    Route::get('getdatagraph', [SalesManBriefcase::class,'getdatagraph']);




});

//LAYALTYPROGRAMCONTROLLER CONTROLLER STARTS HERE !!!
/*************************XERO********************************/
Route::get('/manage/xero', [\App\Http\Controllers\XeroController::class, 'index'])->name('xero.auth.success');


Route::get('/xero/createInvoices', [\App\Http\Controllers\XeroController::class, 'createInvoices'])->name('xero.createInvoices');
Route::get('/xero/retrieveInvoices', [\App\Http\Controllers\XeroController::class, 'retrieveInvoices'])->name('xero.retrieveInvoices');
Route::get('/xero/retrieveInvoice', [\App\Http\Controllers\XeroController::class, 'retrieveInvoice'])->name('xero.retrieveInvoice');
Route::get('/xero/createReceipts', [\App\Http\Controllers\XeroController::class, 'createReceipts'])->name('xero.createReceipts');
Route::get('/xero/retrieveReceipts', [\App\Http\Controllers\XeroController::class, 'retrieveReceipts'])->name('xero.retrieveReceipts');
Route::get('/xero/createPurchaseOrders', [\App\Http\Controllers\XeroController::class, 'createPurchaseOrders'])->name('xero.createPurchaseOrders');
Route::get('/xero/getPurchaseOrders', [\App\Http\Controllers\XeroController::class, 'getPurchaseOrders'])->name('xero.getPurchaseOrders');
Route::get('/xero/getInvoiceAsPdf', [\App\Http\Controllers\XeroController::class, 'getInvoiceAsPdf'])->name('xero.getInvoiceAsPdf');
Route::get('/xero/createCreditNotes', [\App\Http\Controllers\XeroController::class, 'createCreditNotes'])->name('xero.createCreditNotes');
Route::get('/xero/getCreditNotes', [\App\Http\Controllers\XeroController::class, 'getCreditNotes'])->name('xero.getCreditNotes');
Route::get('/xero/getItems', [\App\Http\Controllers\XeroController::class, 'getItems'])->name('xero.getItems');


/**********HANDCRAFTED APIs*************************************************************************************************************/

Route::get('getOrderTypes',[ApisController::class,'getOrderTypes'] );
Route::get('getRoutes',[ApisController::class,'getRoutes'] );
Route::get('sendfcm',[ApisController::class,'sendFCMMessage'] );



/**************************TEST CONTROLLER*************************************/


Route::get('regTestJsonCall',[TestControllerReg::class,'regTestJsonCall'] );
