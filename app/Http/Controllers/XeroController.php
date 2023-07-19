<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Webfox\Xero\OauthCredentialManager;

class XeroController extends Controller
{

    public function index(Request $request, OauthCredentialManager $xeroCredentials)
    {
        try {
            // Check if we've got any stored credentials
            if ($xeroCredentials->exists()) {
                /* 
                 * We have stored credentials so we can resolve the AccountingApi, 
                 * If we were sure we already had some stored credentials then we could just resolve this through the controller
                 * But since we use this route for the initial authentication we cannot be sure!
                 */
                $xero             = resolve(\XeroAPI\XeroPHP\Api\AccountingApi::class);
                $organisationName = $xero->getOrganisations($xeroCredentials->getTenantId())->getOrganisations()[0]->getName();
                $user             = $xeroCredentials->getUser();
                $username         = "{$user['given_name']} {$user['family_name']} ({$user['username']})";
                
            }
        } catch (\throwable $e) {
            // This can happen if the credentials have been revoked or there is an error with the organisation (e.g. it's expired)
            $error = $e->getMessage();
        }

        return view('xero', [
            'connected'        => $xeroCredentials->exists(),
            'error'            => $error ?? null,
            'organisationName' => $organisationName ?? null,
            'username'         => $username ?? null
        ]);
    }
    

    /////////////////////////// Create New Invoice /////////////////////////

    public function createInvoices(Request $request, OauthCredentialManager $xeroCredentials){

        $xero = resolve(\XeroAPI\XeroPHP\Api\AccountingApi::class);
        $contacts = $xero->getContacts($xeroCredentials->getTenantId())->getContacts();
        // using first contact ID for testing
        $contactId = $contacts[0]->getContactId();
        $invoices = '{ "Invoices": [ { "Type": "ACCREC", "Contact": { "ContactID": "'.$contactId.'"}, "LineItems": [ { "Description": "Acme Tires", "Quantity": 2, "UnitAmount": 20, "AccountCode": "200", "TaxType": "NONE", "LineAmount": 40 } ], "Date": "2019-03-11", "DueDate": "2018-12-10", "Reference": "Website Design", "Status": "AUTHORISED" } ] }';

        $invoices = json_decode($invoices);
        dd($xero->createInvoices($xeroCredentials->getTenantId(), $invoices));
    
        
        
    }

    ////////////////////////// Retrieve All Invoices /////////////////////////

    public function retrieveInvoices(Request $request, OauthCredentialManager $xeroCredentials){
        
        $xero = resolve(\XeroAPI\XeroPHP\Api\AccountingApi::class);
    
        $invoices = $xero->getInvoices($xeroCredentials->getTenantId());
        dd($invoices);
    }

    ////////////////////////// Retrieve an Invoices/////////////////////////
    
    public function retrieveInvoice(Request $request, OauthCredentialManager $xeroCredentials){
        $xero = resolve(\XeroAPI\XeroPHP\Api\AccountingApi::class);
    
        $invoices = $xero->getInvoices($xeroCredentials->getTenantId())->getInvoices();
        //first invoice id for testing
        $invoiceId = $invoices[0]->getInvoiceId();
        
        $invoice = $xero->getInvoice($xeroCredentials->getTenantId(), $invoiceId);
        dd($invoice);
    }

     ////////////////////////  Get Invoice As Pdf ////////////////////////////

    //  public function getInvoiceAsPdf(Request $request, OauthCredentialManager $xeroCredentials){

    //     $xero = resolve(\XeroAPI\XeroPHP\Api\AccountingApi::class);
    //     $invoices = $xero->getInvoices($xeroCredentials->getTenantId())->getInvoices();
    //     //first invoice id for testing
    //     $invoiceId = $invoices[0]->getInvoiceId();
    //     dd($xero->getInvoiceAsPdf($xeroCredentials->getTenantId(), $invoiceId));
    //  }

    //////////////////////// Make receipts ////////////////////////////

