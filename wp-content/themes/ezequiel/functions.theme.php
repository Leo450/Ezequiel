<?php

/*------------------------------------*\
	Functions
\*------------------------------------*/

// Load styles
function ez_styles()
{

	wp_register_style('bootstrap', get_template_directory_uri() . '/lib/bootstrap/css/bootstrap.grid.css', array(), '4.1.0', 'all');
	wp_enqueue_style('bootstrap');

	wp_register_style('theme', get_template_directory_uri() . '/css/style.css', array(), '1.0.0', 'all');
	wp_enqueue_style('theme');

	ez_load_page_template_asset("css");

	//if(is_single()){
		wp_register_style('single', get_template_directory_uri() . '/css/pages/single.css', array(), '1.0.0', 'all');
		wp_enqueue_style('single');
	//}

	if(is_404()){
		wp_register_style('404-index', get_template_directory_uri() . '/css/pages/404/index.css', array(), '1.0.0', 'all');
		wp_enqueue_style('404-index');
	}

	if(get_page_template_slug() == "template-members.php"){
		wp_register_style('project-index', get_template_directory_uri() . '/css/pages/project/index.css', array(), '1.0.0', 'all');
		wp_enqueue_style('project-index');
	}

}

// Load scripts
function ez_scripts()
{

	wp_register_script('footer-at-bottom', get_template_directory_uri() . '/js/footer-at-bottom.js', array(), '1.0.0', 'all');
	wp_enqueue_script('footer-at-bottom');

	wp_register_script('empty-p', get_template_directory_uri() . '/js/empty-p.js', array(), '1.0.0', 'all');
	wp_enqueue_script('empty-p');

	wp_register_script('mobile-menu', get_template_directory_uri() . '/js/mobile-menu.js', array(), '1.0.0', 'all');
	wp_enqueue_script('mobile-menu');

	wp_register_script('wp-post-comment-rating', get_template_directory_uri() . '/js/wp-post-comment-rating.js', array(), '1.0.0', 'all');
	wp_enqueue_script('wp-post-comment-rating');

	ez_load_page_template_asset("js");

	//if(is_single()){
		wp_register_script('single-layout', get_template_directory_uri() . '/js/single-layout.js', array(), '1.0.0', 'all');
		wp_enqueue_script('single-layout');
	//}

}

// Set php locale
function ez_set_locale()
{

	setlocale(LC_TIME, get_locale() . ".utf8");

}

function ez_open_comment_form_row()
{

	echo '<div class="row">';

}

function ez_close_comment_form_row()
{

	echo '</div>';

}

function ez_remove_some_comment_form_fields($fields)
{

	if(isset($fields['url'])){
		unset($fields['url']);
	}
	if(isset($fields['cookies'])){
		unset($fields['cookies']);
	}

	return $fields;

}

function ez_reorder_comment_form_fields($fields)
{

	if(isset($fields['comment']) && array_search("comment", array_keys($fields)) == 0){
		$comment_field = $fields['comment'];
		unset($fields['comment']);
		$fields['comment'] = $comment_field;
	}

	return $fields;

}

function ez_modify_comment_form_field_template($field)
{

	preg_match('/\<label.*?>(.*?)\<\/label\>/', $field, $label_matches);
	preg_match('/\<input.*?\\>/', $field, $input_matches);

	if(isset($label_matches[1]) && isset($input_matches[0])){
		$field = str_replace($label_matches[0], "", str_replace("/>", 'placeholder="' . strip_tags($label_matches[1]) . '" />', $field));
	}

	return '<div class="col-md-6">' . $field . '</div>';

}

function ez_modify_comment_form_comment_field_template($field)
{

	preg_match('/\<label.*?>(.*?)\<\/label\>/', $field, $label_matches);
	preg_match('/(\<textarea.*?\>)\<\/textarea\>/', $field, $input_matches);

	if(isset($label_matches[1]) && isset($input_matches[1])){
		$field = str_replace($label_matches[0], "", str_replace($input_matches[1], $input_matches[1] . $label_matches[1], $field));
	}

	return '<div class="row"><div class="col-12">' . $field . '</div></div>';

}

function ez_nav_menu_project_items($items)
{

	$menu_items = wp_get_nav_menu_items('project');
	$explode = explode("\n", $items);
	$output = "";

	foreach($menu_items as $k => $menu_item){

		$output .= str_replace('<span>', '<div class="project-menu-item-thumbnail" style="background-image:url(' . get_the_post_thumbnail_url((int)$menu_item->object_id) . ');"><div></div></div><span>', $explode[$k]);
	}

	return $output;

}

/*------------------------------------*\
	Menus
\*------------------------------------*/

function ez_register_menu()
{
	register_nav_menus([
		'project-menu' => __('Project Menu', 'ezequiel')
	]);
}

