<?php
return [
    'bootstrap' => ['log', 'debug', 'gii'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => \yii\caching\ApcCache::class,
            'useApcu' => true
        ],
    ],
    'modules' => [
        'debug' => [
            'class' => 'yii\debug\Module',
            'traceLine' => '<a href="vscode://open?url=file://{file}&line={line}">{file}:{line}</a>',
            // uncomment and adjust the following to add your IP if you are not connecting from localhost.
            //'allowedIPs' => ['127.0.0.1', '::1'],
            'allowedIPs' => ['*'],
        ],
        'gii' => [
            'class' => 'yii\gii\Module',
            'allowedIPs' => ['*'], // adjust this to your needs
        ],
    ]
];
