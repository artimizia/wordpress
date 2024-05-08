<?php
require_once ABSPATH.'wp-includes/class-wp-widget.php';
register_nav_menus(array(
	'primary'=>__('Primary Menu'),
    'footer'=>__('Footer Menu'),
));

if( function_exists('acf_add_options_page') ) {

    acf_add_options_page(array(
        'page_title'    => 'ieat General Settings',
        'menu_title'    => 'Theme Settings',
        'menu_slug'     => 'theme-general-settings',
        'capability'    => 'edit_posts',
        'redirect'      => false
    ));

    // acf_add_options_sub_page(array(
    //     'page_title'    => 'Theme Header Settings',
    //     'menu_title'    => 'Header',
    //     'parent_slug'   => 'theme-general-settings',
    // ));

    // acf_add_options_sub_page(array(
    //     'page_title'    => 'Theme Footer Settings',
    //     'menu_title'    => 'Footer',
    //     'parent_slug'   => 'theme-general-settings',
    // ));

}
// The shortcode function

function includeFile(){
	$clean_file_path="\slick_slider_template.php";
	$result=file_exists($clean_file_path);
	var_dump($result);
	//if(file_exists($clean_file_path)){
		echo "comes in includefile";
		ob_start();
	   include(TEMPLATEPATH.$clean_file_path);
      $content= ob_get_clean();
       return $content;
	
	//}
	return "hello";	
}
//Register shortcode
add_shortcode('my_ad_code', 'includeFile'); 

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

function hcf_register_meta_boxes() {
    add_meta_box( 'hcf-1', __( 'Enter Field', 'hcf' ), 'smashing_post_class_meta_box', 'page','side','default' );
}
function register_slider_meta_box(){
	 add_meta_box( 'hcf-1', __( 'Enter Field', 'hcf' ), 'slider_meta_box', 'slider','side','default' );
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
	    // wp_register_script('jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js', false, '1.8.1');
        // wp_enqueue_script('jquery');  

		wp_register_script('slick-min-js', get_template_directory_uri().'/assets/slick/slick.min.js', [], null, false);

        wp_enqueue_script('slick-min-js');  
		wp_enqueue_style('slick-css');
		wp_enqueue_style('slick-theme-css');
		// wp_enqueue_script('jquery-min-js');
		// wp_enqueue_script('slick-min-js');
		//wp_enqueue_script('myscript-js');
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
		'name'          => __( 'Main Sidebar', 'textdomain' ),
		'id'            => 'sidebar-1',
		'description'   => __( 'Widgets in this area will be shown on all posts and pages.', 'textdomain' ),
		'before_widget' => '<li id="%1$s" class="widget %2$s">',
		'after_widget'  => '</li>',
		'before_title'  => '<h2 class="widgettitle">',
		'after_title'   => '</h2>',
	) );
}
add_action( 'widgets_init', 'wpdocs_theme_slug_widgets_init' );
//dynamic_sidebar('wpdocs_theme_slug_widgets_init');

function wpl_owt_save_meta_box($post_id){
	// if(!isset($_POST['smashing_post_class_nonce'])||!wp_verify_nonce($_POST['smashing_post_class_nonce'])){
	// 	return $post_id;
	// }
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

  <?php wp_nonce_field( basename( __FILE__ ), 'smashing_post_class_nonce' ); ?>

  <p>
    <label for="fieldName"><?php \_e( "field name", 'example' ); ?></label>
    <br />
    <input class="widefat" type="text" name="fieldName" id="fieldName" value="<?php echo esc_attr( get_post_meta( $post->ID ,"fieldName",true) ); ?>" size="30" />
  </p>
   <p>
    <label for="fieldValue"><?php \_e( "field value", 'example' ); ?></label>
    <br />
    <input  type="textarea" name="fieldValue" id="fieldValue" value="<?php echo esc_attr( get_post_meta( $post->ID ,"fieldValue",true)); ?>" style="width:250px;height:80px" />
  </p>
<?php } ?>

