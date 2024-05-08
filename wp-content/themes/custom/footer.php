<footer class="site-footer">
	<div>
		<?php dynamic_sidebar('test-sidebar')?>
	</div>
	<p><?php bloginfo("name");?>-&copy;<?php echo date('y')?>

	<nav class="site-nav">
			<?php $customWalker = new Menu_With_Description; $args=array('theme_location'=>'footer','walker'=>$customWalker);?>
			<?php wp_nav_menu($args);?>
    </nav >
			
</footer>
	<?php wp_footer();?>
</body>
</html>