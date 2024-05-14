<?php
require_once ABSPATH.'wp-includes/class-wp-widget.php';

//menu registeration
register_nav_menus(array(
	'primary'=>__('Primary Menu'),
    'footer'=>__('Footer Menu'),
));
//acf settings
if( function_exists('acf_add_options_page') ) {

    acf_add_options_page(array(
        'page_title'    => 'ieat General Settings',
        'menu_title'    => 'Theme Settings',
        'menu_slug'     => 'theme-general-settings',
        'capability'    => 'edit_posts',
        'redirect'      => false
    ));


}
echo get_template_directory_uri() ."/slick_slider_template.php";
//addSlider();
//include slick slider file
function includeFile(){
	echo file_get_contents(get_template_directory_uri() ."/slick_slider_template.php");
	// $clean_file_path="\slick_slider_template.php";
	// $result=file_exists($clean_file_path);
	// var_dump($result);

	// ob_start();
	// include(TEMPLATEPATH.$clean_file_path);
    // $content= ob_get_clean();
    // return $content;
}

//Register shortcode
add_shortcode('my_ad_code', 'addSlider'); 

//formatable form 
add_filter( 'frm_validate_field_entry', 'require_a_field', 10, 3 );
function require_a_field( $errors, $field, $value ) {
  if (( $field->id == 15 && trim( $value ) == '' )|| ($field->id ==17 && trim($value)=='') ) { 
      $errors[ 'field'. $field->id ] = 'That field is required';
  }
  if($field->id ==15){
  	if(strlen(trim($value))!=10 && is_numeric(trim($value))){
  		 $errors[ 'field'. $field->id ] = 'phone number isnt valid';
  	}
  }
  return $errors;
}

//post meta boxes
function hcf_register_meta_boxes() {
    add_meta_box( 'metaBox1', 'Enter Field', 'smashing_post_class_meta_box', 'page','side','default' );
}
//slider meta boxes
function register_slider_meta_box(){
	 add_meta_box( 'metaBox2', 'Enter Field', 'slider_meta_box', 'slider','side','default' );
}

add_action( 'add_meta_boxes', 'hcf_register_meta_boxes' );
add_action( 'add_meta_boxes', 'register_slider_meta_box' );
add_action('save_post',"slider_save_meta_box");
add_action('save_post',"wpl_owt_save_meta_box");
add_theme_support( 'widgets' );
add_theme_support( 'sidebar' );
add_action( 'widgets_init', 'register_foo' );
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
function my_theme_enqueue_styles() {
		wp_register_style('slick-css', get_template_directory_uri() .'/assets/slick/slick.css');
		wp_register_style('slick-theme-css', get_template_directory_uri() .'/assets/slick/slick-theme.css');
		wp_register_script('slick-min-js', get_template_directory_uri().'/assets/slick/slick.min.js', [], null, false);
        // wp_register_script('slick-template', get_template_directory_uri().'\slick_slider_template.php', [], null, false);
        // wp_enqueue_script('slick-template');  
        wp_enqueue_script('slick-min-js');  
		wp_enqueue_style('slick-css');
		wp_enqueue_style('slick-theme-css');
}
function register_foo() {
	register_widget( 'Foo_Widget' );
}
register_sidebar( array(
   'name' => __( 'Test Sidebar' ),
   'id' => 'test-sidebar',
));
/**
 * Add a sidebar.
 */
