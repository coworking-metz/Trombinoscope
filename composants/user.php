<div class="user" data-debit="<?= ($user['balance'] ?? 0) < 0 ? 'true' : 'false'; ?>" data-adhesion="<?= ($user['membershipOk'] ?? true) ? 'true' : 'false'; ?>" data-anniversaire="<?=is_birthday($user)?'true':'false';?>">
    <figure>
        <div class="image micro"><img src="<?= $user['polaroids']['micro'] ?? ''; ?>"></div>

        <span class="image big" style="background-image:url(<?= $user['polaroids']['big']; ?>)">
            <nav>
                <?php if (!($user['visite']??false)) { ?>
                    <?php if (!$user['membershipOk']) { ?>
                        <span><img src="/images/adhesion.png"></span>
                    <?php } ?>
                    <?php if ($user['balance'] < 0) { ?>
                        <span><img src="/images/ticket-red.png"></span>
                    <?php } ?>
                <?php } ?>
            </nav>
        </span>

        <?php if ($admin) { ?>
            <?php include CHEMIN_SITE . 'composants/actions-admin.php'; ?>
        <?php } ?>
    </figure>
</div>