<?php 
add_action('woocommerce_before_main_content','woocamp_open_div',5);

function woocamp_open_div(){
	if(!is_product()){
		return;
	}
	echo '<div class="woocamp-wrap">';
}
?>

<?php
/**
 * Blocksy functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Blocksy
 */

if (version_compare(PHP_VERSION, '5.7.0', '<')) {
	require get_template_directory() . '/inc/php-fallback.php';
	return;
}

require get_template_directory() . '/inc/init.php';
?>
