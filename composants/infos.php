<div class="infos">
    <div>
        <?= locationPresences($locations); ?>
        <date><?= obtenirDateActuelle(); ?></date>
        <time class="loading"><?= date('H:i:s'); ?></time>
        <?php if ($admin) { ?>
            <a href="/?nocache&admin&test=<?= $test + 1; ?>">+</a>
        <?php } ?>
    </div>
    <div>
        <div class="legende">
            <div>
                <img src="/images/ticket-red.png"><span>Abo. ou tickets épuisés</span>
            </div>
            <div>
            <img src="/images/adhesion.png"><span>Adhésion <?=date('Y');?> manquante</span>
            </div>
        </div>
    </div>
</div>