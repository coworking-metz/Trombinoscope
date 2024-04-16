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
            <?php include CHEMIN_SITE . 'composants/actions-admin.php'; ?>
        <?php } ?>
    </figure>
</div>