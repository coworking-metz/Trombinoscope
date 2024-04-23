<?php


if(isset($_GET['debug'])) {
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');
}

// require 'vendor/autoload.php';


define('URL_SITE',(empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]/");
define('CHEMIN_SITE',realpath(__DIR__.'/..').'/');

$envFile = CHEMIN_SITE.'.env';

$env = parse_ini_file($envFile);

define('REDIS_SERVER',$env['REDIS_SERVER']??'127.0.0.1');
define('URL_PHOTOS',$env['URL_PHOTOS']??'https://photos.coworking-metz.fr/');
define('TICKET_TOKEN',$env['TICKET_TOKEN']??'');


define('UNE_MINUTE',60);
define('CINQ_MINUTES',5*UNE_MINUTE);
define('UNE_HEURE',60 * UNE_MINUTE);
define('UN_JOUR',24 * UNE_HEURE);

include 'utils.inc.php';
include 'svg.class.php';
include 'reglages.inc.php';
include 'cache.inc.php';
include 'redis.inc.php';
include 'users.inc.php';
