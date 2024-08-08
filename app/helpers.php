<?php

if (!function_exists('getMenuItems')) {
    function getMenuItems()
    {
        $menuItems = [
            [
                'name' => 'Extras',
                'icon' => 'ki-outline ki-folder-added fs-2',
                'submenuitems' => [
                    [
                        'name' => 'Management Console',
                        'icon' => 'ki-outline ki-underlining fs-2',
                        'href' => url("/managementSearch"),
                        'windowopen' => [
                            'name' => 'managementSearch',
                            'width' => 1500,
                            'height' => 1250,
                        ]
                    ],
                    [
                        'name' => 'Progress & Status Report',
                        'icon' => 'ki-outline ki-loading fs-2',
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
                'icon' => 'ki-outline ki-setting fs-2',
                'submenuitems' => [
                    [
                        'name' => 'Delivery Address Editor',
                        'icon' => 'ki-outline ki-delivery-geolocation fs-2',
                        'href' => url("/deliveryaddresspage"),
                        'windowopen' => [
                            'name' => 'deliveryaddresspage',
                            'width' => 1250,
                            'height' => 1250,
                        ]
                    ],
                    [
                        'name' => 'Users',
                        'icon' => 'ki-outline ki-people fs-2',
                        'href' => url("/grid_Users"),
                        'windowopen' => [
                            'name' => 'users',
                            'width' => 1250,
                            'height' => 1250,
                        ]
                    ],
                    [
                        'name' => 'Order Locks Deleter',
                        'icon' => 'ki-outline ki-lock fs-2',
                        'href' => url("/getorderlocksdeleterpage"),
                        'windowopen' => [
                            'name' => 'getorderlocksdeleterpage',
                            'width' => 600,
                            'height' => 900,
                        ]
                    ],
                    [
                        'name' => 'User Actions',
                        'icon' => 'ki-outline ki-user-tick fs-2',
                        'href' => url("/getuseractionsBydate"),
                        'windowopen' => [
                            'name' => 'getuseractionsBydate',
                            'width' => 1200,
                            'height' => 1000,
                        ]
                    ],
                    [
                        'name' => 'Credit Limit Notes',
                        'icon' => 'ki-outline ki-credit-cart fs-2',
                        'href' => url("/viewCreditLimit"),
                        'windowopen' => [
                            'name' => 'creditLimitNotes',
                            'width' => 1200,
                            'height' => 1000,
                        ]
                    ],
                    [
                        'name' => 'Edit Printer Paths',
                        'icon' => 'ki-outline ki-printer fs-2',
                        'href' => url("/PathEditor"),
                        'windowopen' => [
                            'name' => 'PathEditor',
                            'width' => 1000,
                            'height' => 950,
                        ]
                    ],
                    [
                        'name' => 'Deleted Orders',
                        'icon' => 'ki-outline ki-trash fs-2',
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
                'icon' => 'ki-outline ki-user fs-2',
                'submenuitems' => [
                    [
                        'name' => 'Customer Listing',
                        'icon' => 'ki-outline ki-search-list fs-2',
                        'href' => url("/customerflexgrid"),
                        'windowopen' => [
                            'name' => 'customerflexgrid',
                            'width' => 1250,
                            'height' => 1250,
                        ]
                    ],
                    [
                        'name' => 'Push Products',
                        'icon' => 'ki-outline ki-arrow-up-refraction fs-2',
                        'href' => url("/productOnPush/0"),
                        'windowopen' => [
                            'name' => 'pushproducts',
                            'width' => 1250,
                            'height' => 1250,
                        ]
                    ],
                    [
                        'name' => 'Prohibit Products',
                        'icon' => 'ki-outline ki-arrow-down-refraction fs-2',
                        'href' => url("/productOnprohibit/0"),
                        'windowopen' => [
                            'name' => 'prohibitproducts',
                            'width' => 1250,
                            'height' => 1250,
                        ]
                    ],
                ]
            ],
            [
                'name' => 'Sales',
                'icon' => 'ki-outline ki-handcart fs-2',
                'submenuitems' => [
                    [
                        'name' => 'Awaiting Orders',
                        'icon' => 'ki-outline ki-brifecase-timer fs-2',
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
                        'icon' => 'ki-outline ki-time fs-2',
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
                        'icon' => 'ki-outline ki-cloud fs-2',
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
                        'icon' => 'ki-outline ki-discount fs-2',
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
                        'icon' => 'ki-outline ki-people fs-2',
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
                        'name' => 'Price List Printing',
                        'icon' => 'ki-outline ki-discount fs-2',
                        'href' => url("/searchcustomerpricing"),
                        'windowopen' => [
                            'name' => 'pricelistprinting',
                            'width' => 1200,
                            'height' => 950,
                        ],
                    ],
                    [
                        'name' => 'Sales Order/Quote',
                        'icon' => 'ki-outline ki-handcart fs-2',
                        'href' => url("/home"),
                        'target' => '_blank'
                    ],
                    [
                        'name' => 'User Sales Performance',
                        'icon' => 'ki-outline ki-chart-line-up fs-2',
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
                'name' => 'Specials',
                'icon' => 'ki-outline ki-discount fs-2',
                'submenuitems' => [
                    [
                        'name' => 'Group Specials',
                        'icon' => 'ki-outline ki-discount fs-2',
                        'href' => url("/groupSpecials"),
                        'windowopen' => [
                            'name' => 'groupspecials',
                            'width' => 1300,
                            'height' => 1250,
                        ]
                    ],
                    [
                        'name' => 'Overall Specials',
                        'icon' => 'ki-outline ki-discount fs-2',
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
                        'icon' => 'ki-outline ki-discount fs-2',
                        'href' => url("/customerSpecials"),
                        'windowopen' => [
                            'name' => 'massGrid',
                            'width' => 1600,
                            'height' => 800,
                        ]
                    ],
                    [
                        'name' => 'Search Customer Specials',
                        'icon' => 'ki-outline ki-filter-search fs-2',
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
                'name' => 'Warehouse',
                'icon' => 'ki-outline ki-home fs-2',
                'submenuitems' => [
                    [
                        'name' => 'Products',
                        'icon' => 'ki-outline ki-parcel fs-2',
                        'href' => url("/massProducts"),
                        'windowopen' => [
                            'name' => 'massp',
                            'width' => 1250,
                            'height' => 1250,
                        ]
                    ],
                    [
                        'name' => 'Picking Dashboard',
                        'icon' => 'ki-outline ki-parcel-tracking fs-2',
                        'href' => url("/liveBulkPicking"),
                        'windowopen' => [
                            'name' => 'customerflexgrid',
                            'width' => 1250,
                            'height' => 1250,
                        ]
                    ],
                    [
                        'name' => 'Picking Team',
                        'icon' => 'ki-outline ki-courier fs-2',
                        'href' => url("/pickingteam"),
                        'windowopen' => [
                            'name' => 'pickingteam',
                            'width' => 1250,
                            'height' => 1250,
                        ]
                    ],
                    [
                        'name' => 'Stock Take',
                        'icon' => 'ki-outline ki-logistic fs-2',
                        'href' => url("/stocktake"),
                        'windowopen' => [
                            'name' => 'stocktake',
                            'width' => 1250,
                            'height' => 1250,
                        ]
                    ],
                    [
                        'name' => 'Driver BI Report',
                        'icon' => 'ki-outline ki-delivery fs-2',
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
                        'icon' => 'ki-outline ki-plus-circle fs-2',
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
                        'icon' => 'ki-outline ki-plus-circle fs-2',
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
                        'icon' => 'ki-outline ki-arrow-mix fs-2',
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
                'name' => 'Dispatch',
                'icon' => 'ki-outline ki-delivery fs-2',
                'submenuitems' => [
                    [
                        'name' => 'Route Plan',
                        'icon' => 'ki-outline ki-route fs-2',
                        'href' => url("/routeplanner"),
                        'target' => '_blank'
                    ],
                    [
                        'name' => 'Drivers Report',
                        'icon' => 'ki-outline ki-delivery-time fs-2',
                        'href' => url("/driversperformancereport"),
                        'target' => '_blank',
                        'permission_slug' => 'isallowdriversreport',
                    ],
                    [
                        'name' => 'Logistics Plan',
                        'icon' => 'ki-outline ki-technology-4 fs-2',
                        'href' => url("/logisticsPlan"),
                        'target' => '_blank',
                        'permission_slug' => 'isallowlogisticsplan',
                        'id' => 'logisticsplan',
                    ],
                    [
                        'name' => 'Drivers',
                        'icon' => 'ki-outline ki-people fs-2',
                        'href' => url("/driverspage"),
                        'windowopen' => [
                            'name' => 'driverspage',
                            'width' => 1250,
                            'height' => 1250,
                        ]
                    ],
                    [
                        'name' => 'Trucks',
                        'icon' => 'ki-outline ki-delivery fs-2',
                        'href' => url("/trucks"),
                        'windowopen' => [
                            'name' => 'trucks',
                            'width' => 1250,
                            'height' => 1250,
                        ]
                    ],
                    [
                        'name' => 'Routes',
                        'icon' => 'ki-outline ki-address-book fs-2',
                        'href' => url("/routes1"),
                        'windowopen' => [
                            'name' => 'routes',
                            'width' => 1250,
                            'height' => 1250,
                        ]
                    ],
                    [
                        'name' => 'iMoveIt PODs',
                        'icon' => 'ki-outline ki-note-2 fs-2',
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
                        'icon' => 'ki-outline ki-chart-simple fs-2',
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
                        'icon' => 'ki-outline ki-folder-added fs-2',
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
                'icon' => 'ki-outline ki-basket-ok fs-2',
                'submenuitems' => [
                    [
                        'name' => 'Web Store',
                        'icon' => 'ki-outline ki-icon fs-2',
                        'href' => url("/webstore"),
                        'windowopen' => [
                            'name' => 'webstore',
                            'width' => 900,
                            'height' => 900,
                        ]
                    ],
                    [
                        'name' => 'Remote Orders',
                        'icon' => 'ki-outline ki-cloud-add fs-2',
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
        ];
        if (config('app.IS_API_BASED')
            && auth()->guard('central_api_user')->user()->can('index', App\Models\CentralUser::class)) {
            $menuItems = array_merge($menuItems, [
                [
                    'name' => 'Users',
                    'icon' => 'ki-outline ki-people fs-2',
                    'submenuitems' => [
                        [
                            'name' => 'Add User',
                            'icon' => 'ki-outline ki-minus fs-2',
                            'href' => route('central-users.create'),
                            'target' => '',
                        ],
                        [
                            'name' => 'Users Listing',
                            'icon' => 'ki-outline ki-minus fs-2',
                            'href' => route('central-users.index'),
                            'target' => '',
                        ]
                    ]
                ]
            ]);
        }
        if (!config('app.IS_API_BASED')
            || (
                config('app.IS_API_BASED')
                && auth()->guard('central_api_user')->user()
                && auth()->guard('central_api_user')->user()->isSuperAdmin()
            )
        ) {
            $menuItems = array_merge($menuItems, [
                [
                    'name' => 'Report Builder Files',
                    'icon' => 'ki-outline ki-row-horizontal fs-2',
                    'submenuitems' => [
                        [
                            'name' => 'Add Report Builder File',
                            'icon' => 'ki-outline ki-minus fs-2',
                            'href' => route('report-builder-files.create'),
                            'target' => '',
                        ],
                        [
                            'name' => 'Report Builder Files Listing',
                            'icon' => 'ki-outline ki-minus fs-2',
                            'href' => route('report-builder-files.index'),
                            'target' => '',
                        ]
                    ]
                ]
            ]);
            $menuItems = array_merge($menuItems, [
                [
                    'name' => 'Company Permissions',
                    'icon' => 'ki-outline ki-key-square fs-2',
                    'href' => route('company-permissions.index'),
                ],
            ]);
            $menuItems = array_merge($menuItems, [
                [
                    'name' => 'Groups',
                    'icon' => 'ki-outline ki-abstract-33 fs-2',
                    'submenuitems' => [
                        [
                            'name' => 'Add Group',
                            'icon' => 'ki-outline ki-minus fs-2',
                            'href' => route('groups.create'),
                            'target' => '',
                        ],
                        [
                            'name' => 'Groups Listing',
                            'icon' => 'ki-outline ki-minus fs-2',
                            'href' => route('groups.index'),
                            'target' => '',
                        ]
                    ]
                ]
            ]);
        }

        return $menuItems;
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

if (!function_exists('hasThingRole')) {
    function hasThingRole($thing)
    {
        return (new \App\Http\Controllers\SalesForm())->commonGetThings($thing);
    }
}

if (!function_exists('viewCheckCompanyPermission')) {
    function viewCheckCompanyPermission($companyRoleSlug)
    {
        $controllerInstance = (new \App\Http\Controllers\SalesForm());

        return $controllerInstance->checkCompanyPermission($companyRoleSlug);
    }
}
