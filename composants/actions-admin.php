<div class="actions">
    <div>
        <a title="Fiche Wordpress" target="_blank" href="https://www.coworking-metz.fr/wp-admin/user-edit.php?user_id=<?= $user['wpUserId']; ?>"><span class="icon is-small"><i class="fas fa-user"></i></span></a>
        <a title="Commandes Wordpress" target="_blank" href="https://www.coworking-metz.fr/wp-admin/edit.php?s&post_status=all&post_type=shop_order&_customer_user=<?= $user['wpUserId']; ?>"><span class="icon is-small"><i class="fas fa-cart-shopping"></i></span></a>
        <a title="Fiche manager" target="_blank" href="https://manager.coworking-metz.fr/members/<?= $user['wpUserId']; ?>"><span class="icon is-small"><i class="fas fa-cog"></i></span></a>
        <a target="_blank" title="Polaroïd format pdf" href="https://photos.coworking-metz.fr/<?= $user['wpUserId']; ?>.pdf"><span class="icon is-small"><i class="fas fa-file-pdf"></i></span></a>

    </div>
</div>