/*------------------------------------*\
	Custom Post Types
\*------------------------------------*/

function ez_cpt()
{

	register_post_type('home_slide',
		[
			'labels' => [
				'name' => __('Home Slides'),
				'singular_name' => __('Home Slide')
			],
			'public' => true,
			'has_archive' => true,
			'supports' => [
				'title',
				'editor',
				'thumbnail',
				'custom-fields'
			],
		]
	);

	register_post_type('log',
		[
			'labels' => [
				'name' => __('Log Book Posts'),
				'singular_name' => __('Log Book Post')
			],
			'public' => true,
			'has_archive' => true,
			'supports' => [
				'title',
				'editor',
				'thumbnail'
			],
		]
	);

	register_post_type('puppet',
		[
			'labels' => [
				'name' => __('Puppets'),
				'singular_name' => __('Puppet')
			],
			'public' => true,
			'has_archive' => true,
			'supports' => [
				'title',
				'editor',
				'thumbnail',
				'comments'
			],
		]
	);

	register_post_type('member',
		[
			'labels' => [
				'name' => __('Team Members'),
				'singular_name' => __('Team Member')
			],
			'public' => true,
			'has_archive' => true,
			'supports' => [
				'title',
				'editor',
				'thumbnail'
			],
		]
	);

}

/*------------------------------------*\
	Bind
\*------------------------------------*/

add_action('init', 'ez_set_locale');
add_action('init', 'ez_cpt');
add_action('init', 'ez_register_menu');
add_action('parse_query', 'ez_filter_dispatcher');
add_action('wp_enqueue_scripts', 'ez_styles');
add_action('wp_enqueue_scripts', 'ez_scripts');
add_filter('init', 'ez_add_blog_query_var');

// Form template modifications
add_action('comment_form_before_fields', 'ez_open_comment_form_row');
add_action('comment_form_after_fields', 'ez_close_comment_form_row');
add_filter('comment_form_default_fields', 'ez_remove_some_comment_form_fields');
add_filter('comment_form_fields', 'ez_reorder_comment_form_fields');
add_filter('comment_form_field_author', 'ez_modify_comment_form_field_template');
add_filter('comment_form_field_email', 'ez_modify_comment_form_field_template');
add_filter('comment_form_field_comment', 'ez_modify_comment_form_comment_field_template');
add_filter('wp_nav_menu_project_items', 'ez_nav_menu_project_items');

/*------------------------------------*\
	Helpers
\*------------------------------------*/

function ez_load_page_template_asset($file_ext)
{

	$page_template_slug = get_page_template_slug();

	if(!empty($page_template_slug)){
		$page_template_name = str_replace(".php", "", str_replace("template-", "", $page_template_slug));
		$asset_dir = get_template_directory() . '/' . $file_ext . '/pages/' . $page_template_name;
		$asset_dir_uri = get_template_directory_uri() . '/' . $file_ext . '/pages/' . $page_template_name;

		if(!is_dir($asset_dir)){
			return;
		}

		foreach(scandir($asset_dir) as $asset_file){
			if($asset_file == "." || $asset_file == ".."){
				continue;
			}

			$file_explode = explode(".", $asset_file);
			if(count($file_explode) != 2 || $file_explode[1] != $file_ext){
				continue;
			}

			switch($file_ext){
				case "css":
					wp_register_style($page_template_name . "-" . $file_explode[0], $asset_dir_uri . "/" . $asset_file, array(), '1.0.0', 'all');
					wp_enqueue_style($page_template_name . "-" . $file_explode[0]);
					break;

				case "js":
					wp_register_script($page_template_name . "-" . $file_explode[0], $asset_dir_uri . "/" . $asset_file, array(), '1.0.0', 'all');
					wp_enqueue_script($page_template_name . "-" . $file_explode[0]);
					break;
			}

		}

	}

}

/*------------------------------------*\
	Theme functions
\*------------------------------------*/

function ez_project_nav()
{
	wp_nav_menu(
		array(
			'theme_location'  => 'project-menu',
			'menu'            => '',
			'container'       => 'div',
			'container_class' => 'menu-{menu slug}-container',
			'container_id'    => '',
			'menu_class'      => 'menu',
			'menu_id'         => '',
			'echo'            => true,
			'fallback_cb'     => 'wp_page_menu',
			'before'          => '',
			'after'           => '',
			'link_before'     => '<span>',
			'link_after'      => '</span>',
			'items_wrap'      => '<ul class="project-menu">%3$s</ul>',
			'depth'           => 0,
			'walker'          => ''
		)
	);
}

function ez_pagination($query, $paged)
{

	echo '<div class="pagination"><div class="pagination-links">';

	echo paginate_links([
		'total' => $query->max_num_pages,
		'current' => $paged
	]);

	echo '</div><div class="clear"></div></div>';

}
