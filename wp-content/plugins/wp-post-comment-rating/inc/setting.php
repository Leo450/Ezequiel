<?php
add_action('wp_head', 'wpcr_style_options'); 

/////// change rating stars ///////
function wpcr_style_options() { 
	global $check;
	global $wpdb;
    
	$results = $wpdb->get_results( "SELECT option_value FROM ".$wpdb->prefix."options WHERE option_name = 'wpcr_settings'");
	$val = unserialize($results[0]->option_value);
	$label_color = $val['txtcolor'];
	
	?>
	<style>
		fieldset.rating > legend{
			color:<?php echo $label_color;?>
		}
	</style>
<?php
}
