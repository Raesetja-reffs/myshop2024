<?php

namespace App\Traits;

use App\Traits\ApiTrait;

trait SalesFormTrait
{
    use ApiTrait;

    public function apiGetSalesOrderPageData()
    {
        $getRoutes = [
            [
                "Routeid" => "23",
                "Route" => "ALBERTINIA"
            ],
            [
                "Routeid" => "2",
                "Route" => "BEAUFORT WEST"
            ],
            [
                "Routeid" => "5",
                "Route" => "COLLECTIONS"
            ],
            [
                "Routeid" => "6",
                "Route" => "COURIER"
            ],
            [
                "Routeid" => "10",
                "Route" => "GEORGE"
            ],
            [
                "Routeid" => "31",
                "Route" => "GREAT BRAK RIVER"
            ],
            [
                "Routeid" => "44",
                "Route" => "HARKERVILLE"
            ],
            [
                "Routeid" => "30",
                "Route" => "HEIDELBERG"
            ],
            [
                "Routeid" => "13",
                "Route" => "JEFFREYS BAY"
            ],
            [
                "Routeid" => "33",
                "Route" => "KARATARA DISTRICT"
            ],
            [
                "Routeid" => "14",
                "Route" => "KNYNSA"
            ],
            [
                "Routeid" => "24",
                "Route" => "LADISMITH"
            ],
            [
                "Routeid" => "29",
                "Route" => "Langkloof District"
            ],
            [
                "Routeid" => "3",
                "Route" => "MOSSELBAY 1"
            ],
            [
                "Routeid" => "4",
                "Route" => "MOSSELBAY 2"
            ],
            [
                "Routeid" => "35",
                "Route" => "Nelspruit"
            ],
            [
                "Routeid" => "1",
                "Route" => "No Route"
            ],
            [
                "Routeid" => "37",
                "Route" => "OLD GEORGE ROAD"
            ],
            [
                "Routeid" => "15",
                "Route" => "OUDTSHOORN"
            ],
            [
                "Routeid" => "27",
                "Route" => "OUDTSHOORN2"
            ],
            [
                "Routeid" => "28",
                "Route" => "OUDTSHOORN3"
            ],
            [
                "Routeid" => "34",
                "Route" => "Paarl"
            ],
            [
                "Routeid" => "41",
                "Route" => "PACALTSDORP INDUSTRIAL"
            ],
            [
                "Routeid" => "16",
                "Route" => "PLETTENBERG BAY"
            ],
            [
                "Routeid" => "36",
                "Route" => "REPS"
            ],
            [
                "Routeid" => "17",
                "Route" => "RIVERSDALE"
            ],
            [
                "Routeid" => "18",
                "Route" => "SEDGEFIELD"
            ],
            [
                "Routeid" => "25",
                "Route" => "STAFF"
            ],
            [
                "Routeid" => "38",
                "Route" => "STILL BAY DISTRICT"
            ],
            [
                "Routeid" => "45",
                "Route" => "SWELLENDAM"
            ],
            [
                "Routeid" => "48",
                "Route" => "test1"
            ],
            [
                "Routeid" => "49",
                "Route" => "test3"
            ],
            [
                "Routeid" => "50",
                "Route" => "test4"
            ],
            [
                "Routeid" => "40",
                "Route" => "THEMBALETHU"
            ],
            [
                "Routeid" => "26",
                "Route" => "UNIONDALE"
            ]
        ];
        foreach ($getRoutes as &$item) {
            $item = (object) $item;
        }
        $saleman = [
            [
                "UserID" => "0",
                "UserName" => "DORMANT DEBTORS",
                "strSalesmanCode" => "1"
            ],
            [
                "UserID" => "0",
                "UserName" => "C&C Debtors Accounts",
                "strSalesmanCode" => "100"
            ],
            [
                "UserID" => "0",
                "UserName" => "HOUSE",
                "strSalesmanCode" => "101"
            ],
            [
                "UserID" => "0",
                "UserName" => "NADIA",
                "strSalesmanCode" => "102"
            ],
            [
                "UserID" => "0",
                "UserName" => "JACO",
                "strSalesmanCode" => "103"
            ],
            [
                "UserID" => "0",
                "UserName" => "ARIE JNR",
                "strSalesmanCode" => "104"
            ],
            [
                "UserID" => "0",
                "UserName" => "ANTHEA",
                "strSalesmanCode" => "105"
            ],
            [
                "UserID" => "0",
                "UserName" => "DAPHNE",
                "strSalesmanCode" => "106"
            ],
            [
                "UserID" => "0",
                "UserName" => "JEAN JOUBERT",
                "strSalesmanCode" => "107"
            ],
            [
                "UserID" => "0",
                "UserName" => "ARNO",
                "strSalesmanCode" => "108"
            ],
            [
                "UserID" => "0",
                "UserName" => "SANDRA",
                "strSalesmanCode" => "109"
            ],
            [
                "UserID" => "0",
                "UserName" => "WILLIE",
                "strSalesmanCode" => "110"
            ],
            [
                "UserID" => "0",
                "UserName" => "MARNEL",
                "strSalesmanCode" => "111"
            ],
            [
                "UserID" => "0",
                "UserName" => "MINDRE",
                "strSalesmanCode" => "112"
            ],
            [
                "UserID" => "0",
                "UserName" => "zzGERHARD VICTOR",
                "strSalesmanCode" => "113"
            ],
            [
                "UserID" => "0",
                "UserName" => "MICHELLE",
                "strSalesmanCode" => "114"
            ],
            [
                "UserID" => "0",
                "UserName" => "HENDRI",
                "strSalesmanCode" => "115"
            ],
            [
                "UserID" => "0",
                "UserName" => "zzJACQUES",
                "strSalesmanCode" => "116"
            ],
            [
                "UserID" => "0",
                "UserName" => "RONEL",
                "strSalesmanCode" => "117"
            ],
            [
                "UserID" => "0",
                "UserName" => "SAMANTHA",
                "strSalesmanCode" => "118"
            ],
            [
                "UserID" => "0",
                "UserName" => "CHARMAINE K",
                "strSalesmanCode" => "119"
            ],
            [
                "UserID" => "0",
                "UserName" => "zzJOHAN",
                "strSalesmanCode" => "120"
            ],
            [
                "UserID" => "0",
                "UserName" => "LULU",
                "strSalesmanCode" => "121"
            ],
            [
                "UserID" => "0",
                "UserName" => "zzJB Vos",
                "strSalesmanCode" => "122"
            ],
            [
                "UserID" => "0",
                "UserName" => "CHANTAL",
                "strSalesmanCode" => "123"
            ],
            [
                "UserID" => "0",
                "UserName" => "BRIAN",
                "strSalesmanCode" => "124"
            ],
            [
                "UserID" => "0",
                "UserName" => "ANEEN",
                "strSalesmanCode" => "125"
            ],
            [
                "UserID" => "0",
                "UserName" => "RIDER",
                "strSalesmanCode" => "126"
            ],
            [
                "UserID" => "0",
                "UserName" => "DANIE",
                "strSalesmanCode" => "127"
            ],
            [
                "UserID" => "0",
                "UserName" => "RVD",
                "strSalesmanCode" => "128"
            ],
            [
                "UserID" => "0",
                "UserName" => "PvA Malawi",
                "strSalesmanCode" => "129"
            ],
            [
                "UserID" => "0",
                "UserName" => "TIM",
                "strSalesmanCode" => "130"
            ],
            [
                "UserID" => "0",
                "UserName" => "SPARE unused",
                "strSalesmanCode" => "131"
            ],
            [
                "UserID" => "0",
                "UserName" => "NELSPRUIT BRANCH - SWAZILAND",
                "strSalesmanCode" => "150"
            ],
            [
                "UserID" => "0",
                "UserName" => "NELSPRUIT BRANCH - NELSPRUIT",
                "strSalesmanCode" => "151"
            ],
            [
                "UserID" => "0",
                "UserName" => "ZZZZZ",
                "strSalesmanCode" => "152"
            ],
            [
                "UserID" => "0",
                "UserName" => "zzDeon",
                "strSalesmanCode" => "155"
            ],
            [
                "UserID" => "0",
                "UserName" => "PAARL HOUSE",
                "strSalesmanCode" => "201"
            ],
            [
                "UserID" => "0",
                "UserName" => "JEAN PAARL",
                "strSalesmanCode" => "207"
            ],
            [
                "UserID" => "0",
                "UserName" => "ALAN Paarl",
                "strSalesmanCode" => "209"
            ],
            [
                "UserID" => "0",
                "UserName" => "zzMALHERBE PAARL",
                "strSalesmanCode" => "210"
            ],
            [
                "UserID" => "0",
                "UserName" => "PvA Agents",
                "strSalesmanCode" => "251"
            ],
            [
                "UserID" => "0",
                "UserName" => "zROLAND SWAZIL",
                "strSalesmanCode" => "350"
            ],
            [
                "UserID" => "0",
                "UserName" => "zROLAND NELSPR",
                "strSalesmanCode" => "351"
            ],
            [
                "UserID" => "0",
                "UserName" => "CASH & CARRY - ARUSHA",
                "strSalesmanCode" => "43"
            ],
            [
                "UserID" => "0",
                "UserName" => "CASH & CARRY - OTHER",
                "strSalesmanCode" => "44"
            ],
            [
                "UserID" => "0",
                "UserName" => "CASH & CARRY - KENNITH",
                "strSalesmanCode" => "45"
            ],
            [
                "UserID" => "0",
                "UserName" => "CASH & CARRY - SANTIE",
                "strSalesmanCode" => "46"
            ],
            [
                "UserID" => "0",
                "UserName" => "CASH & CARRY -  YANDIE",
                "strSalesmanCode" => "47"
            ],
            [
                "UserID" => "0",
                "UserName" => "CASH & CARRY - PATTY",
                "strSalesmanCode" => "48"
            ],
            [
                "UserID" => "0",
                "UserName" => "CASH & CARRY - GREGORY",
                "strSalesmanCode" => "49"
            ]
        ];
        foreach ($saleman as &$item) {
            $item = (object) $item;
        }
        $response = [
            'userPerfomance' => [
                (object) [
                    "NoOfOrders" => "0",
                    "OrderValue" => null,
                    "AvgOrderValue" => null
                ]
            ],
            'trueFalse' => [
                [
                    "ReportType" => "AdminUserDoNotAuthorisePrices",
                    "ReportName" => "True"
                ],
                [
                    "ReportType" => "AllowPastelItemDescriptionUpdate",
                    "ReportName" => "True"
                ],
                [
                    "ReportType" => "blnDoBackOrders",
                    "ReportName" => "True"
                ],
                [
                    "ReportType" => "blnNoFloorPricing",
                    "ReportName" => "true"
                ],
                [
                    "ReportType" => "blnPrintOrder",
                    "ReportName" => "True"
                ],
                [
                    "ReportType" => "blnUsePrintObjectForInvoices",
                    "ReportName" => "True"
                ],
                [
                    "ReportType" => "CUSTOMER DEFAULT ORDERS",
                    "ReportName" => "True"
                ],
                [
                    "ReportType" => "DoBelowMarkupChecks",
                    "ReportName" => "True"
                ],
                [
                    "ReportType" => "DoPalladiumIntegration",
                    "ReportName" => "False"
                ],
                [
                    "ReportType" => "ExportDriversCashOffOnStockMachine",
                    "ReportName" => "False"
                ],
                [
                    "ReportType" => "HasPOS",
                    "ReportName" => "False"
                ],
                [
                    "ReportType" => "MaintainCallList",
                    "ReportName" => "True"
                ],
                [
                    "ReportType" => "ManageCosts",
                    "ReportName" => "True"
                ],
                [
                    "ReportType" => "MapOverallToGroupForSpecials",
                    "ReportName" => "True"
                ],
                [
                    "ReportType" => "MapPastelSpecialsToDims",
                    "ReportName" => "False"
                ],
                [
                    "ReportType" => "MonitorPriceChangesOnly",
                    "ReportName" => "False"
                ],
                [
                    "ReportType" => "PayForDriverCashoff",
                    "ReportName" => "true"
                ],
                [
                    "ReportType" => "ProductLevelCostControl",
                    "ReportName" => "True"
                ],
                [
                    "ReportType" => "ProductLevelPriceControl",
                    "ReportName" => "True"
                ],
                [
                    "ReportType" => "ProductMargins",
                    "ReportName" => "True"
                ],
                [
                    "ReportType" => "PromptForEarlyOrderType",
                    "ReportName" => "False"
                ],
                [
                    "ReportType" => "Send Emergency SMS",
                    "ReportName" => "true"
                ],
                [
                    "ReportType" => "Show Customer Notes",
                    "ReportName" => "True"
                ],
                [
                    "ReportType" => "Stock Advisory",
                    "ReportName" => "True"
                ],
                [
                    "ReportType" => "StoreMassInPastelUserDefFieldNo1",
                    "ReportName" => "False"
                ],
                [
                    "ReportType" => "UpdateOIfilewithMatchReffromTempBatchFile",
                    "ReportName" => "True"
                ],
                [
                    "ReportType" => "UseUnitOfWeight",
                    "ReportName" => "False"
                ],
                [
                    "ReportType" => "WantToCheck",
                    "ReportName" => "False"
                ],
                [
                    "ReportType" => "WEDOCREDITNOTES",
                    "ReportName" => "True"
                ],
                [
                    "ReportType" => "PastelSite",
                    "ReportName" => "False"
                ],
                [
                    "ReportType" => "IQSite",
                    "ReportName" => "True"
                ]
            ],
            'getLastInserted' => [
                [
                    "DeliveryDate" => "2024-05-29",
                    "OrderId" => "360046",
                    "OrderDate" => "2024-05-29"
                ]
            ],
            'marginType' => [
                (object) [
                    "ReportType" => "marginType5",
                    "Comment" => "Authorise any changes"
                ]
            ],
            'deliverTypes' => [
                [
                    "OrderTypeId" => "1",
                    "OrderType" => "Planning"
                ],
                [
                    "OrderTypeId" => "2",
                    "OrderType" => "1stDelivery"
                ],
                [
                    "OrderTypeId" => "3",
                    "OrderType" => "2nd Del"
                ],
                [
                    "OrderTypeId" => "4",
                    "OrderType" => "3rd Del"
                ],
                [
                    "OrderTypeId" => "5",
                    "OrderType" => "4th Del"
                ],
                [
                    "OrderTypeId" => "6",
                    "OrderType" => "5th Del"
                ],
                [
                    "OrderTypeId" => "7",
                    "OrderType" => "6th Del"
                ],
                [
                    "OrderTypeId" => "8",
                    "OrderType" => "7th Del"
                ],
                [
                    "OrderTypeId" => "9",
                    "OrderType" => "8th Del"
                ],
                [
                    "OrderTypeId" => "10",
                    "OrderType" => "9th Del"
                ],
                [
                    "OrderTypeId" => "11",
                    "OrderType" => "10th Del"
                ],
                [
                    "OrderTypeId" => "12",
                    "OrderType" => "11th Del"
                ],
                [
                    "OrderTypeId" => "13",
                    "OrderType" => "12th Del"
                ],
                [
                    "OrderTypeId" => "14",
                    "OrderType" => "13th Del"
                ],
                [
                    "OrderTypeId" => "15",
                    "OrderType" => "test5"
                ],
                [
                    "OrderTypeId" => "16",
                    "OrderType" => "test1"
                ],
                [
                    "OrderTypeId" => "17",
                    "OrderType" => "test2"
                ],
                [
                    "OrderTypeId" => "18",
                    "OrderType" => "test3"
                ],
                [
                    "OrderTypeId" => "19",
                    "OrderType" => "test4"
                ]
            ],
            'getDeliveryDates' =>  [
                [
                    "DeliveryDate" => "2024-01-12"
                ],
                [
                    "DeliveryDate" => "2023-08-22"
                ],
                [
                    "DeliveryDate" => "2023-08-17"
                ],
                [
                    "DeliveryDate" => "2023-03-14"
                ],
                [
                    "DeliveryDate" => "2021-07-10"
                ],
                [
                    "DeliveryDate" => "2020-10-08"
                ],
                [
                    "DeliveryDate" => "2020-09-21"
                ],
                [
                    "DeliveryDate" => "2020-09-16"
                ],
                [
                    "DeliveryDate" => "2020-09-13"
                ],
                [
                    "DeliveryDate" => "2020-09-10"
                ],
                [
                    "DeliveryDate" => "2020-09-09"
                ],
                [
                    "DeliveryDate" => "2020-09-07"
                ],
                [
                    "DeliveryDate" => "2020-09-02"
                ],
                [
                    "DeliveryDate" => "2020-08-31"
                ],
                [
                    "DeliveryDate" => "2020-08-20"
                ],
                [
                    "DeliveryDate" => "2020-08-09"
                ],
                [
                    "DeliveryDate" => "2020-07-28"
                ],
                [
                    "DeliveryDate" => "2020-06-29"
                ],
                [
                    "DeliveryDate" => "2020-06-24"
                ],
                [
                    "DeliveryDate" => "2020-06-23"
                ],
                [
                    "DeliveryDate" => "2020-06-22"
                ],
                [
                    "DeliveryDate" => "2020-06-19"
                ],
                [
                    "DeliveryDate" => "2020-06-18"
                ],
                [
                    "DeliveryDate" => "2020-06-17"
                ],
                [
                    "DeliveryDate" => "2020-06-15"
                ],
                [
                    "DeliveryDate" => "2020-06-12"
                ],
                [
                    "DeliveryDate" => "2020-06-11"
                ],
                [
                    "DeliveryDate" => "2020-06-10"
                ],
                [
                    "DeliveryDate" => "2020-06-09"
                ],
                [
                    "DeliveryDate" => "2020-06-08"
                ],
                [
                    "DeliveryDate" => "2020-06-07"
                ],
                [
                    "DeliveryDate" => "2020-06-05"
                ],
                [
                    "DeliveryDate" => "2020-06-04"
                ],
                [
                    "DeliveryDate" => "2020-06-03"
                ],
                [
                    "DeliveryDate" => "2020-06-02"
                ]
            ],
            'getRoutes' => $getRoutes,
            'saleman' => $saleman,
            'getviewWareHouseLocations' => [
                [
                    "ID" => "1",
                    "locationName" => "001",
                    "Warehouse" => "001"
                ]
            ],
        ];

        return $response;
    }

