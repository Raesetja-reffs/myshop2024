<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
//use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Traits\ApiTrait;
use Illuminate\Support\Collection;

class OrdersExport implements FromCollection, WithHeadings
{
    use Exportable;
    use ApiTrait;

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

    public function collection()
    {
        if (config('app.IS_API_BASED')) {
            $data = $this->apiOrdersExport([
                'OrderId' => $this->orderid
            ]);
        } else {
            $returnCustomerAgeAnalysis= DB::connection('sqlsrv3')
                ->select("Exec spOrderIdLines ?",
                    array( $this->orderid));
            $data = DB::connection('sqlsrv3')->table("viewOrderLinesExcel" )
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

        // Convert array or collection to Laravel Collection if needed
        return new Collection($data);
    }

    // public function query()
    // {
    //     if (config('app.IS_API_BASED')) {
    //         $data = $this->apiOrdersExport([
    //             'OrderId' => $this->orderid
    //         ]);
    //     } else {
    //         $returnCustomerAgeAnalysis= DB::connection('sqlsrv3')
    //             ->select("Exec spOrderIdLines ?",
    //                 array( $this->orderid));
    //         $data = DB::connection('sqlsrv3')->table("viewOrderLinesExcel" )
    //             ->select( 'PastelCode',
    //                 'PastelDescription',
    //                 'Qty',
    //                 'QtyInStock',
    //                 'UnitSize',
    //                 'Price',
    //                 'Tax')
    //             ->where('OrderId', $this->orderid)
    //             ->orderBy('OrderDetailId');
    //     }

    //     return $data;
    // }
}
