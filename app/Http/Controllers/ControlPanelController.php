<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Http\Controllers\DimsCommon;
use App\Traits\ControlPanelControllerTrait;

class ControlPanelController extends Controller
{
	use ControlPanelControllerTrait;
	public function test(Request $request)
   {
	  $test=0;

      return view('dims/test')
		->with('test',$test);

	}



    //OrderTypes
	public function addOrderType(Request $request)
   {


       $OrderType = $request->get('OrderType');
	   $insertOrderType = DB::connection('sqlsrv3')
                        ->statement("EXEC spCRUDOrderTypes NULL,'".$OrderType."','Insert'");
		return response()->json($insertOrderType);

	}


   public function readOrderType(Request $request)
	{
	   $OrderTypeId = 0;
       $OrderType = "NULL";
	   $readOrderTypes = DB::connection('sqlsrv3')
                        ->select("EXEC spCRUDOrderTypes ".$OrderTypeId.",'".$OrderType."','Select'");



		return view('dims/ordertypes')
		->with('readOrderTypes',$readOrderTypes);

	}

	public function editOrderType(Request $request)
	{
	   $OrderTypeId = $request->get('OrderTypeId');
       $OrderType = $request->get('OrderType');


	   $updateOrderType = DB::connection('sqlsrv3')
                        ->statement("EXEC spCRUDOrderTypes ".$OrderTypeId.",'".$OrderType."','Update'");
		return response()->json($updateOrderType);

	}

	public function deleteOrderType(Request $request)
	{
	   $OrderTypeId = $request->get('OrderTypeId');
       $OrderType = $request->get('OrderType');


	   $deleteOrderTypes = DB::connection('sqlsrv3')
                        ->statement("EXEC spCRUDOrderTypes ".$OrderTypeId.",'".$OrderType."','Delete'");
		return response()->json($deleteOrderTypes);
	}











	//Brands

	public function addBrand(Request $request)
   {


       $Brand = $request->get('Brand');
	   $GroupId = $request->get('GroupId');
	   $NewRec = $request->get('NewRec');
	   $OwnerId = $request->get('OwnerId');

	   $insertBrands = DB::connection('sqlsrv3')
                        ->statement("EXEC spCRUDBrands NULL,'".$Brand."',".$GroupId.",".$NewRec.",".$OwnerId.",'Insert'");
		return response()->json($insertBrands);

	}

	 public function readBrand(Request $request)
	{
	   $BrandId = 0;
       $Brand = "NULL";
	   $GroupId = 0;
	   $NewRec = 0;
	   $OwnerId = 0;
	   $readBrand = DB::connection('sqlsrv3')
                        ->select("EXEC spCRUDBrands ".$BrandId.",'".$Brand."',".$GroupId.",".$NewRec.",".$OwnerId.",'Select'");

		$getGroups= DB::connection('sqlsrv3')
					->select("SELECT * FROM tblGroups");

		return view('dims/brands')
		->with('readBrand',$readBrand)
		->with('getGroups',$getGroups);

	}

	public function editBrand(Request $request)
	{
	   $BrandId = $request->get('BrandId');
       $Brand = $request->get('Brand');
	   $GroupId = $request->get('GroupId');
	   $NewRec = $request->get('NewRec');
	   $OwnerId = $request->get('OwnerId');


	   $updateBrand = DB::connection('sqlsrv3')
                        ->statement("EXEC spCRUDBrands ".$BrandId.",'".$Brand."',".$GroupId.",".$NewRec.",".$OwnerId.",'Update'");
		return response()->json($updateBrand);

	}

	public function deleteBrand(Request $request)
	{
	  $BrandId = $request->get('BrandId');
       $Brand = $request->get('Brand');
	   $GroupId = $request->get('GroupId');
	   $NewRec = $request->get('NewRec');
	   $OwnerId = $request->get('OwnerId');


	   $deleteBrand = DB::connection('sqlsrv3')
                        ->statement("EXEC spCRUDBrands ".$BrandId.",'".$Brand."',".$GroupId.",".$NewRec.",".$OwnerId.",'Delete'");
		return response()->json($deleteBrand);
	}

	//Groups

	public function addGroup(Request $request)
   {


       $GroupName = $request->get('GroupName');
	   $GroupCode = $request->get('GroupCode');
	   $RebateAcc = $request->get('RebateAcc');
	   $RebatePercent = $request->get('RebatePercent');
	   $InvoiceSeperately = $request->get('InvoiceSeperately');
	   $NewRec = $request->get('NewRec');

	  // dd("EXEC spCRUDGroups NULL,'".$GroupName."','".$GroupCode."','".$RebateAcc."',".$RebatePercent.",".$InvoiceSeperately.",".$NewRec.",'Insert'");
	   $insertGroup = DB::connection('sqlsrv3')
                        ->statement("EXEC spCRUDGroups NULL,'".$GroupName."','".$GroupCode."','".$RebateAcc."',".$RebatePercent.",".$InvoiceSeperately.",".$NewRec.",'Insert'");
		return response()->json($insertGroup);

	}

