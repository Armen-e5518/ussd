<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/params.php')
//    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'en-EN',
    'controllerNamespace' => 'api\controllers',
    'defaultRoute' => 'api',
    'modules' => [
        'v1' => [
            'basePath' => '@api/modules/v1',
            'class' => 'api\modules\v1\Module'
        ]
    ],
    'components' => [
        'user' => [
            'identityClass' => 'api\models\User',
            'enableAutoLogin' => false,
            'enableSession' => false,
            'loginUrl' => null,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/user',
                    'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ],
                    'extraPatterns' => [
                        'POST create-user' => 'create-user',
                        'POST update-user-preview' => 'update-user-preview',
                        'POST update-user' => 'update-user',
                        'POST login' => 'login',
                        'GET search-friend' => 'search-friend',
                        'GET get-user' => 'get-user',
                        'GET show-user-profile/{id}' => 'show-user-profile',
                        'GET get-badges' => 'get-badges',
                        'POST request-recovery-password' => 'request-recovery-password',
                        'POST request-reset-password' => 'request-reset-password',
                        'POST auth-with-fb' => 'auth-with-facebook',
                        'GET get-all-users' => 'get-all-users', /** @package SOCIAL_APP */
                        'GET get-incoming-users' => 'get-incoming-users',/** @package SOCIAL_APP */
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/participations',   // our country api rule,
                    'extraPatterns' => [
                        'GET aaa' => 'aaa',
                        'POST add-new' => 'add-new',
                        'GET get-status' => 'get-status',
                        'GET get-results-by-party-and-date' => 'get-results-by-party-and-date',
                        'GET get-results-by-status' => 'get-results-by-status',
                        'GET get-current-game-result' => 'get-current-game-result', //GetCurrentGameResult
                        'POST cancel' => 'cancel',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/contact',   // our country api rule,
                    'extraPatterns' => [
                        'GET index' => 'index',
                        'GET get-contacts' => 'get-contacts',
                        'POST add-contact' => 'add-contact',
                    ],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'v1/notifications',   // our country api rule,
                    'extraPatterns' => [
                        'GET get-notifications' => 'get-notifications',
                        'POST delete-not' => 'delete-not',
                    ],
                ],
                '<action:[\w\-]+>' => 'api/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                '' => ''
            ],
        ],
        'request' => [
            'baseUrl' => '/api',
            'enableCookieValidation' => false,
            'parsers' => [
                'multipart/form-data' => 'yii\web\MultipartFormDataParser'
            ],
        ],
        'response' => [
            'class' => 'yii\web\Response',
            'formatters' => [
                \yii\web\Response::FORMAT_JSON => [
                    'class' => 'yii\web\JsonResponseFormatter',
                    'prettyPrint' => YII_DEBUG, // use "pretty" output in debug mode
                    'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
                ],
            ],
            'format' => \yii\web\Response::FORMAT_JSON,
        ]

    ],
    'params' => $params,
];