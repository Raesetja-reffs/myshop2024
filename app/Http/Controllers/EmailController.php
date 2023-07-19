<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Mail;
use View;
use App;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Storage;
class EmailController extends Controller
{

    public function email(Request $request)
    {
        // Configuration
        $smtpAddress = 'smtp.gmail.com';
        $port = 465;
        $encryption = 'ssl';
        $yourEmail = 'reginald@lsystems.co.za';
        $yourPassword = 'regi@201103202';
        $https['ssl']['verify_peer'] = FALSE;
        $https['ssl']['verify_peer_name'] = FALSE;

        // Prepare transport
        $transport = \Swift_SmtpTransport::newInstance($smtpAddress, $port, $encryption)
            ->setUsername($yourEmail)
            ->setPassword($yourPassword)->setStreamOptions($https);
        $mailer = \Swift_Mailer::newInstance($transport);


        // Prepare content
        $salesQuoteID = $request->get('saleQuoteID');
        $totalIncPreview = $request->get('totalIncPreview');
        $from = $request->get('from');
        $to = $request->get('to');
        $cc = $request->get('cc');
        $subject = $request->get('subject');
        $bodyMessage= $request->get('bodyOnEmail');
        $pieces = explode(",", $cc);
        //dd($bodyMessage);
        $salesQuotePreview = DB::connection('sqlsrv3')->select("EXEC spSalesQuotesPreview ". $salesQuoteID );
       // dd($salesQuotePreview);
        $view = View::make('dims/email_template', [
            'message' => $salesQuotePreview,'total'=>$totalIncPreview
        ]);
        $time = time();
        $html = $view->render();
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML($html);
        $output = $pdf->output();

       Storage::put('/app/pdfs/sales_q'.$salesQuoteID."_".$time.'.pdf', $output);

        $file = storage_path('/app/app/pdfs/sales_q'.$salesQuoteID."_".$time.'.pdf');

        $message = \Swift_Message::newInstance('Sales Quotation')
            ->setFrom([$from=> 'Quotation #'.$salesQuoteID])
            ->setTo([$to => "noreply@mail.com"])->setBody($bodyMessage)
            ->attach(\Swift_Attachment::fromPath($file));

        if($mailer->send($message)){

            return response()->json("Quotation Sent Successfully");
        }

        return response()->json("Something went wrong :(");

    }
    public function emailSalesOrder(Request $request)
    {
        // Configuration
        $smtpAddress = 'smtp.gmail.com';
        $port = 465;
        $encryption = 'ssl';
        $yourEmail = 'reginald@lsystems.co.za';
        $yourPassword = 'regi@201103202';
        $https['ssl']['verify_peer'] = FALSE;
        $https['ssl']['verify_peer_name'] = FALSE;

        // Prepare transport
        $transport = \Swift_SmtpTransport::newInstance($smtpAddress, $port, $encryption)
            ->setUsername($yourEmail)
            ->setPassword($yourPassword)->setStreamOptions($https);
        $mailer = \Swift_Mailer::newInstance($transport);

        $from = $request->get('from');
        $to = $request->get('to');
        $subject = $request->get('subject');
        $bodyMessage= $request->get('bodyOnEmail');
        $orderId = $request->get('orderId');
        $file = $request->get('file');

        $message = \Swift_Message::newInstance('Order')
            ->setFrom([$from=> 'Order #'.$orderId])->setSubject($subject)
            ->setTo([$to => "noreply@mail.com"])->setBody($bodyMessage)
            ->attach(\Swift_Attachment::fromPath($file));

        if($mailer->send($message)){
            return response()->json("Quotation Sent Successfully");
        }
            return response()->json("Something went wrong :(");
    }

}