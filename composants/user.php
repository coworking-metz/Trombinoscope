<div class="user" data-debit="<?= ($user['balance'] ?? 0) < 0 ? 'true' : 'false'; ?>" data-adhesion="<?= ($user['membershipOk'] ?? true) ? 'true' : 'false'; ?>" data-anniversaire="<?= is_birthday($user) ? 'true' : 'false'; ?>" data-visiteur="<?= !empty($user['visiteur']) ? 'true' : 'false'; ?>" data-nomade="<?= !empty($user['nomade']) ? 'true' : 'false'; ?>" data-id="<?= $user['wpUserId'] ?? false; ?>" data-location="<?= $user['location'] ?? ''; ?>">
    <figure>
        <div class="image micro"><img src="<?= $user['polaroids']['micro'] ?? ''; ?>"></div>

        <span class="image big" _style="background-image:url(<?= $user['polaroids']['big']; ?>)">
            <img class="le-polaroid" src="<?= $user['polaroids']['big']; ?>">

            <?php if (($user['nomade'] ?? false)) { ?>
            <?php } else if (($user['visite'] ?? false)) { ?>
                <img class="qr" src="<?= 'https://tools.coworking-metz.fr/qr/?logo=false&url='.urlencode('http://cowo.ovh/m/'.$user['wpUserId']); ?>">
            <?php } else { ?>
                <nav>
                    <?php if (!$user['membershipOk']) { ?>
                        <span class="erreur-adhesion"><img src="/images/adhesion.png"></span>
                    <?php } ?>
                    <?php if ($user['balance'] < 0) { ?>
                        <span class="erreur-ticket"><img src="/images/ticket-red.png"></span>
                    <?php } ?>
                </nav>
            <?php } ?>
        </span>

        <?php if ($admin) { ?>
            <?php include CHEMIN_SITE . 'composants/actions-admin.php'; ?>
        <?php } ?>
    </figure>
</div>