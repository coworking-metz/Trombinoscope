<div class="infos">
    <span><?= pluriel($total, 'personne présente'); ?></span>
    <date><?= obtenirDateActuelle(); ?></date>
    <time class="loading"><?= date('H:i:s'); ?></time>
    <?php if ($admin) { ?>
        <a href="/?nocache&admin&test=<?= $test + 1; ?>">+</a>
    <?php } ?>
</div>