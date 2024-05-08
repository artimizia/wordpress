<footer class="site-footer">
	<p><?php bloginfo("name");?>-&copy;<?php echo date('y')?>
	<nav class="site-nav">
			<?php $args=array('theme_location'=>'primary');?>
			<?php wp_nav_menu($args);?>
			<?php $args=array('theme_location'=>'footer');?>
			<?php wp_nav_menu($args);?>
    </nav >
			
</footer>
	<?php wp_footer();?>
</body>
</html>