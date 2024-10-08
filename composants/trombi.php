<?php
$autres = false;
?>
<div class="trombi">
    <div class="users">
        <div class="line">
            <?php foreach ($users as $k => $user) { ?>
                <?php if ($k && ($k % $colonnes == 0)) {
                    if (!$autres) {
                        $autres = true;
                        echo '<div class="user autres">Et ' . (count($users) - 4) . ' autres ...</div>';
                    }
                    echo '</div><div class="line">';
                } ?>

                <?php include CHEMIN_SITE . 'composants/user.php'; ?>

            <?php } ?>
        </div>
    </div>
</div>