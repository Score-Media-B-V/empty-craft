<?php
/**
 * Yii Application Config
 *
 * Edit this file at your own risk!
 *
 * The array returned by this file will get merged with
 * vendor/craftcms/cms/src/config/app.php and app.[web|console].php, when
 * Craft's bootstrap script is defining the configuration for the entire
 * application.
 *
 * You can define custom modules and system components, and even override the
 * built-in system components.
 *
 * If you want to modify the application config for *only* web requests or
 * *only* console requests, create an app.web.php or app.console.php file in
 * your config/ folder, alongside this one.
 * 
 * Read more about application configuration:
 * https://craftcms.com/docs/4.x/config/app.html
 */

use craft\helpers\App;

return [
    'id' => App::env('CRAFT_APP_ID') ?: 'CraftCMS',
    'components' => [
    'db' => function() {
        // Get the default component config (using values in `db.php`):
        $dbConfig = App::dbConfig();

        // Define the default config for replica connections:
        $dbConfig['replicaConfig'] = [
            'username' => App::env('DB_REPLICA_USER'),
            'password' => App::env('DB_REPLICA_PASSWORD'),
            'tablePrefix' => App::env('DB_TABLE_PREFIX'),
            'attributes' => [
                // Use a smaller connection timeout
                PDO::ATTR_TIMEOUT => 10,
            ],
            'charset' => 'utf8',
        ];

        // Define the replica connections, with unique DSNs:
        $dbConfig['replicas'] = [
            ['dsn' => App::env('DB_REPLICA_DSN_1')],
            ['dsn' => App::env('DB_REPLICA_DSN_2')],
        ];

        // Instantiate and return the configuration object:
        return Craft::createObject($dbConfig);
    }
    ],
];
