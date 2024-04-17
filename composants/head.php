
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trombinoscope</title>
    <meta name="robots" content="noindex">
    <meta http-equiv="refresh" content="60"> 
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
