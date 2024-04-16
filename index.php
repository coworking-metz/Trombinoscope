<?php
include 'lib/main.inc.php';
$delay = $_GET['delay'] ?? 15;
$test = $_GET['test'] ?? false;
$admin = isset($_GET['admin']);
$anonyme = isset($_GET['anonyme']);
if ($test) {
    $delay = 3000;
}
$users = get_users($delay, ['anonyme' => $anonyme, 'micro' => !$admin]);
if ($test) {

    while (count($users) < $test) {
        $users = array_merge($users, $users);
    }

    $users = array_slice($users, 0, $test);
}
$total = count($users);
$grid = calculateGridDimensions($total);

$colonnes = $grid['colonnes'];
$lignes = $grid['lignes'];

$cssFile = '/css/trombi.css';
$cssPath = CHEMIN_SITE . $cssFile;

$jsFile = '/js/trombi.js';
$jsPath = CHEMIN_SITE . $jsFile;
if ($admin) {
    noCacheHeaders();
} else {
    cacheHeaders(CINQ_MINUTES);
}
$version = '?' . filemtime($cssPath);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trombinoscope</title>
    <style>
        :root {
            --nb-users: <?= $total; ?>;
            --nb-colonnes: <?= $colonnes; ?>;
            --nb-lignes: <?= $lignes; ?>;
            /* --largeur-case: max(10vw, <?= 100 / $colonnes; ?>%);
            --hauteur-case: max(10vh, <?= 100 / $lignes; ?>%); */
        }
    </style>
    <script type="text/javascript" defer async src="https://cloudflare.coworking-metz.fr/cf.js"></script>
    <link rel="stylesheet" href="<?= $cssFile . $version; ?>">
    <link rel="stylesheet" href="https://pages.coworking-metz.fr/fonts/fonts.css<?= $version; ?>">
    <?php if ($admin) { ?>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <?php } ?>
    <?php foreach ($users as $user) { ?>
        <link rel="preload" href="<?= $user['polaroids']['big']; ?>" as="image">
    <?php } ?>
</head>

<body data-effectif="<?= effectif($users); ?>" data-admin="<?= $admin ? 'true' : 'false'; ?>">
    <div class="fond"><img src="<?= get_reglage('fond/image', '/images/fond.jpg'); ?>" style="opacity:<?= get_reglage('fond/opacity', 1); ?>;background-color:<?= get_reglage('fond/couleur'); ?>;object-fit:<?= get_reglage('fond/mode'); ?>"></div>
    <div class="wrapper">
        <div class="infos">
            <span><?= pluriel($total, 'personne présente'); ?></span>
            <date><?= obtenirDateActuelle(); ?></date>
            <time class="loading"><?= date('H:i:s'); ?></time>
            <?php if ($admin) { ?>
                <a href="/?nocache&admin&test=<?= $test + 1; ?>">+</a>
            <?php } ?>
        </div>
        <div class="trombi">
            <div class="users">
                <div class="line">
                    <?php foreach ($users as $k => $user) { ?>
                        <?php if ($k && ($k % $colonnes == 0)) {
                            echo '</div><div class="line">';
                        } ?>
                        <div class="user" data-debit="<?= ($user['balance'] ?? 0) < 0 ? 'true' : 'false'; ?>" data-adhesion="<?= ($user['membershipOk'] ?? false) ? 'true' : 'false'; ?>">
                            <figure>
                                <img class="image micro" src="<?= $user['polaroids']['micro'] ?? ''; ?>">
                                <!-- <img class="image big" src="<?= $user['polaroids']['big']; ?>"> -->
                                <span class="image big" style="background-image:url(<?= $user['polaroids']['big']; ?>)">
                                    <nav>
                                        <?php if (!$user['membershipOk']) { ?>
                                            <span><?= Svg::get('carte-rouge'); ?></span>
                                        <?php } ?>
                                        <?php if ($user['balance'] < 0) { ?>
                                            <span><?= Svg::get('ticket-rouge'); ?></span>
                                        <?php } ?>
                                    </nav>
                                </span>

                                <?php if ($admin) { ?>
                                    <div class="actions">
                                        <div>
                                            <a title="Fiche Wordpress" target="_blank" href="https://www.coworking-metz.fr/wp-admin/user-edit.php?user_id=<?= $user['wpUserId']; ?>"><span class="icon is-small"><i class="fas fa-user"></i></span></a>
                                            <a title="Fiche manager" target="_blank" href="https://manager.coworking-metz.fr/members/<?= $user['wpUserId']; ?>"><span class="icon is-small"><i class="fas fa-cog"></i></span></a>
                                            <a target="_blank" title="Polaroïd format pdf" href="https://photos.coworking-metz.fr/<?= $user['wpUserId']; ?>.pdf"><span class="icon is-small"><i class="fas fa-file-pdf"></i></span></a>
                                            <a target="_blank" href="https://photos.coworking-metz.fr/polaroid/size/big/<?= $user['wpUserId']; ?>.jpg" title="Polaroïd format image"><span class="icon is-small"><i class="fas fa-file-image"></i></span></a>
                                        </div>
                                    </div>
                                <?php } ?>
                            </figure>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<?= Svg::defs(); ?>
<script src="<?= $jsFile . '?' . filemtime($jsPath); ?>"></script>
