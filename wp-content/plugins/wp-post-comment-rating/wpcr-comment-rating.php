<?php
/**
* Plugin Name: WP Post Rating 
* Plugin URI: https://wordpress.org/plugins/wpcr-comment-rating/
* Description: A simple plugin for adding rating functionality to WordPress Post with comments.
* Version: 1.1.1
* Author: Shoaib Saleem
* Author URI: https://profiles.wordpress.org/shoaib88/
*/

add_action('admin_init', 'wpcr_register_options');  // register options for the form
add_action('admin_menu', 'wpcr_admin_links');  // register admin menu hyperlinks

//include necessary files
		
	include (  plugin_dir_path( __FILE__ ) . 'inc/setting.php');	
	
/////// admin enqueue scripts ///////
function wpcr_admin_enqueue() {
	wp_enqueue_style( 'wpcr_custom_style', plugin_dir_url( __FILE__ ) . 'css/adminstyle.css' );
	wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'wpcr-script-handle', plugin_dir_url( __FILE__ ).'js/admin-script.js', array( 'wp-color-picker' ), false, true );
}
add_action( 'admin_enqueue_scripts', 'wpcr_admin_enqueue' );

////// wp enqueue scripts //////
function wpcr_enqueue_style() {

	wp_enqueue_script( 'wpcr_js', plugin_dir_url( __FILE__ ) . 'js/custom.js', array('jquery'),'1.0' , true );
    wp_enqueue_style( 'wpcr_font-awesome', plugin_dir_url( __FILE__ ) . 'css/font-awesome.css' );
	wp_enqueue_style( 'wpcr_style', plugin_dir_url( __FILE__ ) . 'css/style.css' );
}
add_action( 'wp_enqueue_scripts', 'wpcr_enqueue_style' );

///// Function to register form fields //////
function wpcr_register_options(){
    register_setting('wpcr_options_group', 'wpcr_settings', 'wpcr_validate');
}

///// Function to add hyperlinks to the admin menus using hooks and filters //////
function wpcr_admin_links() {
  add_options_page('Rating Setup', 'Post Rating', 'manage_options', 'commentrating', 'wpcr_admin_page' );  // add link to settings page
}

///// Validate User Input ///////
function wpcr_validate($input) {
  return array_map('wp_filter_nohtml_kses', (array)$input);
}

function wpcr_admin_page() { ?>
<div class="wpcsr_wrapper">
  <h2><?php _e('Rating Setting');?></h2>
  <div class="left-area">
  <form method="post" action="options.php">
  <?php
  settings_fields('wpcr_options_group');
  $wpcr_options = get_option('wpcr_settings');
  ?>
  
  <div class="row-outer">
  <div class="col-1">
  <span><?php _e('Enable rating with comment form');?></span>
  </div>
  <div class="col-2">
  <input type="checkbox" name="wpcr_settings[checkbox1]" value="yes" <?php checked('yes', $wpcr_options['checkbox1']); ?> />
  </div>
  </div>
  
  <div class="row-outer">
  <div class="col-1">
  <span><?php _e('Show average rating with post meta tags');?></span>
  </div>
  <div class="col-2">
  <input type="checkbox" name="wpcr_settings[checkbox2]" value="yes" <?php checked('yes', $wpcr_options['checkbox2']); ?> />
  </div>
  </div>
  
  <div class="row-outer">
  <div class="col-1">
  <span><?php _e('Rating label');?></span>
  </div>
  <div class="col-2">
  <input type="text" name="wpcr_settings[rtlabel]" placeholder="Please rate" value="<?php echo esc_attr( $wpcr_options['rtlabel']); ?>"  />
  </div>
  </div>
  
  <div class="row-outer">
  <div class="col-1">
  <span><?php _e('Text Color');?></span>
  </div>
  <div class="col-2">
  <input type="text" class="wpcrcolor-field" name="wpcr_settings[txtcolor]" value="<?php echo sanitize_hex_color( $wpcr_options['txtcolor'])?>" data-default-color="#ccc" />
  </div>
  </div>
 
  <?php submit_button(); ?>
  </form>
  <div class="donate-message" style="float:right;">
	<?php include (  plugin_dir_path( __FILE__ ) . 'inc/message.php');	?>
  </div>
  </div>
  
</div>
<?php } 