	 public function readGroup(Request $request)
	{

	   $GroupId = 0;
	   $GroupName = "NULL";
	   $GroupCode = 0;
	   $RebateAcc = "NULL";
	   $RebatePercent = 0;
	   $InvoiceSeperately = 0;
	   $NewRec = 0;

	   $readGroup = DB::connection('sqlsrv3')
                        ->select("EXEC spCRUDGroups ".$GroupId.",'".$GroupName."',".$GroupCode.",'".$RebateAcc."',".$RebatePercent.",".$InvoiceSeperately.",".$NewRec.",'Select'");



		return view('dims/groups')
		->with('readGroup',$readGroup);

	}

	public function editGroup(Request $request)
	{
	   $GroupId = $request->get('GroupId');
       $GroupName = $request->get('GroupName');
	   $GroupCode = $request->get('GroupCode');
	   $RebateAcc = $request->get('RebateAcc');
	   $RebatePercent = $request->get('RebatePercent');
	   $InvoiceSeperately = $request->get('InvoiceSeperately');
	   $NewRec = $request->get('NewRec');


	   $updateGroup = DB::connection('sqlsrv3')
                        ->statement("EXEC spCRUDGroups ".$GroupId.",'".$GroupName."',".$GroupCode.",'".$RebateAcc."',".$RebatePercent.",".$InvoiceSeperately.",".$NewRec.",'Update'");
		return response()->json($updateGroup);

	}


	public function deleteGroup(Request $request)
	{
	  $GroupId = $request->get('GroupId');
       $GroupName = $request->get('GroupName');
	   $GroupCode = $request->get('GroupCode');
	   $RebateAcc = $request->get('RebateAcc');
	   $RebatePercent = $request->get('RebatePercent');
	   $InvoiceSeperately = $request->get('InvoiceSeperately');
	   $NewRec = $request->get('NewRec');


	   $deleteGroup = DB::connection('sqlsrv3')
                        ->statement("EXEC spCRUDGroups ".$GroupId.",'".$GroupName."',".$GroupCode.",'".$RebateAcc."',".$RebatePercent.",".$InvoiceSeperately.",".$NewRec.",'Delete'");
		return response()->json($deleteGroup);
	}




	//Taxes

	public function addTax(Request $request)
   {


       $TaxCode = $request->get('TaxCode');
	   $Tax = $request->get('Tax');



	   $insertTax = DB::connection('sqlsrv3')
                        ->statement("EXEC spCRUDTaxes NULL,'".$TaxCode."',".$Tax.",'Insert'");
		return response()->json($insertTax);

	}

	 public function readTax(Request $request)
	{

	   $TaxId = 0;
	   $TaxCode = "NULL";
	   $Tax = 0;


	   $readTax = DB::connection('sqlsrv3')
                        ->select("EXEC spCRUDTaxes ".$TaxId.",'".$TaxCode."',".$Tax.",'Select'");



		return view('dims/taxes')
		->with('readTax',$readTax);

	}

	public function editTax(Request $request)
	{
	   $TaxId = $request->get('TaxId');
       $TaxCode = $request->get('TaxCode');
	   $Tax = $request->get('Tax');



	   $updateTax = DB::connection('sqlsrv3')
                        ->statement("EXEC spCRUDTaxes ".$TaxId.",'".$TaxCode."',".$Tax.",'Update'");
		return response()->json($updateTax);

	}


	public function deleteTax(Request $request)
	{
	  $TaxId = $request->get('TaxId');
       $TaxCode = $request->get('TaxCode');
	   $Tax = $request->get('Tax');


	   $deleteTax = DB::connection('sqlsrv3')
                        ->statement("EXEC spCRUDTaxes ".$TaxId.",'".$TaxCode."',".$Tax.",'Delete'");
		return response()->json($deleteTax);
	}









	//PickingTeam
 
	public function addPickingTeam(Request $request)
   {


	   $PickingTeam = $request->get('PickingTeam');
	   $Commision = $request->get('Commision');
	   $PickingSlipPath = $request->get('PickingSlipPath');
	   if (config('app.IS_API_BASED')) {
		$insertPickingTeam = $this->apiPickingTeamCRUD([
			'PickingTeamId' => 0,
            'PickingTeam' => $PickingTeam,
            'Commision' => $Commision,
            'PickingSlipPath' => $PickingSlipPath,
            'Statement' => 'Insert',
		]);
	}else {
		$insertPickingTeam = DB::connection('sqlsrv3')
		->select("EXEC sp_API_CRUD_PickingTeams ?,?,?,?,?",array(0,$PickingTeam,$Commision,$PickingSlipPath,'Insert'));
	   }
	return response()->json($insertPickingTeam);

	}