    public function apiCallListUserInfo()
    {
        $response = [
            [
                "Routeid" => "10",
                "Route" => "GEORGE",
                "od" => "2",
                "dteSessionDate" => "2022-07-15"
            ],
            [
                "Routeid" => "1",
                "Route" => "No Route",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "2",
                "Route" => "BEAUFORT WEST",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "3",
                "Route" => "MOSSELBAY 1",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "4",
                "Route" => "MOSSELBAY 2",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "5",
                "Route" => "COLLECTIONS",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "6",
                "Route" => "COURIER",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "10",
                "Route" => "GEORGE",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "13",
                "Route" => "JEFFREYS BAY",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "14",
                "Route" => "KNYNSA",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "15",
                "Route" => "OUDTSHOORN",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "16",
                "Route" => "PLETTENBERG BAY",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "17",
                "Route" => "RIVERSDALE",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "18",
                "Route" => "SEDGEFIELD",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "23",
                "Route" => "ALBERTINIA",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "24",
                "Route" => "LADISMITH",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "25",
                "Route" => "STAFF",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "26",
                "Route" => "UNIONDALE",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "27",
                "Route" => "OUDTSHOORN2",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "28",
                "Route" => "OUDTSHOORN3",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "29",
                "Route" => "Langkloof District",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "30",
                "Route" => "HEIDELBERG",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "31",
                "Route" => "GREAT BRAK RIVER",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "33",
                "Route" => "KARATARA DISTRICT",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "34",
                "Route" => "Paarl",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "35",
                "Route" => "Nelspruit",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "36",
                "Route" => "REPS",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "37",
                "Route" => "OLD GEORGE ROAD",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "38",
                "Route" => "STILL BAY DISTRICT",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "40",
                "Route" => "THEMBALETHU",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "41",
                "Route" => "PACALTSDORP INDUSTRIAL",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "44",
                "Route" => "HARKERVILLE",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "45",
                "Route" => "SWELLENDAM",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "48",
                "Route" => "test1",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "49",
                "Route" => "test3",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ],
            [
                "Routeid" => "50",
                "Route" => "test4",
                "od" => "1",
                "dteSessionDate" => "1900-01-01"
            ]
        ];
        foreach ($response as &$item) {
            $item = (object) $item;
        }

        return $response;
    }

    public function apiCallListDeliveryDate()
    {
        $response = [
            (object) [
                "dteSessionDate" => "2022-07-15"
            ]
        ];

        return $response;
    }

    public function apiGetSalesOrderCustomers($data)
    {
        $user = auth()->guard('central_api_user')->user();
        $data['companyid'] = $user->company_id;
        $data['UserID'] = $user->erp_user_id;

        return $this->httpRequest('post', 'searchcustomers', $data);
    }

    public function apiGetSalesOrderProducts($data)
    {
        $user = auth()->guard('central_api_user')->user();
        $data['companyid'] = $user->company_id;
        $data['UserID'] = $user->erp_user_id;
        $response = $this->httpRequest('post', 'searchProducts', $data);
        if (!$response) {
            $response = [];
        } elseif ($response && isset($response['PastelCode'])) {
            $response = [$response];
        }
        //Pending From API: we need at the api side like if one record then also we need to merge with array

        return $response;
    }

    public function apiGetThings()
    {
        return 0;
    }
}
