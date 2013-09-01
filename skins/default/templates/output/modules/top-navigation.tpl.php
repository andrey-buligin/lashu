<?php if ( is_array( $menu ) ): ?>
<ul class="menu">
	<?php foreach ( $menu as $menuItemId => $menuItem ): ?>
	<li<?php echo $menuItem['class']; ?>>
		<a <?php echo getDebug($arr['id']).'  href="'.$menuItem['link'].'"' ?> ><?php echo $menuItem['title']?></a>
		<?php if ( isset($menuItem['subnav']) ) : ?>
			<?php echo $menuItem['subnav']; ?>
		<?php endif;?>
	</li>
    <?php endforeach;?>
</ul>
<?php endif; ?>