    public function createReceipts(Request $request, OauthCredentialManager $xeroCredentials){

        $xero = resolve(\XeroAPI\XeroPHP\Api\AccountingApi::class);
        $contacts = $xero->getContacts($xeroCredentials->getTenantId())->getContacts();
        $users = $xero->getUsers($xeroCredentials->getTenantId())->getUsers();
        // using first contact ID  && user ID for testing
        $contactId = $contacts[0]->getContactId();
        $userId = $users[0]->getUserId();

        $receipts = '{ "Receipts": [ { "Contact": { "ContactID": "'.$contactId.'" }, "Lineitems": [ { "Description": "Foobar", "Quantity": 2, "UnitAmount": 20, "AccountCode": "400", "TaxType": "NONE", "LineAmount": 40 } ], "User": { "UserID": "'.$userId.'" }, "LineAmountTypes": "NoTax", "Status": "DRAFT" } ] }';
        $receipts = json_decode($receipts);
        dd($xero->createReceipt($xeroCredentials->getTenantId(), $receipts));
    }

    //////////////////////// Retrieve receipts ////////////////////////////

    public function retrieveReceipts(Request $request, OauthCredentialManager $xeroCredentials){

        $xero = resolve(\XeroAPI\XeroPHP\Api\AccountingApi::class);

        $receipts = $xero->getReceipts($xeroCredentials->getTenantId());
        dd($receipts);
    }

    //////////////////////// Create Purchase Orders ////////////////////////////

    public function createPurchaseOrders(Request $request, OauthCredentialManager $xeroCredentials){

        $xero = resolve(\XeroAPI\XeroPHP\Api\AccountingApi::class);
        $contacts = $xero->getContacts($xeroCredentials->getTenantId())->getContacts();
        // using first contact ID for testing
        $contactId = $contacts[0]->getContactId();

        $purchaseOrders = '{ "PurchaseOrders": [ { "Contact": { "ContactID": "'.$contactId.'" }, "LineItems": [ { "Description": "Foobar", "Quantity": 1, "UnitAmount": 20, "AccountCode": "710" } ], "Date": "2019-03-13" } ] }';

        $purchaseOrders = json_decode($purchaseOrders);
        dd($xero->createPurchaseOrders($xeroCredentials->getTenantId(), $purchaseOrders));
    }

    //////////////////////// Get Purchase Orders ////////////////////////////
    
    public function getPurchaseOrders(Request $request, OauthCredentialManager $xeroCredentials){

        $xero = resolve(\XeroAPI\XeroPHP\Api\AccountingApi::class);

        $purchaseOrders = $xero->getPurchaseOrders($xeroCredentials->getTenantId());

        dd($purchaseOrders);

    }

    //////////////////////// Create Credit Notes ////////////////////////////

    public function createCreditNotes(Request $request, OauthCredentialManager $xeroCredentials){

        $xero = resolve(\XeroAPI\XeroPHP\Api\AccountingApi::class);
        $contacts = $xero->getContacts($xeroCredentials->getTenantId())->getContacts();
        // using first contact ID for testing
        $contactId = $contacts[0]->getContactId();

        $creditNotes = '{ "CreditNotes":[ { "Type":"ACCPAYCREDIT", "Contact":{ "ContactID":"'.$contactId.'" }, "Date":"2019-01-05", "LineItems":[ { "Description":"Foobar", "Quantity":2.0, "UnitAmount":20.0, "AccountCode":"400" } ] } ] }';

        $creditNotes = json_decode($creditNotes);
        dd($xero->createCreditNotes($xeroCredentials->getTenantId(), $creditNotes));
    }

    //////////////////////// Get Purchase Orders ////////////////////////////
    
    public function getCreditNotes(Request $request, OauthCredentialManager $xeroCredentials){

        $xero = resolve(\XeroAPI\XeroPHP\Api\AccountingApi::class);

        $creditNotes = $xero->getCreditNotes($xeroCredentials->getTenantId());

        dd($creditNotes);

    }

    ///////////////////////// Get Items ///////////////////////////////////

    public function getItems(Request $request, OauthCredentialManager $xeroCredentials){

        $xero = resolve(\XeroAPI\XeroPHP\Api\AccountingApi::class);

        $items = $xero->getItems($xeroCredentials->getTenantId());

        dd($items);
    }

}
    
