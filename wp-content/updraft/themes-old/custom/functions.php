<?php
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

add_action( 'add_meta_boxes', 'hcf_register_meta_boxes' );

add_action('save_post',"wpl_owt_save_meta_box");

function wpl_owt_save_meta_box($post_id){
	// if(!isset($_POST['smashing_post_class_nonce'])||!wp_verify_nonce($_POST['smashing_post_class_nonce'])){
	// 	return $post_id;
	// }
	$fieldName=sanitize_text_field($_POST['fieldName']);
	$fieldValue=sanitize_text_field($_POST['fieldValue']);
	update_post_meta($post_id,'fieldName',$fieldName);
	update_post_meta($post_id,'fieldValue',$fieldValue);
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




<?php

class wpb_widget extends WP_Widget {
    function __construct() {
        parent::__construct(
        // Base ID of your widget
            'wpb_widget',
 
            // Widget name will appear in UI
            __( 'WPBeginner Widget', 'textdomain' ),
 
            // Widget description
            [
                'description' => __( 'Sample widget based on WPBeginner Tutorial', 'textdomain' ),
            ]
        );
    }
 
    // Creating widget front-end
    public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance['title'] );
 
        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        if ( ! empty( $title ) ) {
            echo $args['before_title'] . $title . $args['after_title'];
        }
 
        // This is where you run the code and display the output
        echo __( 'Hello, World!', 'textdomain' );
        echo $args['after_widget'];
    }
 
    // Widget Settings Form
    public function form( $instance ) {
        if ( isset( $instance['title'] ) ) {
            $title = $instance['title'];
        } else {
            $title = __( 'New title', 'textdomain' );
        }
 
        // Widget admin form
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>">
                <?php _e( 'Title:', 'textdomain' ); ?>
            </label>
            <input
                    class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
                    name="<?php echo $this->get_field_name( 'title' ); ?>"
                    type="text"
                    value="<?php echo esc_attr( $title ); ?>"
            />
        </p>
        <?php
    }
 
    // Updating widget replacing old instances with new
    public function update( $new_instance, $old_instance ) {
        $instance          = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
 
        return $instance;
    }
 
    // Class wpb_widget ends here
}
 
// Register and load the widget
function wpb_load_widget() {
    register_widget( 'wpb_widget' );
}
 
add_action( 'widgets_init', 'wpb_load_widget' );
?>