add_action( 'comment_form_top', 'wpcr_change_comment_form_defaults');
function wpcr_change_comment_form_defaults( ) {
	global $check;
	global $wpdb;
    
	//// get rating value from database
	$ratingValues = $wpdb->get_results( "SELECT meta_value FROM ".$wpdb->prefix."commentmeta WHERE meta_key = 'rating'");
	$results = $wpdb->get_results( "SELECT option_value FROM ".$wpdb->prefix."options WHERE option_name = 'wpcr_settings'");
	//var_dump(unserialize($results[0]->option_value));
	$a = unserialize($results[0]->option_value);
	$b = $a['checkbox1'];
	$check = $a['checkbox1'];
	$stars_label = $a['rtlabel'];
	if($stars_label !== ''){
		$st_label = $stars_label;
	}else{
		$st_label = 'Please rate';
	}
	
	if($b == 'yes'){
			
    echo '<fieldset class="rating">
    <legend>'.$st_label.'<span class="required">*</span></legend>
    <input type="radio" id="star5" name="rating" value="5" /><label for="star5" title="Rocks!">5 stars</label>
    <input type="radio" id="star4" name="rating" value="4" /><label for="star4" title="Pretty good">4 stars</label>
    <input type="radio" id="star3" name="rating" value="3" /><label for="star3" title="Meh">3 stars</label>
    <input type="radio" id="star2" name="rating" value="2" /><label for="star2" title="Kinda bad">2 stars</label>
    <input type="radio" id="star1" name="rating" value="1" /><label for="star1" title="Sucks big time">1 star</label>
	</fieldset>';
		
	}
}
 

//////// save comment meta data ////////
add_action( 'comment_post', 'wpcr_save_comment_meta_data' );

function wpcr_save_comment_meta_data( $comment_id ) {
	$rating =  (empty($_POST['rating'])) ? FALSE : $_POST['rating'];
    add_comment_meta( $comment_id, 'rating', $rating );
}

///////// validate meta field /////////
$review_setting = get_option( 'woocommerce_enable_review_rating' );
$options = get_option( 'wpcr_settings' );
if ( $options['checkbox1'] == 'yes' ) {
	
	add_filter( 'preprocess_comment', 'wpcr_verify_comment_meta_data' );
	
}
function wpcr_verify_comment_meta_data( $commentdata ) {
	
	if ( ! isset( $_POST['rating'] ) )
		if($_POST['comment_parent'] == 0)
			if ( 'product' != get_post_type() ) 			
        wp_die( __( 'Error: Please rate this post.' ) );
				
    return $commentdata;
}

//////// add average rating with post meta tags /////////
function wpcr_tag_aggr() {
	
	global $passedtext , $post;
	
	$args = array('post_id' => $post->ID);
	
	$comments = get_comments($args);
	//var_dump($comments);
	
	$sum = 0;
	$count=0;
	//if(is_single()){
    foreach($comments as $comment) :

        $approvedComment = $comment->comment_approved;

        if($approvedComment > 0){
            $rates = get_comment_meta( $comment->comment_ID, 'rating', true );
        }
        if($rates){
            $sum = $sum + (int)$rates;
            $count++;
        }

    endforeach;

    if($count != 0){
        $result = $sum/$count;
    }else{
		$result= 0;
	}
	global $wpdb;
	$chkresults = $wpdb->get_results( "SELECT option_value FROM ".$wpdb->prefix."options WHERE option_name = 'wpcr_settings'");
	$check2 = unserialize($chkresults[0]->option_value);
	$check_val = $check2['checkbox2'];
	
	$passedtext = $check_val;
	
	if($check_val == 'yes'){
		if($count != 0){ 
			echo '<a class="wpcr_tooltip" title="Average rating is '.round($result, 2).'"><span class="wpcr_stars" title="">';
			echo 'Average rating:';
			echo '</span>';
			echo '<span class="wpcr_averageStars" data-rating="'.$result.'"></span>';
			echo '</a>';
	} }
//}
}

add_filter( "the_tags", 'wpcr_tag_aggr' );


///// show rating stars with visitors comment /////////
add_filter('comment_text','wpcr_comment_tut_add_title_to_text',99,2);
function wpcr_comment_tut_add_title_to_text($text,$comment){ 
    
	global $passedtext;
	global $wpdb;
	$results = $wpdb->get_results( "SELECT option_value FROM ".$wpdb->prefix."options WHERE option_name = 'wpcr_settings'");
	$a = unserialize($results[0]->option_value);
	$check1 = $a['checkbox1'];
	
		
    if($title = get_comment_meta($comment->comment_ID,'rating',true))
    {
		
		if($check1 == 'yes' ){
        	$title = '<span class="wpcr_author_stars" data-rating="'.$title.'" ></span>';
			$text = $title.$text;
		}else{
			 $text = $text;
		}
        
    }
    return $text;
}
