<?php if ( is_array( $menu ) ): ?>
<ul id="menu-nav" class="menu">
	<?php foreach ( $menu as $menuItemId => $menuItem ): ?>
	<li<?php echo $menuItem['class']; ?>>
		<a <?php echo getDebug($arr['id']).'  href="'.$menuItem['link'].'"' ?> ><?php echo $menuItem['title']?></a>
	</li>
    <?php endforeach;?>
</ul>
<?php endif; ?>