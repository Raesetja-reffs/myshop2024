<?php

if (!function_exists('getMenuItems')) {
    function getMenuItems()
    {
        return [
            [
                'name' => 'Extras',
                'icon' => 'ki-outline ki-printer fs-2',
                'submenuitems' => [
                    [
                        'name' => 'Management Console',
                        'icon' => 'fa fa-circle-question fa-lg',
                        'href' => url("/managementSearch"),
                        'windowopen' => [
                            'name' => 'managementSearch',
                            'width' => 1500,
                            'height' => 1250,
                        ]
                    ],
                    [
                        'name' => 'Progress and Status Report',
                        'icon' => 'fa fa-circle-question fa-lg',
                        'href' => url("/viewStatusReport"),
                        'windowopen' => [
                            'name' => 'viewBlockedAccount',
                            'width' => 1800,
                            'height' => 750,
                        ]
                    ]
                ]
            ],
            [
                'name' => 'C-Panel',
                'icon' => 'fa mi-cpanel',
                'submenuitems' => [
                    [
                        'name' => 'Delivery Address Editor',
                        'icon' => 'fa fa-circle-question fa-lg',
                        'href' => url("/deliveryaddresspage"),
                        'windowopen' => [
                            'name' => 'deliveryaddresspage',
                            'width' => 1250,
                            'height' => 1250,
                        ]
                    ],
                    [
                        'name' => 'Users',
                        'icon' => 'fa fa-circle-question fa-lg',
                        'href' => url("/grid_Users"),
                        'windowopen' => [
                            'name' => 'users',
                            'width' => 1250,
                            'height' => 1250,
                        ]
                    ],
                    [
                        'name' => 'Order Locks Deleter',
                        'icon' => 'fa fa-circle-question fa-lg',
                        'href' => url("/getorderlocksdeleterpage"),
                        'windowopen' => [
                            'name' => 'getorderlocksdeleterpage',
                            'width' => 600,
                            'height' => 900,
                        ]
                    ],
                    [
                        'name' => 'User Actions',
                        'icon' => 'fa fa-circle-question fa-lg',
                        'href' => url("/getuseractionsBydate"),
                        'windowopen' => [
                            'name' => 'getuseractionsBydate',
                            'width' => 1200,
                            'height' => 1000,
                        ]
                    ],
                    [
                        'name' => 'Credit Limit Notes',
                        'icon' => 'fa fa-circle-question fa-lg',
                        'href' => url("/viewCreditLimit"),
                        'windowopen' => [
                            'name' => 'creditLimitNotes',
                            'width' => 1200,
                            'height' => 1000,
                        ]
                    ],
                    [
                        'name' => 'Edit Printer Paths',
                        'icon' => 'fa fa-circle-question fa-lg',
                        'href' => url("/PathEditor"),
                        'windowopen' => [
                            'name' => 'PathEditor',
                            'width' => 1000,
                            'height' => 950,
                        ]
                    ],
                    [
                        'name' => 'Deleted Orders',
                        'icon' => 'fa fa-circle-question fa-lg',
                        'href' => url("/viewDeletedOrders"),
                        'windowopen' => [
                            'name' => 'viewDeletedOrders',
                            'width' => 1000,
                            'height' => 950,
                        ]
                    ]
                ]
            ],
            [
                'name' => 'Customers',
                'icon' => 'fa mi-customers',
                'href' => url("/customerflexgrid"),
                'windowopen' => [
                    'name' => 'customerflexgrid',
                    'width' => 1250,
                    'height' => 1250,
                ]
            ],
            [
                'name' => 'SALES',
                'icon' => 'fa mi-checkout',
                'submenuitems' => [
                    [
                        'name' => 'Awaiting Orders',
                        'icon' => 'fa mi-awaiting',
                        'href' => url("/getAwaitingStockbycustomer"),
                        'windowopen' => [
                            'name' => 'getAwaitingStock',
                            'width' => 1500,
                            'height' => 1250,
                        ],
                        'permission_slug' => 'isallowawaitingorders',
                    ],
                    [
                        'name' => 'Awaiting Products',
                        'icon' => 'fa mi-awaiting',
                        'href' => url("/getAwaitingStock"),
                        'windowopen' => [
                            'name' => 'getAwaitingStockgetAwaitingStock',
                            'width' => 1250,
                            'height' => 1250,
                        ],
                        'permission_slug' => 'isallowawaitingproducts',
                    ],
                    [
                        'name' => 'Remote Orders',
                        'icon' => 'fa mi-backorders',
                        'href' => url("/backorders"),
                        'windowopen' => [
                            'name' => 'backorders',
                            'width' => 900,
                            'height' => 900,
                        ],
                        'permission_slug' => 'isallowremoteorders',
                    ],
                    [
                        'name' => 'Customer Sales Trend Report',
                        'icon' => 'fa mi-overallspecials',
                        'href' => url("/customersalespage"),
                        'windowopen' => [
                            'name' => 'salescustomers',
                            'width' => 1200,
                            'height' => 950,
                        ],
                        'permission_slug' => 'isallowcustomersalestrend',
                    ],
                    [
                        'name' => 'Customer Groups',
                        'icon' => 'fa mi-groups',
                        'href' => url("/groups"),
                        'windowopen' => [
                            'name' => 'groups',
                            'width' => 1250,
                            'height' => 1250,
                        ],
                    ],
                    [
                        'name' => 'IsellIt',
                        'icon' => 'fa mi-isellit',
                        'href' => url("/missedvisit"),
                        'windowopen' => [
                            'name' => 'briefcase',
                            'width' => 1650,
                            'height' => 900,
                        ],
                        'permission_slug' => 'isallowisellit',
                    ],
                    [
                        'name' => 'Sales Order/Quote',
                        'icon' => 'fa mi-checkout',
                        'href' => url("/home"),
                        'target' => '_blank'
                    ],
                    [
                        'name' => 'User Sales Performance',
                        'icon' => 'fa mi-salesperfuser',
                        'href' => url("/salesPerformanceview"),
                        'windowopen' => [
                            'name' => 'telesalesperformance',
                            'width' => 1200,
                            'height' => 1000,
                        ]
                    ]
                ]
            ],
            [
                'name' => 'SPECIALS',
                'icon' => 'fa mi-badge',
                'submenuitems' => [
                    [
                        'name' => 'Group Specials',
                        'icon' => 'fa mi-overallspecials',
                        'href' => url("/groupspecials"),
                        'windowopen' => [
                            'name' => 'roupspecials',
                            'width' => 1300,
                            'height' => 1250,
                        ]
                    ],
                    [
                        'name' => 'Overall Specials',
                        'icon' => 'fa mi-overallspecials',
                        'href' => url("/overallspecials"),
                        'windowopen' => [
                            'name' => 'overallspecials',
                            'width' => 1250,
                            'height' => 1250,
                        ],
                        'permission_slug' => 'isallowoverallspecials',
                    ],
                    [
                        'name' => 'Customer Specials',
                        'icon' => 'fa mi-overallspecials',
                        'href' => url("/andNewSpecialKF"),
                        'windowopen' => [
                            'name' => 'massGrid',
                            'width' => 1600,
                            'height' => 800,
                        ]
                    ],
                    [
                        'name' => 'Search Customer Specials',
                        'icon' => 'fa mi-search',
                        'href' => url("/searchSpecialKF"),
                        'windowopen' => [
                            'name' => 'searchSpecialKF',
                            'width' => 1600,
                            'height' => 800,
                        ]
                    ]
                ]
            ],
            [
                'name' => 'WAREHOUSE',
                'icon' => 'fa mi-warehouse',
                'submenuitems' => [
                    [
                        'name' => 'Products',
                        'icon' => 'fa mi-products',
                        'href' => url("/massProducts"),
                        'windowopen' => [
                            'name' => 'massp',
                            'width' => 1250,
                            'height' => 1250,
                        ]
                    ],
                    [
                        'name' => 'Picking Dashboard',
                        'icon' => 'fa mi-webstore',
                        'href' => url("/liveBulkPicking"),
                        'windowopen' => [
                            'name' => 'customerflexgrid',
                            'width' => 1250,
                            'height' => 1250,
                        ]
                    ],
                    [
                        'name' => 'Picking Team',
                        'icon' => 'fa mi-pteams',
                        'href' => url("/pickingteam"),
                        'windowopen' => [
                            'name' => 'pickingteam',
                            'width' => 1250,
                            'height' => 1250,
                        ]
                    ],
                    [
                        'name' => 'Driver BI Report',
                        'icon' => 'fa fa-circle-question fa-lg',
                        'href' => url("/getDriverBIReport"),
                        'windowopen' => [
                            'name' => 'reports',
                            'width' => 1500,
                            'height' => 1000,
                        ],
                        'permission_slug' => 'isallowdriverbireport',
                    ],
                    [
                        'name' => 'Qty Adj Picking',
                        'icon' => 'fa mi-qtyajustments',
                        'href' => url("/qtyadjustmentspicking"),
                        'windowopen' => [
                            'name' => 'qtyadjustmentspicking',
                            'width' => 1250,
                            'height' => 1250,
                        ],
                        'permission_slug' => 'isallowqtyadjpicking',
                    ],
                    [
                        'name' => 'Qty Adj Stage',
                        'icon' => 'fa mi-qtyajustments',
                        'href' => url("/qtyadjustmentsstagingimoveit"),
                        'windowopen' => [
                            'name' => 'qtyadjustmentsstagingimoveit',
                            'width' => 1250,
                            'height' => 1250,
                        ],
                        'permission_slug' => 'isallowqtyadjstage',
                    ],
                    [
                        'name' => 'Transfers',
                        'icon' => 'fa mi-warehousetransfer',
                        'href' => url("/transfersstatus"),
                        'windowopen' => [
                            'name' => 'transfersstatus',
                            'width' => 1600,
                            'height' => 999,
                        ],
                        'permission_slug' => 'isallowtransfers',
                    ]
                ]
            ],
            [
                'name' => 'DISPATCH',
                'icon' => 'fa mi-dispatch',
                'submenuitems' => [
                    [
                        'name' => 'Route Plan',
                        'icon' => 'fa mi-routeplan',
                        'href' => url("/routeplanner"),
                        'target' => '_blank'
                    ],
                    [
                        'name' => 'Drivers Report',
                        'icon' => 'fa mi-driversreport',
                        'href' => url("/driversperformancereport"),
                        'target' => '_blank',
                        'permission_slug' => 'isallowdriversreport',
                    ],
                    [
                        'name' => 'Logistics Plan',
                        'icon' => 'fa mi-routeplan',
                        'href' => url("/ligisticsplan"),
                        'target' => '_blank',
                        'permission_slug' => 'isallowlogisticsplan',
                        'id' => 'logisticsplan',
                    ],
                    [
                        'name' => 'Drivers',
                        'icon' => 'fa mi-driver',
                        'href' => url("/driverspage"),
                        'windowopen' => [
                            'name' => 'driverspage',
                            'width' => 1250,
                            'height' => 1250,
                        ]
                    ],
                    [
                        'name' => 'Trucks',
                        'icon' => 'fa mi-truck',
                        'href' => url("/trucks"),
                        'windowopen' => [
                            'name' => 'trucks',
                            'width' => 1250,
                            'height' => 1250,
                        ]
                    ],
                    [
                        'name' => 'Routes',
                        'icon' => 'fa mi-route',
                        'href' => url("/routes1"),
                        'windowopen' => [
                            'name' => 'routes',
                            'width' => 1250,
                            'height' => 1250,
                        ]
                    ],
                    [
                        'name' => 'iMoveIt PODs',
                        'icon' => 'fa mi-contract',
                        'href' => url("/driverspdfdocs"),
                        'windowopen' => [
                            'name' => 'routes',
                            'width' => 1250,
                            'height' => 1250,
                        ],
                        'permission_slug' => 'isallowimoveitpod',
                    ],
                    [
                        'name' => 'Delivery Current Stats',
                        'icon' => 'fa mi-fleet',
                        'href' => url("/liveFleetDeliveries"),
                        'windowopen' => [
                            'name' => 'fleet',
                            'width' => 1500,
                            'height' => 1250,
                        ],
                        'permission_slug' => 'isallowdeliverycurrentstats',
                    ],
                    [
                        'name' => 'Number Of Deliveries',
                        'icon' => 'fa mi-box',
                        'href' => url("/noOfStops"),
                        'windowopen' => [
                            'name' => 'noofdel',
                            'width' => 1500,
                            'height' => 1250,
                        ],
                        'permission_slug' => 'isallownumberofdeliveries',
                    ]
                ]
            ],
            [
                'name' => 'E-Commerce',
                'icon' => 'fa mi-smartphone',
                'submenuitems' => [
                    [
                        'name' => 'Web Store',
                        'icon' => 'fa mi-webstore',
                        'href' => url("/webstore"),
                        'windowopen' => [
                            'name' => 'webstore',
                            'width' => 900,
                            'height' => 900,
                        ]
                    ],
                    [
                        'name' => 'Remote Orders',
                        'icon' => 'fa mi-smartphone',
                        'href' => url("/remoteorders"),
                        'windowopen' => [
                            'name' => 'webstore',
                            'width' => 900,
                            'height' => 900,
                        ]
                    ]
                ],
                'permission_slug' => 'isallowecommerce',
            ],
            [
                'name' => 'Company Permissions',
                'icon' => 'ki-outline ki-key-square fs-2',
                'href' => route('company-permissions.set-permissions'),
            ],
        ];
    }
}

