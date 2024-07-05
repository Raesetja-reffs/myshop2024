<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPJasper\PHPJasper;
use Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Traits\JasperReportsTrait;

class JasperReports extends Controller
{
    use JasperReportsTrait;

    private $PHPJasper;
    // public function __construct($PHPJasper = null){
    //     $this->PHPJasper = new PHPJasper();
    // }

    public function compileExample(){
        $input_file =  public_path('/reports/specials.jrxml');
        $jasper = new PHPJasper;
        $jasper->compile($input_file)->execute();
    }

    public function testJaspr($ID){
        $input = public_path('/reports/defaultdalesquotation.jasper');
        $jdbc_dir = public_path('/drivers');//Please make sure you put mssql drivers in here otherwise u will get an error
        $output = public_path('/reports');

        $ext = "pdf";
        $options = [
            'format' => ['pdf'],
            'locale' => 'en',
            'params' => [
                'QuoteId'=>$ID,
            ],
            'db_connection' => [
                'driver' => 'generic', //mysql, postgres, oracle, generic (jdbc)
                'username' => 'sa',
                'password' => 'System2008#',
                'host' => '127.0.0.1',
                'database' => 'linxdbDIMSKerston',
                'port' => '1433',
                'jdbc_driver' => 'com.microsoft.sqlserver.jdbc.SQLServerDriver',
                'jdbc_url' => 'jdbc:sqlserver://localhost:1433;databaseName=linxdbDIMSKerston',
                'jdbc_dir' => $jdbc_dir

            ]
            /* 'db_connection' => [
                'driver' => 'generic', //mysql, postgres, oracle, generic (jdbc)
                'username' => env('DB_USERNAME', 'sa'),
                'password' => env('DB_PASSWORD', 'System2008#'),
                'host' => env('DB_HOST', '127.0.0.1'),
                'database' =>env('DB_DATABASE', 'linxdbDIMSKerston'),
                'port' => env('DB_PORT', '1433'),
                'jdbc_driver' => 'com.microsoft.sqlserver.jdbc.SQLServerDriver',
                'jdbc_url' => 'jdbc:sqlserver://localhost:1433;databaseName=linxdbDIMSKerston',
                'jdbc_dir' => $jdbc_dir

            ]*/
        ];
        ;
        $jasper = new PHPJasper;
        //$time =time();
        $jasper->process(
            $input,
            $output,
            $options
        )->execute();
        //  header('Content-Disposition: attachment; filename='.$ID.'defaultdalesquotation.'.$ext);
        // dd($jasper);
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');

        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($output.'/test_A4.'.$ext));
        flush();
        readfile($output.'/test_A4.'.$ext);
        unlink($output.'/test_A4.'.$ext); // deletes the temporary fil
        return response()->file($output.'/defaultdalesquotation.'.$ext);

    }

    public function specialnsJasper($ID){
        $input = public_path('/reports/specials.jasper');
        $jdbc_dir = public_path('/drivers');//Please make sure you put mssql drivers in here otherwise u will get an error
        $output = public_path('/reports');

        $ext = "pdf";

        $options = [
            'format' => ['pdf'],
            'locale' => 'en',
            'params' => [
                'CustomerPastelCode'=>$ID,
            ],
            'db_connection' => [
                'driver' => 'generic', //mysql, postgres, oracle, generic (jdbc)
                'username' => 'sa',
                'password' => 'Linx_123',
                'host' => 'localhost',
                'database' => 'linxdbDIMSMag',
                'port' => '1433',
                'jdbc_driver' => 'com.microsoft.sqlserver.jdbc.SQLServerDriver',
                'jdbc_url' => 'jdbc:sqlserver://localhost:1433;databaseName=linxdbDIMSMag',
                'jdbc_dir' => $jdbc_dir

            ]

        ];

        $jasper = new PHPJasper;
        //$time =time();
        $jasper->process(
            $input,
            $output,
            $options
        )->execute();

        // dd($jasper);
        return response()->file($output.'/specials.'.$ext);
    }

    public function PDFOrders($ID)
    {
        if (config('app.IS_API_BASED')) {
            $createdBy = auth()->guard('central_api_user')->user()->erp_apiusername;
            $response = $this->apiPDFOrders([
                'OrderId' => $ID
            ]);
            $orderlines = $this->apiGetOrderLines([
                'OrderId' => $ID
            ]);
            $orderheader = $response['orderheader'];
            $companyInfo = $response['companyInfo'];
        } else {
            $UserID = Auth::user()->UserID;
            $createdBy = Auth::user()->UserName;
            $orderheader = DB::connection('sqlsrv3')->select("EXEC [spGetOrderHeaderPrintDIMS] ?,?", array($ID, $UserID));
            $companyInfo = DB::connection('sqlsrv3')->select("EXEC spStaticCompanyInfoHeader ?", array($ID));
        }

        return view('dims/printorder')
            ->with('ID', $ID)
            ->with('createdBy', $createdBy)
            ->with('companyInfo', $companyInfo)
            ->with('orderheader', $orderheader)
            ->with('orderlines', $orderlines);
    }

    public function getOrderLines(Request $request)
    {
        $ID = $request->get('ID');
        if (config('app.IS_API_BASED')) {
            $orderlines = $this->apiGetOrderLines([
                'OrderId' => $ID
            ]);
        } else {
            $orderlines = DB::connection('sqlsrv3')->select("EXEC [spGetOrderLinesPrint] ?", array($ID));
        }

        return response()->json($orderlines);
    }

    public function getOrderLinesDeliveryNote(Request $request)
    {
        $ID = $request->get('ID');
        $orderlines = DB::connection('sqlsrv3')->select("EXEC [spGetDeliveryNoteLinesPDF] ?", array($ID));

        return response()->json($orderlines);
    }

    public function CashOffPDF($ref,$User){
        $input = public_path('/reports/Blank_A4_Landscape.jasper');
        $jdbc_dir = public_path('/drivers');//Please make sure you put mssql drivers in here otherwise u will get an error
        $output = public_path('/reports');

        $ext = "pdf";
        //dd("ffffffffffffffff");
        $options = [
            'format' => ['pdf'],
            'locale' => 'en',
            'params' => [
                'ref'=>$ref,
                'username'=>$User,
            ],
            'db_connection' => [
                'driver' => 'generic', //mysql, postgres, oracle, generic (jdbc)
                'username' => 'sa',
                'password' => 'Linx_123',
                'host' => '127.0.0.1',
                'database' => 'linxdbDIMS',
                'port' => '1433',
                'jdbc_driver' => 'com.microsoft.sqlserver.jdbc.SQLServerDriver',
                'jdbc_url' => 'jdbc:sqlserver://127.0.0.1:1433;databaseName=linxdbDIMS',
                'jdbc_dir' => $jdbc_dir

            ]

        ];

        $jasper = new PHPJasper;
        //$time =time();
        $jasper->process(
            $input,
            $output,
            $options
        )->output();
        // )->execute();

        // dd($jasper);
        return response()->file($output.'/Blank_A4_Landscape.'.$ext);
    }

    public function PDFDelDate($ID){
        if (config('app.IS_API_BASED')) {
            $createdBy = auth()->guard('central_api_user')->user()->erp_apiusername;
            $response = $this->apiPDFOrders([
                'OrderId' => $ID
            ]);
            $orderlines = $this->apiGetOrderLines([
                'OrderId' => $ID
            ]);
            $orderheader = $response['orderheader'];
            $companyInfo = $response['companyInfo'];
        } else {
            $UserID = Auth::user()->UserID;
            $createdBy = Auth::user()->UserName;
            $orderheader = DB::connection('sqlsrv3')->select("EXEC [spGetOrderHeaderPrintDIMS] ?,?", array($ID, $UserID));
            $companyInfo = DB::connection('sqlsrv3')->select("EXEC spStaticCompanyInfoHeader ?", array($ID));
        }


        return view('printreports/printorderdelnote_new_design')
            ->with('ID', $ID)
            ->with('createdBy', $createdBy)
            ->with('companyInfo', $companyInfo)
            ->with('orderheader', $orderheader)
            ->with('orderlines', $orderlines);
    }
    public function FreshOrders()
    {
        $input = public_path('/reports/freshorders.jasper');
        $jdbc_dir = public_path('/drivers');//Please make sure you put mssql drivers in here otherwise u will get an error
        $output = public_path('/reports');

        $ext = "pdf";

        $options = [
            'format' => ['pdf'],
            'locale' => 'en',
            'db_connection' => [
                'driver' => 'generic', //mysql, postgres, oracle, generic (jdbc)
                'username' => 'sa',
                'password' => 'System2008#',
                'host' => 'robberg.dnsalias.org',
                'database' => 'linxdbDIMS',
                'port' => '1433',
                'jdbc_driver' => 'com.microsoft.sqlserver.jdbc.SQLServerDriver',
                'jdbc_url' => 'jdbc:sqlserver://robberg.dnsalias.org:1433;databaseName=linxdbDIMS',
                'jdbc_dir' => $jdbc_dir

            ]

        ];

        $jasper = new PHPJasper;
//$time =time();
        $jasper->process(
            $input,
            $output,
            $options
        )->execute();

        // dd($jasper);
        return response()->file($output.'/freshorders.'.$ext);
    }
    public function overallSpecailJasper($datefrom,$dateto)
    {
        $input = public_path('/reports/overallspecials.jasper');
        $jdbc_dir = public_path('/drivers');//Please make sure you put mssql drivers in here otherwise u will get an error
        $output = public_path('/reports');

        $ext = "xlsx";

        $options = [
            'format' => ['xlsx'],//csv
            'locale' => 'en',
            'params' => [
                'datefrom'=>$datefrom,
                'dateto'=>$dateto,
            ],
            'db_connection' => [
                'driver' => 'generic', //mysql, postgres, oracle, generic (jdbc)
                'username' => 'sa',
                'password' => 'linx123',
                'host' => 'localhost',
                'database' => 'linxdbDIMS',
                'port' => '1433',
                'jdbc_driver' => 'com.microsoft.sqlserver.jdbc.SQLServerDriver',
                'jdbc_url' => 'jdbc:sqlserver://localhost:1433;databaseName=linxdbDIMS',
                'jdbc_dir' => $jdbc_dir

            ]

        ];

        $jasper = new PHPJasper;
//$time =time();
        $jasper->process(
            $input,
            $output,
            $options
        // )->output();
        )->execute();

        // dd($jasper);
        return response()->file($output.'/overallspecials.'.$ext);
    }

    public function groupSpecailJasper($datefrom,$dateto,$groupid)
    {
        $UserID = Auth::user()->UserID;

        $groupDetails = DB::connection('sqlsrv3')
            ->select("select * from tblGroups where GroupId=?", [$groupid]);
        $entityName = '';
        if ($groupDetails && isset($groupDetails[0])) {
            $entityName = $groupDetails[0]->GroupName;
        }
        $groupSpecialData = DB::connection('sqlsrv3')->select("EXEC [spGroupSpecialFilter] ?,?,?,?", array($groupid,$datefrom,$dateto,$UserID));
        $getCompanyDetails = DB::connection('sqlsrv3')
            ->select("select * from tblAppCompanyDetails where intLocationID=1");
        $companyDetails = [];
        if ($getCompanyDetails) {
            foreach ($getCompanyDetails as $value) {
                if ($value->strHtmlTagName) {
                    $companyDetails[$value->strHtmlTagName] = $value->strHtml;
                }
            }
        }

        return view('dims/groupspecailjasper', compact('entityName', 'groupSpecialData', 'companyDetails'));
    }

}
