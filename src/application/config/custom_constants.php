<?php
defined('BASEPATH') or exit('No direct script access allowed');

$config['auth'] = array(
    'LOGGED_USER'                => 'logged_user',
);

$config['host'] = array(
    'CLIENT_HOST' => getenv('CLIENT_HOST')
);
