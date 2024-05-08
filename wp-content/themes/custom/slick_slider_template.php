
<main class="wp-block-group">
	<div class="slider_page_wrapper">
		<h1>show all post</h1>
		<?php 
		$query = new WP_Query(array(
   'posts_per_page' => -1,
			'post_type' => 'slider',
			'post_status'    => 'publish',
			'orderby'        => 'post_type',
        	'order'          => 'DESC'
));

	 if($query->have_posts()){
	 	echo '<div class ="custom-slider">';
	 	while($query->have_posts()){
	 		  $query->the_post();?>
		 		<div class="custom-slide">
		 			 <?php $featuredImage=get_the_post_thumbnail_url(get_the_ID(),'full');?>
		 			<div class="post_image"><img style="width:100px;" src="<?php echo $featuredImage?>" alt="Image"></div>
		 			<h2><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
                    <?php the_excerpt();?>
		 			<?php echo get_post_meta(get_the_ID(), 'subtitle', true);?>
		 			
		 		</div>
		 		
	<?php	 }
		}
		 
  wp_reset_postdata();
?>
	

</main>
			
<script type="text/javascript">
	$=jQuery;
	$(document).ready(function(){
		console.log("comes in");

		$('.custom-slider').slick({
			  slidesToShow: 3,
			  slidesToScroll: 1,
			  autoplay: true,
			  autoplaySpeed: 2000,
		});

			
	});
</script>