#!/usr/bin/env php
<?php

include '/srv/ttrss-utils.php';

$confpath = '/var/www/ttrss/config.php';

// use config from ttrss config
require($confpath);
$config = array();
$config['DB_TYPE'] = DB_TYPE;
$config['DB_HOST'] = DB_HOST;
$config['DB_PORT'] = DB_PORT;
$config['DB_NAME'] = DB_NAME;
$config['DB_USER'] = DB_USER;
$config['DB_PASS'] = DB_PASS;

$pdo = dbconnect($config);
try {
    $pdo->query('SELECT 1 FROM plugin_mobilize_feeds');
    // reached this point => table found, assume db is complete
}
catch (PDOException $e) {
    echo 'Database table for mobilize plugin not found, applying schema... ' . PHP_EOL;
    $schema = file_get_contents('/srv/ttrss-plugin-mobilize.'.$db_type);
    $schema = preg_replace('/--(.*?);/', '', $schema);
    $schema = preg_replace('/[\r\n]/', ' ', $schema);
    $schema = trim($schema, ' ;');
    foreach (explode(';', $schema) as $stm) {
        $pdo->exec($stm);
    }
    unset($pdo);
}
