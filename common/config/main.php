<?php

return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'formatter' => ['class' => 'yii\i18n\Formatter', 'nullDisplay' => '-'],
         
    ],
    'modules' => [
        'gridview' => [
            'class' => 'kartik\grid\Module'
        ],
        'promote' => [
            'class' => 'frontend\modules\promote\Promote',
        ],
    ],
    'language' => 'th'
];