function wpdocs_theme_slug_widgets_init() {
	register_sidebar( array(
		'name'          => 'Main Sidebar',
		'id'            => 'sidebar-1',
		'description'   => 'Widgets in this area will be shown on all posts and pages.',
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget'  => '</li>',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'wpdocs_theme_slug_widgets_init' );
function wpl_owt_save_meta_box($post_id){
	$fieldName=sanitize_text_field($_POST['fieldName']);
	$fieldValue=sanitize_text_field($_POST['fieldValue']);
	update_post_meta($post_id,'fieldName',$fieldName);
	update_post_meta($post_id,'fieldValue',$fieldValue);
}
function slider_save_meta_box($post_id){
	$subtitle=sanitize_text_field($_POST['subtitle']);
	update_post_meta($post_id,'subtitle',$subtitle);
}


function smashing_post_class_meta_box( $post ) { ?>

  <p>
    <label for="fieldName">field name</label>
    <br />
    <input class="widefat" type="text" name="fieldName" id="fieldName" value="<?php echo esc_attr( get_post_meta( $post->ID ,"fieldName",true) ); ?>" size="30" />
  </p>
   <p>
    <label for="fieldValue">field value</label>
    <br />
    <input  type="textarea" name="fieldValue" id="fieldValue" value="<?php echo esc_attr( get_post_meta( $post->ID ,"fieldValue",true)); ?>" style="width:250px;height:80px" />
  </p>
<?php } ?>

<?php function slider_meta_box( $post ) { ?>

  <p>
    <label for="subtitle">Subtitle</label>
    <br />
    <input class="widefat" type="text" name="subtitle" id="subtitle" value="<?php echo esc_attr( get_post_meta( $post->ID ,"subtitle",true) ); ?>" size="30" />
  </p>
 <?php } ?>



<?php

class Foo_Widget extends WP_Widget {
	
	public function __construct() {
		parent::__construct(
			'foo_widget', // Base ID
			'Foo_Widget', // Name
			array( 'description' => __( 'A Foo Widget', 'text_domain' ) ) // Args
		);
	}

	public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		$content = $instance['content'] ;
		$link =$instance['link'] ;
		$linkName =$instance['linkName'] ;
		$featureImage =$instance['featureImage'] ;
		echo $before_widget;
		if ( ! empty( $title ) ) {
			echo $before_title . $title . $after_title;
		}
		echo $content."<br>";
		echo "<a href='".$link."'>$linkName</a>"."<br>";

		echo '<img style="width:50px;height:50px;margin-bottom: -10px;" src="'.	get_field($instance['featureImage'],'option').'">';
		echo $after_widget;
	}
	public function form( $instance ) {
		if ( isset( $instance['title'] ) ) {
			$title = $instance['title'];
			$content = $instance['content'];
			$link = $instance['link'];
			$linkName = $instance['linkName'];
		    $featureImage =$instance['featureImage'] ;
		} else {
			$title = 'New title';
			$content = 'New content';
			$linkName = 'New link Name';
			$link ='New link';
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_name( 'title' ); ?>">Title:</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />

			<label for="<?php echo $this->get_field_name( 'content' ); ?>">Content:<label>
			<input class="widefat" id="<?php echo $this->get_field_name( 'content' ); ?>" name="<?php echo $this->get_field_name( 'content' ); ?>"type="text" value="<?php echo esc_attr( $content ); ?>" />

			<label for="<?php echo $this->get_field_name( 'linkName' ); ?>">Link Name:</label>
			<input class="widefat" id="<?php echo $this->get_field_name( 'linkName' ); ?>" name="<?php echo $this->get_field_name( 'linkName' ); ?>"type="text" value="<?php echo esc_attr( $linkName ); ?>" />
			
			<label for="<?php echo $this->get_field_name( 'link' ); ?>">Link:</label>
			<input class="widefat" id="<?php echo $this->get_field_name( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>"type="text" value="<?php echo esc_attr( $link ); ?>" />
			<label for="<?php echo $this->get_field_id('featureImage'); ?>">Add acf image tag</label><br />
            <input type="text" class="img" name="<?php echo $this->get_field_name('featureImage'); ?>" id="<?php echo $this->get_field_id('featureImage'); ?>" value="<?php echo $instance['featureImage']; ?>" />
      
		
		<?php
	}
	
	public function update( $new_instance, $old_instance ) {
		$instance          = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		$instance['content'] = ( ! empty( $new_instance['content'] ) ) ? strip_tags( $new_instance['content'] ) : '';
		$instance['link'] = ( ! empty( $new_instance['link'] ) ) ? strip_tags( $new_instance['link'] ) : '';
		$instance['linkName'] = ( ! empty( $new_instance['linkName'] ) ) ? strip_tags( $new_instance['linkName'] ) : '';
		$instance['featureImage'] = ( ! empty( $new_instance['featureImage'] ) ) ? strip_tags( $new_instance['featureImage'] ) : '';
		return $instance;
	}
} // class Foo_Widget
 


?>
<?php 
function wms_slider_init() {
    $labels = array(
        'name' => 'Slider',
        'singular_name' => 'Slider',
        'add_new' => 'Add Slider',
        'add_new_item' => 'Add New Slider',
        'edit_item' => 'Edit Slider',
        'new_item' => 'New Slider',
        'all_items' => 'All Sliders',
        'view_item' => 'View Slider',
        'search_items' => 'Search Sliders',
        'not_found' =>  'No Slider found',
        'not_found_in_trash' => 'No Slider found in Trash', 
        'parent_item_colon' => '',
        'menu_name' => 'Sliders'
    );

    $args = array(
        'labels' => $labels,
        'description'   => 'Holds our Slider poste specific data',
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true, 
        'show_in_menu' => true, 
        'query_var' => true,
        'rewrite' => array( 'slug' => 'slider' ),
        'capability_type' => 'post',
        'has_archive' => false, 
        'hierarchical' => true,
        'menu_position' => 5,
        'supports' => array( 'title', 'editor', 'thumbnail', 'page-attributes')
    ); 
    register_post_type( 'slider', $args );
}
add_action( 'init', 'wms_slider_init' );


//walker class 
class Menu_With_Description extends Walker_Nav_Menu  {


	 function start_el(&$output, $item, $depth = 0, $args = array(), $current_object_id = 0) {

        global $wp_query;
        $indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
         
        $class_names = $value = '';
 
        $classes = empty( $item->classes ) ? array() : (array) $item->classes;
 
        $class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
        $class_names = ' class="' . esc_attr( $class_names ) . '"';
 
        $output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';
 
        $attributes = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) .'"' : '';
        $attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) .'"' : '';
        //$attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) .'"' : '';
        $attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) .'"' : '';
 
        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        $item_output .= '<img style="width:20px;height:20px;margin-right: 10px;" src="'. get_field($item->description,'option') .'"><br/>';
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;
       $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );

}

}
?>
<?php 

function addSlider() {?>
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

<?php }?>


