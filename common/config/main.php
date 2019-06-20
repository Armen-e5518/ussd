<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=ussd',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
        'i18n' => [
            'translations' => [
                'api*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@common/messages',
                ],
            ],
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
];
