<?php

return [
    'images' => [
        'disk'            => 'public',
        'storage_prefix'  => '/storage/',
        'use_full_url'    => true,
        'placeholder'     => 'images/placeholder.jpg',
    ],

    'seo' => [
        'slug' => [
            'product' => [
                'from' => 'title',
                'to' => 'slug',
                'separator' => '-',
                'creation' => [
                    'disable-on-creation' => false,
                    'disable-on-change' => true,
                ],
            ],

            'category' => [
                'from' => 'name',
                'to' => 'slug',
                'separator' => '-',
                'creation' => [
                    'disable-on-creation' => false,
                    'disable-on-change' => true,
                ],
            ],
        ],
    ],
];