#!/usr/bin/env php
<?php

include '/srv/ttrss-utils.php';

$confpath = env('TTRSS_PATH', '/var/www/ttrss').'/';
$conffile = $confpath . 'config.php';

$allowed_env = [
    'SINGLE_USER_MODE',
    'SIMPLE_UPDATE_MODE',
    'LOCK_DIRECTORY',
    'CACHE_DIR',
    'ICONS_DIR',
    'ICONS_URL',
    'AUTH_AUTO_CREATE',
    'AUTH_AUTO_LOGIN',
    'FORCE_ARTICLE_PURGE',
    'SPHINX_SERVER',
    'SPHINX_INDEX',
    'ENABLE_REGISTRATION',
    'REG_NOTIFY_ADDRESS',
    'REG_MAX_USERS',
    'SESSION_COOKIE_LIFETIME',
    'SMTP_FROM_NAME',
    'SMTP_FROM_ADDRESS',
    'DIGEST_SUBJECT',
    'CHECK_FOR_UPDATES',
    'ENABLE_GZIP_OUTPUT',
    'PLUGINS',
    'LOG_DESTINATION',
];

$config = array();
foreach ($allowed_env as $env_name) {
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