<?php function slider_meta_box( $post ) { ?>

  <?php wp_nonce_field( basename( __FILE__ ), 'slider_nonce' ); ?>

  <p>
    <label for="subtitle"><?php \_e( "Subtitle", 'example' ); ?></label>
    <br />
    <input class="widefat" type="text" name="subtitle" id="subtitle" value="<?php echo esc_attr( get_post_meta( $post->ID ,"subtitle",true) ); ?>" size="30" />
  </p>
 <?php } ?>



<?php
/**
 * Adds Foo_Widget widget.
 */
class Foo_Widget extends WP_Widget {
	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
			'foo_widget', // Base ID
			'Foo_Widget', // Name
			array( 'description' => __( 'A Foo Widget', 'text_domain' ) ) // Args
		);
	}
	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
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
	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		if ( isset( $instance['title'] ) ) {
			$title = $instance['title'];
			$content = $instance['content'];
			$link = $instance['link'];
			$linkName = $instance['linkName'];
		    $featureImage =$instance['featureImage'] ;
		} else {
			$title = __( 'New title', 'text_domain' );
			$content = __( 'New content', 'text_domain' );
			$linkName = __( 'New link Name', 'text_domain' );
			$link = __( 'New link', 'text_domain' );
		}
		?>
		<p>
			<label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />

			<label for="<?php echo $this->get_field_name( 'content' ); ?>"><?php _e( 'Content:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_name( 'content' ); ?>" name="<?php echo $this->get_field_name( 'content' ); ?>"type="text" value="<?php echo esc_attr( $content ); ?>" />

			<label for="<?php echo $this->get_field_name( 'linkName' ); ?>"><?php _e( 'Link Name:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_name( 'linkName' ); ?>" name="<?php echo $this->get_field_name( 'linkName' ); ?>"type="text" value="<?php echo esc_attr( $linkName ); ?>" />
			
			<label for="<?php echo $this->get_field_name( 'link' ); ?>"><?php _e( 'Link:' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_name( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>"type="text" value="<?php echo esc_attr( $link ); ?>" />
			<label for="<?php echo $this->get_field_id('featureImage'); ?>">Add acf image tag</label><br />
            <input type="text" class="img" name="<?php echo $this->get_field_name('featureImage'); ?>" id="<?php echo $this->get_field_id('featureImage'); ?>" value="<?php echo $instance['featureImage']; ?>" />
      
		
		<?php
	}
	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
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
// add_action( 'init', 'wms_create_slider_taxonomies', 0 );

// //create SlideShow Category for the post type "slider"
// function wms_create_slider_taxonomies() {

//     // Add new taxonomy, make it hierarchical (like categories)
//     $labels = array(
//         'name'                => _x( 'SlideShows', 'taxonomy general name' ),
//         'singular_name'       => _x( 'SlideShow', 'taxonomy singular name' ),
//         'search_items'        => __( 'Search Genres' ),
//         'all_items'           => __( 'All SlideShows' ),
//         'parent_item'         => __( 'Parent SlideShow' ),
//         'parent_item_colon'   => __( 'Parent SlideShow:' ),
//         'edit_item'           => __( 'Edit SlideShow' ), 
//         'update_item'         => __( 'Update SlideShow' ),
//         'add_new_item'        => __( 'Add New SlideShow' ),
//         'new_item_name'       => __( 'New SlideShow Name' ),
//         'menu_name'           => __( 'SlideShow' )
//     );    

//     $args = array(
//         'hierarchical'        => true,
//         'labels'              => $labels,
//         'show_ui'             => true,
//         'show_admin_column'   => true,
//         'query_var'           => true,
//         'rewrite'             => array( 'slug' => 'slideshow' )
//     );
//     register_taxonomy( 'slideshow', array( 'slider' ), $args );
// }
?>
