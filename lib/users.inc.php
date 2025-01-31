<?php

function big($cpt, $total)
{
    if ($cpt == 0) return 'big';
    // if($cpt == $total-10) return 'big';

    // if(ceil($total/4) == $cpt) return 'big';
    // if($cpt%15 == 0) return 'big';
}
function steps($users)
{
    $nb = count($users);

    if ($nb > 27) {
        return 9;
    }
    if ($nb > 20) {
        return 8;
    }
    if ($nb > 10) {
        return 7;
    }
    if ($nb > 5) {
        return 4;
    }
    return 4;
}

function effectif($users)
{
    $nb = count($users);

    if ($nb < 5) {
        return 'empty';
    }
    if ($nb < 10) {
        return 'low';
    }
    if ($nb < 15) {
        return 'average';
    }
    if ($nb < 20) {
        return 'high';
    }
    if ($nb < 25) {
        return 'full';
    }
    return 'crazy';
}
function get_user_polaroids($uid, $options = [])
{
    $micro = $options['micro'] ?? true;
    $anonyme = $options['anonyme'] ?? false;
    if ($anonyme) {
        $anonyme = 'anonyme/';
    }

    // $api = URL_PHOTOS . '' . $uid . '.json';
    // $content = file_get_contents($api);

    // $data = json_decode($content, true);

    $hash = md5(json_encode(get_reglages()));

    $ret = [
        'big' => URL_PHOTOS . 'polaroid/size/big/' . $anonyme . $uid . '.jpg?'.$hash,
    ];

    if ($micro) {
        $ret['micro'] = get_image_content(URL_PHOTOS . 'polaroid/size/micro/' . $anonyme . $uid . '.jpg?'.$hash, UN_JOUR);
    }
    return $ret;
}

function isVisiteur($user)
{
    if (empty($user['visite'])) return;

    return true;
}
function is_birthday($user)
{
    $birthDate = $user['birthDate'] ?? false;

    if (!$birthDate) return;

    return strstr($birthDate, date('m-d')) ? true : false;
}
function get_users($delay = 15, $options = [])
{
    $data = get_content('https://tickets.coworking-metz.fr/api/current-members?key=' . TICKET_TOKEN . '&delay=' . $delay, 15 * UNE_MINUTE);
    $users = json_decode($data, true);
    $users = array_merge($users, getVisitesToday());

	$nomades = get_reglage('nomades');

    foreach ($users as &$user) {
		foreach($nomades as $nomade) {
			if($nomade['wpUserId'] == $user['wpUserId']) {
				$user['nomade']=true;
			}
		}
        $user['polaroids'] = get_user_polaroids($user['wpUserId'], ['anonyme' => $options['anonyme'] ?? false, 'micro' => $options['micro'] ?? true]);
    }

    shuffle($users);
    return $users;
}
function getNBVisitesToday() {
	return count(getVisitesToday());
}
function getVisitesToday()
{

	if(isset($GLOBALS['getVisitesToday'])) return $GLOBALS['getVisitesToday'];
    $url = "https://wpapi.coworking-metz.fr/api-json-wp/cowo/v1/visites/today";
    $auth = base64_encode(WP_APIV2_USERNAME . ':' . WP_APIV2_PASSWORD);

    $context = stream_context_create([
        'http' => [
            'method' => 'GET',
            'header' => "Authorization: Basic $auth\r\n"
        ]
    ]);

    $response = file_get_contents($url, false, $context);
    $ret = json_decode($response, true);
    $visites = array_map(function ($user) {
        $user['visiteur'] = true;
        return $user;
    }, array_filter($ret, function ($user) {
        return $user['visite'] == date('Y-m-d');
    }));

	$GLOBALS['getVisitesToday'] = $visites;
	return $visites;
}


function locationPresences($locations)
{
    $total = array_sum($locations);
    echo  '<span>'.pluriel($total, 'personnes présente').'</span>';

	if(getNBVisitesToday()) {
		echo '<span>'.pluriel(getNBVisitesToday(),'visite').' aujourd\'hui</span>';
		return;
	}

	if(count($locations)<1) return;

    $txt = [];
    foreach($locations as $slug => $nb) {
        $txt[]= $nb.' dans '.locationName($slug);
    }

    echo '<span>'.implode(', ',$txt).'</span>';

}

function locationName($slug) {
    if($slug == 'pti-poulailler') {
        return 'le P\'ti Poulailler';
    } else {
        return 'le Poulailler';
    }
}
