<?php

return [
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