<?php

return [
    [
        'name' => 'Dashboards',
        'icon' => 'bx bx-grid-alt',
        'route' => '',
        'permission' => null,
        'sub_menu' => [
            [
                'name' => 'Table',
                'icon' => 'bx bx-table',
                'route' => 'user.table.index',
                'permission' => null,
            ],
        ],
    ],
    [
        'name' => 'Articles',
        'icon' => 'bx bx-news',
        'route' => null,
        'permission' => ['view articles'],
    ],
    [
        'name' => 'User Management',
        'icon' => 'bx bx-user-circle',
        'route' => 'dashboard',
        'permission' => null,
        'sub_menu' => [
            [
                'name' => 'Permissions',
                'icon' => 'bx bx-lock-open',
                'route' => 'user.table.index',
                'permission' => null,
            ],
            [
                'name' => 'Roles',
                'icon' => 'bx bx-id-card',
                'route' => 'user.table.index',
                'permission' => null,
            ]
        ],
    ],
];
