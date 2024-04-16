<?php

function get_reglages() {
    $data = get_content('https://wpapi.coworking-metz.fr/api-json-wp/cowo/v1/trombi', UNE_HEURE);

    $reglages = json_decode($data, true);

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