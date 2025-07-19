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
                'route' => 'dashboard',
                'permission' => null,
            ],
        ],
    ],
    [
        'name' => 'Articles',
        'icon' => 'bx bx-news',
        'route' => 'articles.index',
        'permission' => ['view article'],
    ],
    [
        'name' => 'User Management',
        'icon' => 'bx bx-user-circle',
        'route' => 'dashboard',
        'permission' => ['view permission', 'view role'],
        'sub_menu' => [
            [
                'name' => 'Permissions',
                'icon' => 'bx bx-lock-open',
                'route' => 'permissions.index',
                'permission' => null,
            ],
            [
                'name' => 'Roles',
                'icon' => 'bx bx-id-card',
                'route' => 'roles.index',
                'permission' => null,
            ]
        ],
    ],
];
