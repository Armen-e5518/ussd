<?php
return [
    'components' => [
        'db' => [
          'class' => 'yii\db\Connection',
          'dsn' => 'mysql:host=localhost;dbname=apiccdb',
          'username' => 'apiccdb',
          'password' => 'Kg2_JrN1*d-ZSYf',
          'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
    ],
];
