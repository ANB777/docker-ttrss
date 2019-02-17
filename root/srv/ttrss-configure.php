#!/usr/bin/env php
<?php

include '/srv/ttrss-utils.php';

if (!env('TTRSS_PATH', ''))
    $confpath = '/var/www/ttrss/';
$conffile = $confpath . 'config.php';

$available_env = [

];

$config = array();
foreach ($available_env as $env_name) {
    // check if ENV variable exis. if they do use them
    if (!!env($env_name, '')) {
        $config[$env_name] = env($env_name);
    }
}

$contents = file_get_contents($conffile);
foreach ($config as $name => $value) {
    $contents = preg_replace('/(define\s*\(\'' . $name . '\',\s*)(.*)(\);)/', '$1"' . $value . '"$3', $contents);
}
file_put_contents($conffile, $contents);
