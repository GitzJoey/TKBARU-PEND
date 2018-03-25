<?php

return [
    'role_structure' => [
        'administrator' => [
            'users' => 'c,r,u,d,m',
            'roles' => 'c,r,u,d,m',
            'company' => 'c,r,u,d,m',
            'currencies' => 'c,r,u,d,m',
            'phoneprovider' => 'c,r,u,d,m',
            'customer' => 'c,r,u,d,m',
            'customer_confirmation' => 'r,u,m',
            'supplier' => 'c,r,u,d,m',
            'product' => 'c,r,u,d,m',
            'employee' => 'c,r,u,d,m',
            'employee_salary' => 'c,r,u,d,m',
            'warehouse' => 'c,r,u,d,m',
            'bank' => 'c,r,u,d,m',
            'truck' => 'c,r,u,d,m',
            'truck_maintenance' => 'c,r,u,d,m',
            'trucking_vendor' => 'c,r,u,d,m',
            'po' => 'c,r,u,d,m',
            'po_revise' => 'r,u,d,m',
            'po_payment' => 'c,r,u,d,m',
            'po_copy' => 'c,r,u,d,m',
            'so' => 'c,r,u,d,m',
            'so_revise' => 'r,u,d,m',
            'so_payment' => 'c,r,u,d,m',
            'so_copy' => 'c,r,u,d,m',
            'today_price' => 'c,r,m',
            'price_level' => 'c,r,u,d,m',
            'warehouse_inflow' => 'c,r,u,d,m',
            'warehouse_outflow' => 'c,r,u,d,m',
            'stock_opname' => 'c,r,m',
            'stock_transfer' => 'c,r,,m',
            'stock_merger' => 'c,r,m',
            'bank_upload' => 'c,r,m',
            'bank_consolidate' => 'c,r,u,d,m',
            'rpt_daily' => 'r,m',
            'rpt_montly' => 'r,m',
            'rpt_quarterly' => 'r,m',
            'rpt_yearly' => 'r,m',
            'tax_input' => 'c,r,u.d,m',
            'tax_output' => 'c,r,u.d,m',
            'tax_generate' => 'c,r,m',
        ],
        'user' => [
            'currencies' => 'c,r,u,d,m',
            'phoneprovider' => 'c,r,u,d,m',
            'customer' => 'c,r,u,d,m',
            'customer_confirmation' => 'r,u,m',
            'supplier' => 'c,r,u,d,m',
            'product' => 'c,r,u,d,m',
            'employee' => 'c,r,u,d,m',
            'employee_salary' => 'c,r,u,d,m',
            'warehouse' => 'c,r,u,d,m',
            'bank' => 'c,r,u,d,m',
            'truck' => 'c,r,u,d,m',
            'truck_maintenance' => 'c,r,u,d,m',
            'trucking_vendor' => 'c,r,u,d,m',
            'po' => 'c,r,u,d,m',
            'po_revise' => 'r,u,d,m',
            'po_payment' => 'c,r,u,d,m',
            'po_copy' => 'c,r,u,d,m',
            'so' => 'c,r,u,d,m',
            'so_revise' => 'r,u,d,m',
            'so_payment' => 'c,r,u,d,m',
            'so_copy' => 'c,r,u,d,m',
            'today_price' => 'c,r,m',
            'price_level' => 'c,r,u,d,m',
            'warehouse_inflow' => 'c,r,u,d,m',
            'warehouse_outflow' => 'c,r,u,d,m',
            'stock_opname' => 'c,r,m',
            'stock_transfer' => 'c,r,,m',
            'stock_merger' => 'c,r,m',
            'bank_upload' => 'c,r,m',
            'bank_consolidate' => 'c,r,u,d,m',
            'rpt_daily' => 'r,m',
            'rpt_montly' => 'r,m',
            'rpt_quarterly' => 'r,m',
            'rpt_yearly' => 'r,m',
            'tax_input' => 'c,r,u.d,m',
            'tax_output' => 'c,r,u.d,m',
            'tax_generate' => 'c,r,m',
        ],
    ],
    'permission_structure' => [
    ],
    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
        'm' => 'menu'
    ]
];
