<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Http\Controllers\DimsCommon;

class UsersController extends Controller
{
     public function addUser(Request $request)
   {

       $UserName = $request->get('UserName');
       $Password = $request->get('Password');
	   $Email = $request->get('Email');
	   $StatusId = $request->get('StatusId');
       $Administrator = $request->get('Administrator');
	   $GroupId = $request->get('GroupId');
	   $Exporting = $request->get('Exporting');
       $exportAllOrders = $request->get('exportAllOrders');
	   $ExportAllReturns = $request->get('ExportAllReturns');
	   $PrinterPathInvoice = $request->get('PrinterPathInvoice');
       $PrinterPathPickingSlip = $request->get('PrinterPathPickingSlip');
	   $PrinterPathSalesOrder = $request->get('PrinterPathSalesOrder');
	   $TabletUser = $request->get('TabletUser');
       $CellPhone = $request->get('CellPhone');
	   $RunPastelLinks = $request->get('RunPastelLinks');
	   $SessionId = $request->get('SessionId');
       $PinCode = $request->get('PinCode');
	   $strField6 = bcrypt($request->get('strField6'));


	   $insertUser = DB::connection('sqlsrv3')
                        ->statement("EXEC spCRUDUsers NULL,'".$UserName."','".$Password."','".$Email."',".$StatusId.",".$Administrator.",".$GroupId.",".$Exporting.",
						".$exportAllOrders.",".$ExportAllReturns.",'".$PrinterPathInvoice."','".$PrinterPathPickingSlip."','".$PrinterPathSalesOrder."',".$TabletUser.",
						'".$CellPhone."', ".$RunPastelLinks.",'".$SessionId."',	".$PinCode.", '".$strField6."','Insert'");
		return response()->json($insertUser);

	}

    public function PathsAndEmails()
    {
        $queryAll = DB::connection('sqlsrv3')->table("vwForEditingEmailsAndPrinters")->select('Email','UserID', 'Username','PrinterPathInvoice', 'PrinterPathPickingSlip','PrinterPathPurchaseOrder','PrinterPathSalesOrder', 'PrinterPathTruckControl')->get();

        return view('dims/patheditor')
            ->with('allStuff', $queryAll);
    }
    public function editUsers(Request $request)
    {
        $userAuth = Auth::user()->UserName;
        $userAuthID = Auth::user()->UserID;
        $UserID = $request->get('UserID');
        $Username = $request->get('Username');
        $Email = $request->get('Email');
        $PrinterPathInvoice = $request->get('PrinterPathInvoice');
        $PrinterPathPickingSlip = $request->get('PrinterPathPickingSlip');
        $PrinterPathPurchaseOrder = $request->get('PrinterPathPurchaseOrder');
        $PrinterPathSalesOrder = $request->get('PrinterPathSalesOrder');
        $PrinterPathTruckControl = $request->get('PrinterPathTruckControl');


        // $updateUsers = DB::connection('sqlsrv3')
        //	->statement("EXEC spEditUsers '".$UserID."','".$Username."','".$Email."','".$PrinterPathInvoice . "','".$PrinterPathPickingSlip.  "','"
        //	.$PrinterPathPurchaseOrder. "','".$PrinterPathSalesOrder. "','".$PrinterPathTruckControl. "'");

        $updateUsers = DB::connection('sqlsrv3')
            ->statement('exec spEditUsers ?,?,?,?,?,?,?,?,?,?',
                array($userAuth, $userAuthID,$UserID, $Username, $Email,
                    $PrinterPathInvoice, $PrinterPathPickingSlip,
                    $PrinterPathPurchaseOrder,$PrinterPathSalesOrder,
                    $PrinterPathTruckControl)
            );
        //change to array formats
        return response()->json($updateUsers);

    }
   public function readUser(Request $request)
	{
	   $UserID = 0;
	   $UserName = "NULL";
       $Password = "NULL";
	   $Email = "NULL";
	   $StatusId = 0;
       $Administrator = 0;
	   $GroupId = 0;
	   $Exporting = 0;
       $exportAllOrders = 0;
	   $ExportAllReturns = 0;
	   $PrinterPathInvoice = "NULL";
       $PrinterPathPickingSlip = "NULL";
	   $PrinterPathSalesOrder = "NULL";
	   $TabletUser = 0;
       $CellPhone ="NULL";
	   $RunPastelLinks = 0;
	   $SessionId = "NULL";
       $PinCode = 0;
	   $strField6 = "NULL";

	   $getPrinters = DB::connection('sqlsrv3')
				->select("SELECT * FROM tblPrinters");

		$getStatus= DB::connection('sqlsrv3')
				->select("SELECT * FROM tblDIMSUsers");


	   $readUsers = DB::connection('sqlsrv3')
                        ->select("EXEC spCRUDUsers ".$UserID.",'".$UserName."','".$Password."','".$Email."',".$StatusId.",".$Administrator.",".$GroupId.",".$Exporting.",
						".$exportAllOrders.",".$ExportAllReturns.",'".$PrinterPathInvoice."','".$PrinterPathPickingSlip."','".$PrinterPathSalesOrder."',".$TabletUser.",
						'".$CellPhone."', ".$RunPastelLinks.",'".$SessionId."',	".$PinCode.", '".$strField6."','Select'");

		return view('dims/usersCrud')
		->with('readUser',$readUsers)
		->with('getStatus',$getStatus)
		->with('getPrinters',$getPrinters);

	}

	public function editUser(Request $request)
	{
	   $UserID = $request->get('UserID');
	   $UserName = $request->get('UserName');
       $Password = $request->get('Password');
	   $Email = $request->get('Email');
	   $StatusId = $request->get('StatusId');
       $Administrator = $request->get('Administrator');
	   $GroupId = $request->get('GroupId');
	   $Exporting = $request->get('Exporting');
       $exportAllOrders = $request->get('exportAllOrders');
	   $ExportAllReturns = $request->get('ExportAllReturns');
	   $PrinterPathInvoice = $request->get('PrinterPathInvoice');
       $PrinterPathPickingSlip = $request->get('PrinterPathPickingSlip');
	   $PrinterPathSalesOrder = $request->get('PrinterPathSalesOrder');
	   $TabletUser = $request->get('TabletUser');
       $CellPhone = $request->get('CellPhone');
	   $RunPastelLinks = $request->get('RunPastelLinks');
	   $SessionId = $request->get('SessionId');
       $PinCode = $request->get('PinCode');
	   $strField6 = bcrypt($request->get('strField6'));


	   $updateUsers = DB::connection('sqlsrv3')
                        ->statement("EXEC spCRUDUsers ".$UserID.",'".$UserName."','".$Password."','".$Email."',".$StatusId.",".$Administrator.",".$GroupId.",".$Exporting.",
						".$exportAllOrders.",".$ExportAllReturns.",'".$PrinterPathInvoice."','".$PrinterPathPickingSlip."','".$PrinterPathSalesOrder."',".$TabletUser.",
						'".$CellPhone."', ".$RunPastelLinks.",'".$SessionId."',	".$PinCode.", '".$strField6."','Update'");
		return response()->json($updateUsers);

	}

	public function deleteUser(Request $request)
	{
	   $UserID = $request->get('UserID');
	   $UserName = $request->get('UserName');
       $Password = $request->get('Password');
	   $Email = $request->get('Email');
	   $StatusId = $request->get('StatusId');
       $Administrator = $request->get('Administrator');
	   $GroupId = $request->get('GroupId');
	   $Exporting = $request->get('Exporting');
       $exportAllOrders = $request->get('exportAllOrders');
	   $ExportAllReturns = $request->get('ExportAllReturns');
	   $PrinterPathInvoice = $request->get('PrinterPathInvoice');
       $PrinterPathPickingSlip = $request->get('PrinterPathPickingSlip');
	   $PrinterPathSalesOrder = $request->get('PrinterPathSalesOrder');
	   $TabletUser = $request->get('TabletUser');
       $CellPhone = $request->get('CellPhone');
	   $RunPastelLinks = $request->get('RunPastelLinks');
	   $SessionId = $request->get('SessionId');
       $PinCode = $request->get('PinCode');
	   $strField6 = bcrypt($request->get('strField6'));



	   $deleteUser = DB::connection('sqlsrv3')
                        ->statement("EXEC spCRUDUsers ".$UserID.",'".$UserName."','".$Password."','".$Email."',".$StatusId.",".$Administrator.",".$GroupId.",".$Exporting.",
						".$exportAllOrders.",".$ExportAllReturns.",'".$PrinterPathInvoice."','".$PrinterPathPickingSlip."','".$PrinterPathSalesOrder."',".$TabletUser.",
						'".$CellPhone."', ".$RunPastelLinks.",'".$SessionId."',	".$PinCode.", '".$strField6."','Delete'");
		return response()->json($deleteUser);
	}
	public function gridCustomermanagement($users,$routes)
    {

        $userid = \Illuminate\Support\Facades\Auth::user()->UserID;
        if($routes !="all"){

        $getCustomer = DB::connection('sqlsrv3')
            ->select("select top 100 strRoute,storeName,CustomerPastelCode,
                        Monday,Tueday,Wednesday,Thursday,Friday,Saturday,Sunday,routeid,viewtblCustomers.UserName,viewtblCustomers.GroupName,viewtblCustomers.GroupId,
                        BuyerTelephone,viewtblCustomers.CellPhone,ContactPerson,BuyerContact,u.UserID
                        from viewtblCustomers

                         inner join tblDimsusers u
                        on u.UserName =  viewtblCustomers.UserName
                         where  viewtblCustomers.StatusId = 1 and routeid in ($routes) and  u.UserId in($users) order by storeName");




        }else{

            $getCustomer = DB::connection('sqlsrv3')
                ->select("select top 100 strRoute,storeName,CustomerPastelCode,
                        Monday,Tueday,Wednesday,Thursday,Friday,Saturday,Sunday,routeid,viewtblCustomers.UserName,viewtblCustomers.GroupName,viewtblCustomers.GroupId,
                        BuyerTelephone,viewtblCustomers.CellPhone,ContactPerson,BuyerContact,u.UserID
                        from viewtblCustomers

                         inner join tblDimsusers u
                        on u.UserName =  viewtblCustomers.UserName
                         where  viewtblCustomers.StatusId = 1 and u.UserId in ($users) order by storeName");

        }
        //dd($getCustomer);

        $routes = DB::connection('sqlsrv3')->select("SELECT RouteId,Route From tblRoutes order by Route");
        $users = DB::connection('sqlsrv3')->select("SELECT UserName,UserID From tblDIMSUSERS order by UserName");
        $group = DB::connection('sqlsrv3')->select("SELECT GroupId,GroupName From tblGroups order by GroupName");

        return view('dims/gridcustomermanagement')
            ->with('customereditablelist',$getCustomer)
            ->with('users',$users)
            ->with('groups',$group)
            ->with('routes',$routes);
    }
    public function retrieveUsers(Request $request)
    {
        $routeId = $request->get('routeId');
        $routeId = implode(", ", $routeId);

        $routeId = $request->get('user');
        $routeId = implode(", ", $routeId);
    }
    public function updategridroutes(Request $request)
    {
        $griddetails = $request->get('griddetails');//
        $userid = \Illuminate\Support\Facades\Auth::user()->UserID;
        $userName = \Illuminate\Support\Facades\Auth::user()->UserName;

        foreach ($griddetails as $value) {
             $insertOrderDetails= DB::connection('sqlsrv3')
                ->statement('exec spUpdateCustomerCallDaysAndRoutes ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?',
                    array($value['route'],$value['customerCode'],$value['Monday'],$value['Tuesday'],$value['Wednesday'],
                        $value['Thursday'],$value['Friday'],$value['Saturday'],$value['Sunday'],$value['group_'],$value['Salesman_'],
                        $value['ContactPerson_'],$value['BuyerTelephone_'],$value['CellPhone_'],$value['BuyerContact_'],$userid,$userName
                        )
                );
        }
        dd($griddetails);
    }
    public function salesPerformanceview()
    {
        return view('dims/sales_performance');
    }
    public function userorders($from,$to,$userId,$userName)
    {
        $listofusers=DB::connection('sqlsrv3')
            ->select("Select * from tblDimsUsers" );
        return view('dims/userorders')
            ->with('from',$from)
            ->with('to',$to)
            ->with('userid',$userId)
            ->with('listofusers',$listofusers)
            ->with('name',$userName);
    }

    public function salesPerformance($datefrom,$dateTo)
    {

        $getSearchTheInoice = DB::connection('sqlsrv3')
            ->select("EXEC spTeleSalesPerformance '" . $datefrom."','".$dateTo."'" );
        return response()->json($getSearchTheInoice);
    }
    public function getUserOrders($datefrom,$dateTo,$userid)
    {

        $orders= DB::connection('sqlsrv3')
            ->select("EXEC spUserOrders ?,?,?,?",array($userid,$datefrom,$dateTo,"e")  );
        return response()->json($orders);
    }
    public function userorderslines($orderid)
    {

        $ordersLines = DB::connection('sqlsrv3')
            ->select("EXEC spUserOrdersDetails ?",array($orderid)  );
        return response()->json($ordersLines);
    }
    public function gridUsers()
    {
        $getGroup = DB::connection('sqlsrv3')
            ->select("select  GroupId,GroupName
						from tblDIMSGROUPS ");

        $getGroupGrid = DB::connection('sqlsrv3')
            ->select("select *
						from viewGroupsGrid  order by GroupName");
        //dd($getGroup);
        $getUsers = DB::connection('sqlsrv3')
            ->select("select  UserID,UserName,Password,
			tblDIMSUSERS.Administrator,tblDIMSUSERS.GroupID,PinCode,strPickingTeams,GroupName
			from tblDIMSUSERS inner join
			tblDIMSGROUPS on tblDIMSGROUPS.GroupId = tblDIMSUSERS.GroupId ");
        //dd($getUsers);
        return view('dims/grid_Users')
            ->with('users',$getUsers)
            ->with('group',$getGroup)->with('CustGrid',$getGroupGrid);
    }
    public function jsonGetUsers()
    {
        $getUserGrid = DB::connection('sqlsrv3')
            ->select("select *
						from viewGridUsers  order by [UserName]");
        return response()->json($getUserGrid);
    }
    public function updateUsers(Request $request)
    {
     /*  $userDetails = $request->get('grid_Users');
         var_dump($userDetails);
        foreach ($userDetails as $val){
            //dd($userDetails);
            DB::connection('sqlsrv3')
                ->table('tblDIMSUSERS')
                ->where('UserID',$val['userId'])
                ->update(['Password'=>$val['password'],
                    'strField6'=>bcrypt($val['password']),
                    'GroupID' => $val['group']]);
        }
        var_dump($val);*/
    }
    public function updateuserpassword(Request $request)
    {
        $userpass = $request->get('userpass');
        //dd($userpass);
        $userId = $request->get('UserId');
       $updateResult = DB::connection('sqlsrv3')
            ->table('tblDIMSUSERS')
            ->where('UserID',$userId)
            ->update([
                'strField6'=>bcrypt($userpass),
                'Password'=>$userpass
                ]);
        return response()->json($updateResult);
    }
    public function updateuserinfo(Request $request)
    {
        $UserName = $request->get('UserName');
        $userId = $request->get('UserId');
        $pincode = $request->get('pincode');
        $groupid = $request->get('groupid');
       $updateresult = DB::connection('sqlsrv3')
            ->table('tblDIMSUSERS')
            ->where('UserID',$userId)
            ->update([
                'PinCode'=>trim($pincode),
                'UserName'=>$UserName,
                'GroupId'=>$groupid
                ]);
        return response()->json($updateresult);
    }
    public function viewUserRole()
    {
        $getUsers = DB::connection('sqlsrv3')
            ->select("select  * from tblDIMSGROUPS");


        return view('dims/grouproles')
            ->with('usergroups',$getUsers);
    }
    public function systemrolesandgrouproles(Request $request)
    {
        $groupId = $request->get('groupid');

        $currentuserroles = DB::connection('sqlsrv3')
            ->select("SELECT * FROM tblDIMSGroupSetup where GroupId = $groupId  order by OptionDesc");
        $systemroles =  DB::connection('sqlsrv3')
            ->select("EXEC spGetSystemRoles ".$groupId);

        $output['userroles'] = $currentuserroles;
        $output['systemroles'] = $systemroles;

        return $output;
    }
    public function updateremoverole(Request $request)
    {
        $groupId = $request->get('groupid');
        $statement = $request->get('statement');
        $theRole = $request->get('theRole');
        foreach ($theRole as $value)
        {
            $systemroles =  DB::connection('sqlsrv3')
                ->select("EXEC spUpdateRemoveRoles ?,?,?",
                    array($value['description'],$statement,$groupId)
                );
        }


        return response()->json($systemroles);
    }



}
