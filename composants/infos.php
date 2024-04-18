<div class="infos">
    <div>
        <span><?= pluriel($total, 'personne présente'); ?></span>
        <date><?= obtenirDateActuelle(); ?></date>
        <time class="loading"><?= date('H:i:s'); ?></time>
        <?php if ($admin) { ?>
            <a href="/?nocache&admin&test=<?= $test + 1; ?>">+</a>
        <?php } ?>
    </div>
    <div>
        <div class="legende">
            <div>
                <?= Svg::get('ticket-rouge'); ?><span>Abo. ou tickets épuisés</span>
            </div>
            <div>
                <?= Svg::get('carte-rouge'); ?><span>Adhésion <?=date('Y');?> manquante</span>
            </div>
        </div>
    </div>
</div>