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

	wp_register_script('article-layout', get_template_directory_uri() . '/js/article-layout.js', array(), '1.0.0', 'all');
	wp_enqueue_script('article-layout');

	wp_register_script('thumbs-row', get_template_directory_uri() . '/js/thumbs-row.js', array(), '1.0.0', 'all');
	wp_enqueue_script('thumbs-row');

	wp_register_script('wp-post-comment-rating', get_template_directory_uri() . '/js/wp-post-comment-rating.js', array(), '1.0.0', 'all');
	wp_enqueue_script('wp-post-comment-rating');

	ez_load_page_template_asset("js");

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
		$field = str_replace($label_matches[0], "", str_replace($input_matches[1], str_replace(">", 'placeholder="' . $label_matches[1] . '">', $input_matches[1]), $field));
	}

	return '<div class="row"><div class="col-12">' . $field . '</div></div>';

}

function ez_nav_menu_project_items($items)
{

	global $post;

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
			'has_archive' => false,
			'hierarchical' => false,
			'supports' => [
				'title',
				'editor',
				'thumbnail',
				'custom-fields',
				'page-attributes'
			],
		]
	);

	register_post_type('log',
		[
			'labels' => [
				'name' => __('Carnet de bord'),
				'singular_name' => __('Article carnet de bord')
			],
			'public' => true,
			'has_archive' => false,
			'supports' => [
				'title',
				'editor',
				'thumbnail',
				'comments'
			],
		]
	);

	register_post_type('puppet',
		[
			'labels' => [
				'name' => __('Marionnettes'),
				'singular_name' => __('Marionnette')
			],
			'public' => true,
			'has_archive' => false,
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
				'name' => __('L\'équipe'),
				'singular_name' => __('Membre de l\'équipe')
			],
			'public' => true,
			'has_archive' => false,
			'supports' => [
				'title',
				'editor',
				'thumbnail',
				'custom-fields'
			],
		]
	);

	register_post_type('agenda',
		[
			'labels' => [
				'name' => __('Agenda'),
				'singular_name' => __('Date')
			],
			'public' => true,
			'has_archive' => false,
			'supports' => [
				'title',
				'editor',
				'custom-fields'
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



// Breadcrumbs
function custom_breadcrumbs() {

	// Settings
	$separator          = '&gt;';
	$breadcrums_id      = 'breadcrumbs';
	$breadcrums_class   = 'breadcrumbs';
	$home_title         = 'Accueil';

	// If you have any custom post types with custom taxonomies, put the taxonomy name below (e.g. product_cat)
	$custom_taxonomy    = 'product_cat';

	// Get the query & post information
	global $post,$wp_query;

	// Do not display on the homepage
	if ( !is_front_page() ) {

		// Build the breadcrums
		echo '<ul id="' . $breadcrums_id . '" class="' . $breadcrums_class . '">';

		// Home page
		echo '<li class="breadcrumb-item breadcrumb-item-home"><a class="bread-link bread-home" href="' . get_home_url() . '" title="' . $home_title . '">' . $home_title . '</a></li>';
		echo '<li class="separator separator-home"> ' . $separator . ' </li>';

		if ( is_archive() && !is_tax() && !is_category() && !is_tag() ) {

			echo '<li class="breadcrumb-item breadcrumb-item-current breadcrumb-item-archive"><strong class="bread-current bread-archive">' . post_type_archive_title($prefix, false) . '</strong></li>';

		} else if ( is_archive() && is_tax() && !is_category() && !is_tag() ) {

			// If post is a custom post type
			$post_type = get_post_type();

			// If it is a custom post type display name and link
			if($post_type != 'post') {

				$post_type_object = get_post_type_object($post_type);
				$post_type_archive = get_post_type_archive_link($post_type);

				echo '<li class="breadcrumb-item breadcrumb-item-cat breadcrumb-item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
				echo '<li class="separator"> ' . $separator . ' </li>';

			}

			$custom_tax_name = get_queried_object()->name;
			echo '<li class="breadcrumb-item breadcrumb-item-current breadcrumb-item-archive"><strong class="bread-current bread-archive">' . $custom_tax_name . '</strong></li>';

		} else if ( is_single() ) {

			// If post is a custom post type
			$post_type = get_post_type();

			if($post_type == 'post'){

				$blog_page = get_page_by_title('Blog');
				echo '<li class="breadcrumb-item breadcrumb-item-parent breadcrumb-item-parent-' . $blog_page->ID . '"><a class="bread-parent bread-parent-' . $blog_page->ID . '" href="' . get_permalink($blog_page->ID) . '?filter=post" title="' . $blog_page->post_title . '">' . $blog_page->post_title . '</a></li>';
				echo '<li class="separator separator-' . $blog_page->ID . '"> ' . $separator . ' </li>';

			}elseif($post_type == 'log'){

				$blog_page = get_page_by_title('Blog');
				echo '<li class="breadcrumb-item breadcrumb-item-parent breadcrumb-item-parent-' . $blog_page->ID . '"><a class="bread-parent bread-parent-' . $blog_page->ID . '" href="' . get_permalink($blog_page->ID) . '?filter=log" title="' . $blog_page->post_title . '">' . $blog_page->post_title . '</a></li>';
				echo '<li class="separator separator-' . $blog_page->ID . '"> ' . $separator . ' </li>';

			}elseif($post_type == 'puppet'){

				$project_page = get_page_by_title('Le projet');
				$puppets_page = get_page_by_title('Les marionnettes');
				$puppets_gallery_page = get_page_by_title('Galerie marionnettes');

				echo '<li class="breadcrumb-item breadcrumb-item-parent breadcrumb-item-parent-' . $project_page->ID . '"><a class="bread-parent bread-parent-' . $project_page->ID . '" href="' . get_permalink($project_page->ID) . '" title="' . $project_page->post_title . '">' . $project_page->post_title . '</a></li>';
				echo '<li class="separator separator-' . $project_page->ID . '"> ' . $separator . ' </li>';
				echo '<li class="breadcrumb-item breadcrumb-item-parent breadcrumb-item-parent-' . $puppets_page->ID . '"><a class="bread-parent bread-parent-' . $puppets_page->ID . '" href="' . get_permalink($puppets_page->ID) . '" title="' . $puppets_page->post_title . '">' . $puppets_page->post_title . '</a></li>';
				echo '<li class="separator separator-' . $puppets_page->ID . '"> ' . $separator . ' </li>';
				echo '<li class="breadcrumb-item breadcrumb-item-parent breadcrumb-item-parent-' . $puppets_gallery_page->ID . '"><a class="bread-parent bread-parent-' . $puppets_gallery_page->ID . '" href="' . get_permalink($puppets_gallery_page->ID) . '" title="' . $puppets_gallery_page->post_title . '">' . $puppets_gallery_page->post_title . '</a></li>';
				echo '<li class="separator separator-' . $puppets_gallery_page->ID . '"> ' . $separator . ' </li>';

			}elseif($post_type == 'member'){

				$project_page = get_page_by_title('Le projet');
				$members_page = get_page_by_title('Rencontre avec l\'équipe artistique');

				echo '<li class="breadcrumb-item breadcrumb-item-parent breadcrumb-item-parent-' . $project_page->ID . '"><a class="bread-parent bread-parent-' . $project_page->ID . '" href="' . get_permalink($project_page->ID) . '" title="' . $project_page->post_title . '">' . $project_page->post_title . '</a></li>';
				echo '<li class="separator separator-' . $project_page->ID . '"> ' . $separator . ' </li>';
				echo '<li class="breadcrumb-item breadcrumb-item-parent breadcrumb-item-parent-' . $members_page->ID . '"><a class="bread-parent bread-parent-' . $members_page->ID . '" href="' . get_permalink($members_page->ID) . '" title="' . $members_page->post_title . '">' . $members_page->post_title . '</a></li>';
				echo '<li class="separator separator-' . $members_page->ID . '"> ' . $separator . ' </li>';

			}else{

				$post_type_object = get_post_type_object($post_type);
				$post_type_archive = get_post_type_archive_link($post_type);

				echo '<li class="breadcrumb-item breadcrumb-item-cat breadcrumb-item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
				echo '<li class="separator"> ' . $separator . ' </li>';

			}

			// Get post category info
			/*$category = get_the_category();

			if(!empty($category)) {

				// Get last category post is in
				$last_category = end(array_values($category));

				// Get parent any categories and create array
				$get_cat_parents = rtrim(get_category_parents($last_category->term_id, true, ','),',');
				$cat_parents = explode(',',$get_cat_parents);

				// Loop through parent categories and store in variable $cat_display
				$cat_display = '';
				foreach($cat_parents as $parents) {
					$cat_display .= '<li class="breadcrumb-item breadcrumb-item-cat">'.$parents.'</li>';
					$cat_display .= '<li class="separator"> ' . $separator . ' </li>';
				}

			}*/

			// If it's a custom post type within a custom taxonomy
			$taxonomy_exists = taxonomy_exists($custom_taxonomy);
			if(empty($last_category) && !empty($custom_taxonomy) && $taxonomy_exists) {

				$taxonomy_terms = get_the_terms( $post->ID, $custom_taxonomy );
				$cat_id         = $taxonomy_terms[0]->term_id;
				$cat_nicename   = $taxonomy_terms[0]->slug;
				$cat_link       = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy);
				$cat_name       = $taxonomy_terms[0]->name;

			}

			// Check if the post is in a category
			if(!empty($last_category)) {
				echo $cat_display;
				echo '<li class="breadcrumb-item breadcrumb-item-current breadcrumb-item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';

				// Else if post is in a custom taxonomy
			} else if(!empty($cat_id)) {

				echo '<li class="breadcrumb-item breadcrumb-item-cat breadcrumb-item-cat-' . $cat_id . ' breadcrumb-item-cat-' . $cat_nicename . '"><a class="bread-cat bread-cat-' . $cat_id . ' bread-cat-' . $cat_nicename . '" href="' . $cat_link . '" title="' . $cat_name . '">' . $cat_name . '</a></li>';
				echo '<li class="separator"> ' . $separator . ' </li>';
				echo '<li class="breadcrumb-item breadcrumb-item-current breadcrumb-item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';

			} else {

				echo '<li class="breadcrumb-item breadcrumb-item-current breadcrumb-item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';

			}

		} else if ( is_category() ) {

			// Category page
			echo '<li class="breadcrumb-item breadcrumb-item-current breadcrumb-item-cat"><strong class="bread-current bread-cat">' . single_cat_title('', false) . '</strong></li>';

		} else if ( is_page() ) {

			// Standard page
			if( $post->post_parent ){

				// If child page, get parents
				$anc = get_post_ancestors( $post->ID );

				// Get parents in the right order
				$anc = array_reverse($anc);

				// Parent page loop
				if ( !isset( $parents ) ) $parents = null;
				foreach ( $anc as $ancestor ) {
					$parents .= '<li class="breadcrumb-item breadcrumb-item-parent breadcrumb-item-parent-' . $ancestor . '"><a class="bread-parent bread-parent-' . $ancestor . '" href="' . get_permalink($ancestor) . '" title="' . get_the_title($ancestor) . '">' . get_the_title($ancestor) . '</a></li>';
					$parents .= '<li class="separator separator-' . $ancestor . '"> ' . $separator . ' </li>';
				}

				// Display parent pages
				echo $parents;

				// Current page
				echo '<li class="breadcrumb-item breadcrumb-item-current breadcrumb-item-' . $post->ID . '"><strong title="' . get_the_title() . '"> ' . get_the_title() . '</strong></li>';

			} else {

				// Just display current page if not parents
				echo '<li class="breadcrumb-item breadcrumb-item-current breadcrumb-item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '"> ' . get_the_title() . '</strong></li>';

			}

		} else if ( is_tag() ) {

			// Tag page

			// Get tag information
			$term_id        = get_query_var('tag_id');
			$taxonomy       = 'post_tag';
			$args           = 'include=' . $term_id;
			$terms          = get_terms( $taxonomy, $args );
			$get_term_id    = $terms[0]->term_id;
			$get_term_slug  = $terms[0]->slug;
			$get_term_name  = $terms[0]->name;

			// Display the tag name
			echo '<li class="breadcrumb-item breadcrumb-item-current breadcrumb-item-tag-' . $get_term_id . ' breadcrumb-item-tag-' . $get_term_slug . '"><strong class="bread-current bread-tag-' . $get_term_id . ' bread-tag-' . $get_term_slug . '">' . $get_term_name . '</strong></li>';

		} elseif ( is_day() ) {

			// Day archive

			// Year link
			echo '<li class="breadcrumb-item breadcrumb-item-year breadcrumb-item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
			echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';

			// Month link
			echo '<li class="breadcrumb-item breadcrumb-item-month breadcrumb-item-month-' . get_the_time('m') . '"><a class="bread-month bread-month-' . get_the_time('m') . '" href="' . get_month_link( get_the_time('Y'), get_the_time('m') ) . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</a></li>';
			echo '<li class="separator separator-' . get_the_time('m') . '"> ' . $separator . ' </li>';

			// Day display
			echo '<li class="breadcrumb-item breadcrumb-item-current breadcrumb-item-' . get_the_time('j') . '"><strong class="bread-current bread-' . get_the_time('j') . '"> ' . get_the_time('jS') . ' ' . get_the_time('M') . ' Archives</strong></li>';

		} else if ( is_month() ) {

			// Month Archive

			// Year link
			echo '<li class="breadcrumb-item breadcrumb-item-year breadcrumb-item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
			echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';

			// Month display
			echo '<li class="breadcrumb-item breadcrumb-item-month breadcrumb-item-month-' . get_the_time('m') . '"><strong class="bread-month bread-month-' . get_the_time('m') . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</strong></li>';

		} else if ( is_year() ) {

			// Display year archive
			echo '<li class="breadcrumb-item breadcrumb-item-current breadcrumb-item-current-' . get_the_time('Y') . '"><strong class="bread-current bread-current-' . get_the_time('Y') . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</strong></li>';

		} else if ( is_author() ) {

			// Auhor archive

			// Get the author information
			global $author;
			$userdata = get_userdata( $author );

			// Display author name
			echo '<li class="breadcrumb-item breadcrumb-item-current breadcrumb-item-current-' . $userdata->user_nicename . '"><strong class="bread-current bread-current-' . $userdata->user_nicename . '" title="' . $userdata->display_name . '">' . 'Author: ' . $userdata->display_name . '</strong></li>';

		} else if ( get_query_var('paged') ) {

			// Paginated archives
			echo '<li class="breadcrumb-item breadcrumb-item-current breadcrumb-item-current-' . get_query_var('paged') . '"><strong class="bread-current bread-current-' . get_query_var('paged') . '" title="Page ' . get_query_var('paged') . '">'.__('Page') . ' ' . get_query_var('paged') . '</strong></li>';

		} else if ( is_search() ) {

			// Search results page
			echo '<li class="breadcrumb-item breadcrumb-item-current breadcrumb-item-current-' . get_search_query() . '"><strong class="bread-current bread-current-' . get_search_query() . '" title="Search results for: ' . get_search_query() . '">Search results for: ' . get_search_query() . '</strong></li>';

		} elseif ( is_404() ) {

			// 404 page
			echo '<li>' . 'Error 404' . '</li>';
		}

		echo '</ul>';

	}

}