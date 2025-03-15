<?php

$environment = Dotenv\Dotenv::createUnsafeMutable(__DIR__ . '/..')->load();
$dbName = $environment['POSTGRESQL_DATABASE'];
$dbUsername = $environment['POSTGRESQL_USERNAME'];
$dbPassword = $environment['POSTGRESQL_PASSWORD'];
$host = "database";

if (YII_ENV_PROD) {
    return [
        'class' => 'yii\db\Connection',
        'dsn' => "pgsql:host={$host};port=5432;dbname={$dbName}",
        'username' => $dbUsername,
        'password' => $dbPassword,
        'charset' => 'utf8',
        'enableSchemaCache' => true,
        'schemaCacheDuration' => 3600,
        'schemaCache' => 'cache',
    ];
} else {
    return [
        'class' => 'yii\db\Connection',
        'dsn' => "pgsql:host={$host};port=5432;dbname={$dbName}",
        'username' => $dbUsername,
        'password' => $dbPassword,
        'charset' => 'utf8',
        // Schema cache options (for production environment)
        //'enableSchemaCache' => true,
        //'schemaCacheDuration' => 60,
        //'schemaCache' => 'cache',
    ];
}

