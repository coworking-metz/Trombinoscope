<?php
$version = '?' . filemtime($cssPath);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trombinoscope</title>
    <meta name="robots" content="noindex">
    <?php if(!$admin) {?>
    <meta http-equiv="refresh" content="60"> 
    <?php }?>
        <?php $avent = get_reglage('avent');?>
    <style>
        :root {
            --nb-users: <?= $total; ?>;
            --nb-colonnes: <?= $colonnes; ?>;
            --nb-lignes: <?= $lignes; ?>;
            --couleur-du-fond:<?= get_reglage('fond/couleur'); ?>;
            --couleur-du-texte: <?= get_reglage('couleur_du_texte'); ?>;
            --picto-avent:url('<?=$avent['picto_avent']??false;?>')
        }
    </style>
    <script>
        const avent = <?= json_encode($avent); ?>
    </script>
    <script>
        const WP_API_URL = <?= json_encode(WP_API_URL) ?>
    </script>
	<?php if($admin) {?>
	    <script type="text/javascript" defer async src="https://cloudflare.coworking-metz.fr/cf.js"></script>
    <?php }?>
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