<?php 
get_header();


if(have_posts()):
	while(have_posts()): the_post();?>
		<h2><?php the_title(); ?></h2>
		<p><?php
        $fieldName = get_post_meta(get_the_ID(), 'fieldName', true);
        echo 'fieldName: ' . $fieldName;
        $fieldValue = get_post_meta(get_the_ID(), 'fieldValue', true);
        echo 'fieldValue: ' . $fieldValue;

    ?></p>
		<?php the_content(); ?>
	<?php endwhile;
else:
	echo '<p>no post there</p>';
endif;

?>
<?php
get_footer();
?>