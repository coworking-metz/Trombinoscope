<div class="trombi">
    <div class="users">
        <div class="line">
            <?php foreach ($users as $k => $user) { ?>
                <?php if ($k && ($k % $colonnes == 0)) {
                    echo '</div><div class="line">';
                } ?>

                <?php include CHEMIN_SITE . 'composants/user.php'; ?>

            <?php } ?>
        </div>
    </div>
</div>