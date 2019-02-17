#!/usr/bin/env php
<?php

include '/srv/ttrss-utils.php';

$confpath = '/var/www/ttrss/config.php';

// use config from ttrss config
require($confpath);
$config = array();

$config['SMTP_SERVER'] = env('SMTP_SERVER', '');
// Hostname:port combination to send outgoing mail (i.e. localhost:25).
// Blank - use system MTA.

$config['SMTP_LOGIN'] = env('SMTP_LOGIN', '');
$config['SMTP_PASSWORD'] = env('SMTP_PASSWORD', '');
// These two options enable SMTP authentication when sending
// outgoing mail. Only used with SMTP_SERVER.

$config['SMTP_SECURE'] = env('SMTP_SECURE', '');
// Used to select a secure SMTP connection. Allowed values: ssl, tls,
// or empty.

$config['SMTP_SKIP_CERT_CHECKS'] = env('SMTP_SKIP_CERT_CHECKS', false);
// Accept all SSL certificates, use with caution.

foreach ($config as $name => $value) {
    if (!is_bool($value) && !in_array($value, ['true', 'false', '0', '1'])) {
        $value = '"' . $value . '"';
    }
    $contents = $contents . "\n\n" . "define('{$name}', )";
}
file_put_contents($conffile, $contents);
