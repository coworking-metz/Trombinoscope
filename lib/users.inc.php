<?php

function big($cpt, $total) {
    if($cpt == 0) return 'big';
    // if($cpt == $total-10) return 'big';

    // if(ceil($total/4) == $cpt) return 'big';
    // if($cpt%15 == 0) return 'big';
}
function steps($users) {
    $nb = count($users);

    if($nb>27) {
        return 9;
    }
    if($nb>20) {
        return 8;
    }
    if($nb>10) {
        return 7;
    }
    if($nb>5) {
        return 4;
    }
    return 4;
}

function effectif($users) {
    $nb = count($users);

    if($nb<5) {
        return 'empty';
    }
    if($nb<10) {
        return 'low';
    }
    if($nb<15) {
        return 'average';
    }
    if($nb<20) {
        return 'high';
    }
    if($nb<25) {
        return 'full';
    }
    return 'crazy';
}
function get_user_polaroids($uid, $options=[]) {
    $micro = $options['micro']??true;
    $anonyme = $options['anonyme']??false;
    if($anonyme) {
        $anonyme = 'anonyme/';
    }
    $ret = [
        'big'=> URL_PHOTOS.'polaroid/size/big/'.$anonyme.$uid.'.jpg',
    ];

    if($micro) {
        $ret['micro'] = get_image_content(URL_PHOTOS.'polaroid/size/micro/'.$anonyme.$uid.'.jpg',UN_JOUR);

    }
    return $ret;
}

function get_users($delay=15, $options=[]) {
    $data = get_content('https://tickets.coworking-metz.fr/api/current-members?key=bupNanriCit1&delay='.$delay, 15 * UNE_MINUTE);
    $users = json_decode($data, true);

    foreach($users as &$user){
        $user['polaroids'] = get_user_polaroids($user['wpUserId'],['anonyme'=>$options['anonyme']??false, 'micro'=>$options['micro']??true]);
    }

    shuffle($users);
    return $users;
}