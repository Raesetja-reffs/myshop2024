<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrdersExport implements FromQuery, WithHeadings
{
    use Exportable;

    public function __construct(string $orderid)
    {
        $this->orderid = $orderid;
    }
    public function headings(): array
    {
        return [
            'Code',
            'Description',
            'Qty',
            'InStock',
            'UnitSize',
            'Price',
            'Tax',
        ];
    }

    public function query()
    {

        $returnCustomerAgeAnalysis= DB::connection('sqlsrv3')
            ->select("Exec spOrderIdLines ?",
                array( $this->orderid));
        return DB::connection('sqlsrv3')->table("viewOrderLinesExcel" )
            ->select( 'PastelCode',
                'PastelDescription',
                'Qty',
                'QtyInStock',
                'UnitSize',
                'Price',
                'Tax')
            ->where('OrderId', $this->orderid)
            ->orderBy('OrderDetailId');
    }
}
