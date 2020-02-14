<?php
return [
    'backend' => [
        'frontName' => 'admin'
    ],
    'crypt' => [
        'key' => 'e493432cfdfa955be79d266a47ab140e'
    ],
    'db' => [
        'table_prefix' => '',
        'connection' => [
            'default' => [
                'host' => 'localhost',
                'dbname' => 'erp',
                'username' => 'root',
                'password' => 'q1w2e3r4',
                'active' => '1'
            ],
            'custom' => [
                'host' => 'localhost',
                'dbname' => 'erp_end',
                'username' => 'root',
                'password' => 'q1w2e3r4',
                'active' => '1'
            ]

        ]
    ],
    'resource' => [
        'default_setup' => [
            'connection' => 'default'
        ],
        'custom' => [
            'connection' => 'custom'
        ]
    ],
    'x-frame-options' => 'SAMEORIGIN',
    'MAGE_MODE' => 'default',
    'session' => [
        'save' => 'files'
    ],
    'cache' => [
        'frontend' => [
            'default' => [
                'id_prefix' => '7ba_'
            ],
            'page_cache' => [
                'id_prefix' => '7ba_'
            ]
        ]
    ],
    'lock' => [
        'provider' => 'db',
        'config' => [
            'prefix' => NULL
        ]
    ],
    'cache_types' => [
        'config' => 1,
        'layout' => 1,
        'block_html' => 1,
        'collections' => 1,
        'reflection' => 1,
        'db_ddl' => 1,
        'compiled_config' => 1,
        'eav' => 1,
        'customer_notification' => 1,
        'config_integration' => 1,
        'config_integration_api' => 1,
        'full_page' => 1,
        'config_webservice' => 1,
        'translate' => 1,
        'vertex' => 1
    ],
    'install' => [
        'date' => 'Wed, 05 Feb 2020 09:45:50 +0000'
    ]
];