	 public function readPickingTeam(Request $request)
	{

	   $PickingTeamId = 0;
	   $PickingTeam = "NULL";
	   $Commision = 0;
	   $PickingSlipPath = "NULL";
	   if (config('app.IS_API_BASED')) {
		$readPickingTeam = $this->apiPickingTeamCRUD([
			'PickingTeamId' => $PickingTeamId,
            'PickingTeam' => $PickingTeam,
            'Commision' => $Commision,
            'PickingSlipPath' => $PickingSlipPath,
            'Statement' => 'Select',

		]);
	} else {
		$readPickingTeam = DB::connection('sqlsrv3')
						 ->select("EXEC sp_API_CRUD_PickingTeams ?,?,?,?,?",array($PickingTeamId,$PickingTeam,$Commision,$PickingSlipPath,'Select'));
	}

	$readPickingTeam = array_map(function($item) {
		return (object) $item;
	}, $readPickingTeam);
		return view('dims/pickingteam')
		->with('readPickingTeam',$readPickingTeam);

	}

	public function editPickingTeam(Request $request)
	{
	   $PickingTeamId = $request->get('PickingTeamId');
	   $PickingTeam = $request->get('PickingTeam');
	   $Commision = $request->get('Commision');
	   $PickingSlipPath = $request->get('PickingSlipPath');

	   if (config('app.IS_API_BASED')) {

		$updatePickingTeam = $this->apiPickingTeamCRUD([
			'PickingTeamId' => $PickingTeamId,
            'PickingTeam' => $PickingTeam,
            'Commision' => $Commision,
            'PickingSlipPath' => $PickingSlipPath,
            'Statement' => 'Update',
		]);
	}else {
	   $updatePickingTeam = DB::connection('sqlsrv3')
	   ->select("EXEC sp_API_CRUD_PickingTeams ?,?,?,?,?",array($PickingTeamId,$PickingTeam,$Commision,$PickingSlipPath,'Update'));
	}
		return response()->json($updatePickingTeam);

	}


	public function deletePickingTeam(Request $request)
	{
	  $PickingTeamId = $request->get('PickingTeamId');
	   $PickingTeam = $request->get('PickingTeam');
	   $Commision = $request->get('Commision');
	   $PickingSlipPath = $request->get('PickingSlipPath');
	   if (config('app.IS_API_BASED')) {
		$deletePickingTeam = $this->apiPickingTeamCRUD([
			'PickingTeamId' => $PickingTeamId,
            'PickingTeam' => $PickingTeam,
            'Commision' => $Commision,
            'PickingSlipPath' => $PickingSlipPath,
            'Statement' => 'Delete',

		]);
	}else {

	   $deletePickingTeam = DB::connection('sqlsrv3')
	   ->select("EXEC sp_API_CRUD_PickingTeams ?,?,?,?,?",array($PickingTeamId,$PickingTeam,$Commision,$PickingSlipPath,'Delete'));
	}

		return response()->json($deletePickingTeam);
	}





	//GroupBrands

	public function addGroupBrand(Request $request)
   {


	   $BrandId=$request->get('BrandId');
	   $GroupId = $request->get('GroupId');
	   $NewRec = $request->get('NewRec');

	   //dd("EXEC spCRUDGroupBrands NULL,".$GroupId.",".$NewRec.",'Insert'");

	$insertGroupBrands = DB::connection('sqlsrv3')
           ->statement("EXEC spCRUDGroupBrands NULL,".$GroupId.",".$NewRec.",'Insert'");
	return response()->json($insertGroupBrands);

	}


	 public function readGroupBrand(Request $request)
	{

	   $BrandId = 0;
	   $GroupId = 0;
	   $NewRec = 0;


	   $readGroupBrands = DB::connection('sqlsrv3')
                        ->select("EXEC spCRUDGroupBrands ".$BrandId.",".$GroupId.",'".$NewRec."','Select'");

		$getBrands = DB::connection('sqlsrv3')
						->select("SELECT * FROM tblBrands");

		$getGroups = DB::connection('sqlsrv3')
						->select("SELECT * FROM tblGroups");

		return view('dims/groupbrands')
		->with('getBrands',$getBrands)
		->with('getGroups',$getGroups)
		->with('readGroupBrands',$readGroupBrands);

	}

	public function editGroupBrand(Request $request)
	{
	   $BrandId = $request->get('BrandId');
	   $GroupId = $request->get('GroupId');
	   $NewRec = $request->get('NewRec');



	    $updateGroupBrands= DB::connection('sqlsrv3')
                       ->statement("EXEC spCRUDGroupBrands ".$BrandId.",".$GroupId.",".$NewRec.",'Update'");
		return response()->json($updateGroupBrands);

	}
	public function deleteGroupBrand(Request $request)
	{
	  $BrandId = $request->get('BrandId');
	   $GroupId = $request->get('GroupId');
	   $NewRec = $request->get('NewRec');


	   $deleteGroupBrands = DB::connection('sqlsrv3')
                        ->statement("EXEC spCRUDGroupBrands ".$BrandId.",".$GroupId.",".$NewRec.",'Delete'");
		return response()->json($deleteGroupBrands);
	}



}
