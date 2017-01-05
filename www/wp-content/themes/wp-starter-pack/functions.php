<?php

// =================================================
// ENQUEUE SCRIPTS
// This is the best way to include local and 3rd party scripts into a Wordpress theme
// =================================================

function remove_query_string( $src ){
    return remove_query_arg( 'ver', $src );
}
add_filter( 'script_loader_src', 'remove_query_string' );
add_filter( 'style_loader_src', 'remove_query_string' );

add_action( 'wp_enqueue_scripts', 'register_jquery' );
function register_jquery() {
    wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', ( 'https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js' ), false, null, true );
    wp_enqueue_script( 'jquery' );
}

wp_enqueue_script('jquery', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.1/jquery.min.js', false, '1', true);
wp_enqueue_script('slick', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.9/slick.min.js', false, '1', true);
wp_enqueue_script('mixitup', 'https://cdnjs.cloudflare.com/ajax/libs/mixitup/2.1.11/jquery.mixitup.min.js', false, '1', true);
wp_enqueue_script('picturefill', 'https://cdnjs.cloudflare.com/ajax/libs/picturefill/3.0.2/picturefill.min.js', false, '1', true);
wp_enqueue_script('main', get_template_directory_uri() . '/scripts/main.min.js', array('jquery', 'slick', 'mixitup'), '1', true);

// =================================================
// CUSTOM POSTS CONFIGURATION
// Here's where you configure all of your custom post types.
// =================================================


function all_custom_post_types() {
	$types = array(
		array(
			'the_type' => 'custom-post',
			'single' => 'Custom Post',
			'plural' => 'Custom Posts',
			'queryable' => 'true',
			'icon' => 'dashicons-cart'
		)
	);

	foreach ($types as $type) {

		$the_type = $type['the_type'];
		$single = $type['single'];
		$plural = $type['plural'];
		$queryable = $type['queryable'];
		$icon = $type['icon'];

		$labels = array(
		    'name' => _x($plural, 'post type general name'),
		    'singular_name' => _x($single, 'post type singular name'),
		    'add_new' => _x('Add New', $single),
		    'add_new_item' => __('Add New '. $single),
		    'edit_item' => __('Edit '.$single),
		    'new_item' => __('New '.$single),
		    'view_item' => __('View '.$single),
		    'search_items' => __('Search '.$plural),
		    'not_found' =>  __('No '.$plural.' found'),
		    'not_found_in_trash' => __('No '.$plural.' found in Trash'),
		    'parent_item_colon' => ''
		  );

		  $args = array(
		    'labels' => $labels,
		    'public' => true,
		    'publicly_queryable' => $queryable,
		    'show_ui' => true,
		    'query_var' => true,
		    'rewrite' => true,
		    'capability_type' => 'post',
		    'hierarchical' => false,
		    'menu_position' => null,
		    'menu_icon' => $icon,
		    'supports' => array('title','editor','thumbnail','custom-fields')
		  );

		  register_post_type($the_type, $args);

	}

}

add_action('init', 'all_custom_post_types');

// =================================================
// CHANGE POSTS TO NEWS
// This is optional - to remove simply delete this section
// =================================================

function news_change_post_label() {
    global $menu;
    global $submenu;
    $menu[5][0] = 'News';
    $submenu['edit.php'][5][0] = 'News';
    $submenu['edit.php'][10][0] = 'Add News';
    $submenu['edit.php'][16][0] = 'News Tags';
    echo '';
}
function news_change_post_object() {
    global $wp_post_types;
    $labels = &$wp_post_types['post']->labels;
    $labels->name = 'News';
    $labels->singular_name = 'News Story';
    $labels->add_new = 'Add News Story';
    $labels->add_new_item = 'Add News Story';
    $labels->edit_item = 'Edit News Story';
    $labels->new_item = 'News Story';
    $labels->view_item = 'View News Story';
    $labels->search_items = 'Search News Stories';
    $labels->not_found = 'No News stories found';
    $labels->not_found_in_trash = 'No News stories found in Trash';
    $labels->all_items = 'All News Stories';
    $labels->menu_name = 'News';
    $labels->name_admin_bar = 'News';
}
 
add_action( 'admin_menu', 'news_change_post_label' );
add_action( 'init', 'news_change_post_object' );


// =================================================
// CUSTOM TAXONOMIES
// This is where you set up custom taxonomies for custom post types
// =================================================

function custom_register_taxonomies() {
	$taxonomies = array(
		array(
			'slug'         => 'custom-taxonomy',
			'single_name'  => 'Custom Taxonomy',
			'plural_name'  => 'Custom Taxonomies',
			'post_type'    => 'custom-taxes',
			'rewrite'      => array( 'slug' => 'custom-tax' ),
		),
	);
	foreach( $taxonomies as $taxonomy ) {
		$labels = array(
			'name' => $taxonomy['plural_name'],
			'singular_name' => $taxonomy['single_name'],
			'search_items' =>  'Search ' . $taxonomy['plural_name'],
			'all_items' => 'All ' . $taxonomy['plural_name'],
			'parent_item' => 'Parent ' . $taxonomy['single_name'],
			'parent_item_colon' => 'Parent ' . $taxonomy['single_name'] . ':',
			'edit_item' => 'Edit ' . $taxonomy['single_name'],
			'update_item' => 'Update ' . $taxonomy['single_name'],
			'add_new_item' => 'Add New ' . $taxonomy['single_name'],
			'new_item_name' => 'New ' . $taxonomy['single_name'] . ' Name',
			'menu_name' => $taxonomy['plural_name']
		);
		
		$rewrite = isset( $taxonomy['rewrite'] ) ? $taxonomy['rewrite'] : array( 'slug' => $taxonomy['slug'] );
		$hierarchical = isset( $taxonomy['hierarchical'] ) ? $taxonomy['hierarchical'] : true;
	
		register_taxonomy( $taxonomy['slug'], $taxonomy['post_type'], array(
			'hierarchical' => $hierarchical,
			'labels' => $labels,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => $rewrite,
			'show_admin_column' => true,
		));
	}
	
}
add_action( 'init', 'custom_register_taxonomies' );


// =================================================
// CUSTOM NAVIGATION
// This is where you set up custom navigation
// =================================================

add_theme_support ('nav_menus');
if ( function_exists ('register_nav_menus')) {
	
register_nav_menus (
	array (
		'primary-nav' => 'Primary navigation',
		)
		);
}

// =================================================
// PREVENT IMAGES BEING WRAPPED IN <P> TAGS
// WP wraps <img> tags in <p> tags in a content area by default, this function removes the <p> tag
// =================================================

function filter_ptags_on_images($content)
{
    $content = preg_replace('/<p>\s*(<a .*>)?\s*(<img .* \/>)\s*(<\/a>)?\s*<\/p>/iU', '\1\2\3', $content);
    return preg_replace('/<p>\s*(<iframe .*>*.<\/iframe>)\s*<\/p>/iU', '\1', $content);
}
add_filter('acf_the_content', 'filter_ptags_on_images');

// =================================================
// WRAP VIDEO IN A DIV
// This function allows us to make embedded videos from YouTube/Vimeo/wherever responsive by wrapping the iframe tag in parent containers
// =================================================

function my_embed_oembed_html($html, $url, $attr, $post_id) {
	return '<div class="video-embed--outer"><div class="video-embed">' . $html . '</div></div>';
}

add_filter('embed_oembed_html', 'my_embed_oembed_html', 99, 4);

// =================================================
// ALLOW SVG TO UPLOADED VIA MEDIA UPLOADER
// Obvious one!
// =================================================

function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

// =================================================
// REMOVE CONTACT FORM 7 STYLES
// This function removes the nasty CF7 styling that the plugin applies out of the box
// =================================================

add_action( 'wp_print_styles', 'deregister_cf7_styles', 100 );
function deregister_cf7_styles() {
    if ( !is_page(100) ) {
        wp_deregister_style( 'contact-form-7' );
    }
}

add_filter( 'wpcf7_load_js', '__return_false' );

// =================================================
// SVG SHORTHAND FUNCTION
// Meaning we don't have to write the whole svg syntax out over and over
// =================================================

function svg($width, $height, $icon) {

	return "<i><svg viewBox='0 0 {$width} {$height}'><use xmlns:xlink='http://www.w3.org/1999/xlink' xlink:href='" . get_stylesheet_directory_uri() . "/images/vectors.svg#{$icon}'></use></svg></i>";

}

function icon($icon) {

	return "<i><svg viewBox='0 0 32 32'><use xmlns:xlink='http://www.w3.org/1999/xlink' xlink:href='" . get_stylesheet_directory_uri() . "/images/vectors.svg#{$icon}'></use></svg></i>";

}

// =================================================
// ACF OPTIONS PAGE
// Adding an 'options' page for globally editable content such as addresses, contact info etc. is a great idea
// =================================================


if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page();
	
	acf_add_options_sub_page('Contact information');
	
}

// =================================================
// ACF RESPONSIVE IMAGES
// Allows us to use responsive images and ACF. You can only use this function when you use the image array option in ACF.
// =================================================

function acf_img($img, $echo=false) {
	$html = '';

	if(isset($img['sizes'])) {
		$html= '<img 
				src="' . $img['sizes']['medium_large'] . '"
				srcset="' . $img['url'] . ' 960w, ' . $img['sizes']['medium_large'] . ' 768w, ' . $img['sizes']['medium'] . ' 320w"
				sizes="100vw"
				alt="' . $img['alt'] . '"
			/>';
	}
	if($echo){
		echo $html;
	} else {
		return $html;
	}

}

// =================================================
// CLEANING UP THE HEAD
// These functions removes a lot of uneccessary crud from the <head>
// =================================================

function removeHeadLinks() {
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wlwmanifest_link');
}
add_action('init', 'removeHeadLinks');
remove_action('wp_head', 'wp_generator');

remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

