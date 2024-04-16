<?php

function redis_connect() {
    if(!isset($GLOBALS['redis-instance'])) {
        $redis = new Redis();
        $redis->connect(REDIS_SERVER, 6379);
        $redis->select(4);
        $GLOBALS['redis-instance'] = $redis;
    }
    return $GLOBALS['redis-instance'];
}

function redis_set($cle, $valeur,$expire=null) {
    $redis = redis_connect();

    if($expire) {
        return $redis->setex($cle, $expire, $valeur);
    } else {
        return $redis->set($cle, $valeur);
    }
}

function redis_get($cle) {
    $redis = redis_connect();
    return $redis->get($cle);
}
