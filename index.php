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
$locations = array_count_values(array_column($users,'location'));
$grid = calculateGridDimensions($total);

$colonnes = $grid['colonnes'];
$lignes = $grid['lignes'];

$cssFile = '/css/trombi.css';
$cssPath = CHEMIN_SITE . $cssFile;

$jsFile = '/trombi.js';
$jsPath = CHEMIN_SITE . $jsFile;
if ($admin) {

    noCacheHeaders();
} else {
    cacheHeaders(CINQ_MINUTES);
}
$version = '?' . filemtime($cssPath);
?>
<?php include CHEMIN_SITE . 'composants/head.php'; ?>

    <?php include CHEMIN_SITE . 'composants/fond.php'; ?>
    <div class="wrapper">
        <?php include CHEMIN_SITE . 'composants/infos.php'; ?>
        <?php include CHEMIN_SITE . 'composants/trombi.php'; ?>
    </div>
<?php include CHEMIN_SITE . 'composants/foot.php'; ?>

