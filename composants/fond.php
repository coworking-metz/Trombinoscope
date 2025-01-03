<div class="fond">
<?php if( get_reglage('fond') ) {?>
    <img src="<?= get_reglage('fond/image', '/images/fond.jpg'); ?>" style="opacity:<?= get_reglage('fond/opacity',0); ?>;object-fit:<?= get_reglage('fond/mode'); ?>">
	<?php } else {?>
		<img src="/images/fond.jpg">
	<?php } ?>
</div>	
