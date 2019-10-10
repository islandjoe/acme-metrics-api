<?php

define('ENVIRONMENT', 'development');

if (ENVIRONMENT == 'development' || ENVIRONMENT == 'dev')
{
    error_reporting(E_ALL);
    ini_set("display_errors", 1);
}

const URL_PUBLIC_FOLDER = 'public';
const URL_PROTOCOL      = '//';

define('URL_DOMAIN', $_SERVER['HTTP_HOST']);

$dir    = dirname($_SERVER['SCRIPT_NAME']);
$subdir = str_replace(URL_PUBLIC_FOLDER, '', $dir);
define('URL_SUB_FOLDER',$subdir);

$well_formed_path = URL_PROTOCOL . URL_DOMAIN . URL_SUB_FOLDER;
define('URL', $well_formed_path);
