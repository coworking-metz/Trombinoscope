<?php

function get_reglages() {
    if(isset($GLOBALS['get_reglages'])) return $GLOBALS['get_reglages'];
    $data = file_get_contents('https://www.coworking-metz.fr/api-json-wp/cowo/v1/trombi');

    $reglages = json_decode($data, true);

    $GLOBALS['get_reglages'] = $reglages;
    return $reglages;
}

function get_reglage($keys,$default=false) {

    $keys = explode('/',$keys);
    $ret = get_reglages();

    foreach($keys as $key) {
        $ret = $ret[$key]??false;
    }
    if(empty($ret)) return $default;

    return $ret;
}