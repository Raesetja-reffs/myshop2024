<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RoutePlanExport implements FromArray, WithHeadings
{
    use Exportable;

    public function __construct(string $routeid,string $datefrom,string $dateto,string $ordertype, string $status)
    {
        $this->routeid = $routeid;
        $this->datefrom = $datefrom;
        $this->dateto = $dateto;
        $this->ordertype = $ordertype;
        $this->status = $status;
    }
    public function headings(): array
    {
        return [
            'Order ID',
            'Route ID',
            'Order Type',
            'Route',
            'Delivery Date',
            'Delivery Address 1',
            'CustomerCode',
            'Customer Description',
            'Invoice Number',
            'Delivery Sequence',
            'Order Value',
            'Mass',
            'Optional Field',
            'Backorder',
            'Order Date',
            'Locked',
            'Status',
            'Notification',
            'Time',
            'Credit Hold',
            'Custom Reason',
        ];
    }

    public function array():array
    {

       return  DB::connection('sqlsrv3')
        ->select('exec spGetStopsToSortExcel ?,?,?,?,?',
            array( $this->datefrom,  $this->dateto,  $this->ordertype, $this->routeid, $this->status)
        );
    }
}