if (!function_exists('getNavBarItems')) {
    function getNavBarItems()
    {
        return [
            [
                'name' => 'Dashboard',
                'route' => 'home',
                'isLink' => true,
            ],
            [
                'name' => 'Order Listing',
                'route' => '',
                'id' => 'orderListing',
            ],
            [
                'name' => 'REPORTS',
                'route' => '',
                'id' => 'reports',
                'menu_item_style' => 'display: none;'
            ],
            [
                'name' => 'Price Check',
                'route' => '',
                'id' => 'pricing'
            ],
            [
                'name' => 'PL',
                'route' => '',
                'id' => 'pricingOnCustomer'
            ],
            [
                'name' => 'Call List',
                'route' => '',
                'id' => 'callList'
            ],
            [
                'name' => 'Reprint',
                'route' => '',
                'id' => 'tabletLoadingApp',
                'menu_item_style' => 'display: none;'
            ],
            [
                'name' => 'Sales Quotes',
                'route' => '',
                'id' => 'salesQuotebtn',
                'menu_item_style' => 'display: none;'
            ],
            [
                'name' => 'Copy Orders',
                'route' => '',
                'id' => 'copyOrdersBtn',
                'menu_item_style' => 'display: none;'
            ],
            [
                'name' => 'Route Plan',
                'route' => '',
                'id' => 'routePlanning',
                'menu_item_style' => 'display: none;'
            ],
            [
                'name' => 'On Order',
                'route' => '',
                'id' => 'salesOnOrder'
            ],
            [
                'name' => 'On Invoice',
                'route' => '',
                'id' => 'salesInvoiced'
            ],
            [
                'name' => 'Cash Up',
                'route' => '',
                'id' => 'posCashUp'
            ],
            [
                'name' => 'Price List',
                'route' => '',
                'id' => 'pricelist',
                'menu_item_style' => 'display: none;'
            ],
            [
                'name' => 'Returns',
                'route' => '',
                'id' => 'returns',
                'menu_item_style' => 'display: none;'
            ],
        ];
    }
}
