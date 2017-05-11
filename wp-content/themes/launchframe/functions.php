<?php

if ( ! class_exists( 'Timber' ) ) {
	add_action( 'admin_notices', function() {
			echo '<div class="error"><p>Timber not activated. Make sure you activate the plugin in <a href="' . esc_url( admin_url( 'plugins.php#timber' ) ) . '">' . esc_url( admin_url( 'plugins.php' ) ) . '</a></p></div>';
		} );
	return;
}

Timber::$dirname = array('templates', 'views');

require get_template_directory() . '/inc/version.php';
global $package_version;

class LaunchframeSite extends TimberSite {

	function __construct() {
		add_theme_support( 'post-formats' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'menus' );
		add_filter( 'timber_context', array( $this, 'add_to_context' ) );
// 		add_filter( 'get_twig', array( $this, 'add_to_twig' ) );
		add_action( 'init', array( $this, 'register_post_types' ) );
		add_action( 'init', array( $this, 'register_taxonomies' ) );
    add_action('wp_enqueue_scripts', array( $this, 'lf_cleanup'));
    add_action( 'wp_enqueue_scripts', array( $this, 'register_stylesheets' ) );
    add_action( 'wp_enqueue_scripts', array( $this, 'register_scripts' ) );
		parent::__construct();
	}


  function lf_cleanup() {
    wp_deregister_script('jquery');
    remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );
  }

  function register_stylesheets() {
    global $package_version;
    wp_enqueue_style( 'application-style', get_template_directory_uri() . '/assets/dist/css/application.min.css', true, $package_version );
  }
  function register_scripts() {
  	global $package_version;
    wp_enqueue_style( 'application-js', get_template_directory_uri() . '/assets/dist/js/script.min.js', true, $package_version );
  }

	function register_post_types() {
		$labels = array(
			'name'               => 'Videos',
			'singular_name'      => 'Video',
			'menu_name'          => 'Videos',
			'name_admin_bar'     => 'Video',
			'add_new'            => 'Add New',
			'add_new_item'       => 'Add New Video',
			'new_item'           => 'New Video',
			'edit_item'          => 'Edit Video',
			'view_item'          => 'View Video',
			'all_items'          => 'All Videos',
			'search_items'       => 'Search Videos',
			'parent_item_colon'  => 'Parent Videos:',
			'not_found'          => 'No videos found.',
			'not_found_in_trash' => 'No videos found in Trash.'
		);
		$args = array(
			'labels'             => $labels,
	        'description'        => 'Videos',
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'videos' ),
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'menu_position'      => null,
			'taxonomies'         => array(),
			'supports'           => array( 'title' )
		);
		register_post_type( 'video', $args );

		$labels = array(
			'name'               => 'Jobs',
			'singular_name'      => 'Job',
			'menu_name'          => 'Jobs',
			'name_admin_bar'     => 'Job',
			'add_new'            => 'Add New',
			'add_new_item'       => 'Add New Job',
			'new_item'           => 'New Job',
			'edit_item'          => 'Edit Job',
			'view_item'          => 'View Job',
			'all_items'          => 'All Jobs',
			'search_items'       => 'Search Jobs',
			'parent_item_colon'  => 'Parent Jobs:',
			'not_found'          => 'No jobs found.',
			'not_found_in_trash' => 'No jobs found in Trash.'
		);
		$args = array(
			'labels'             => $labels,
	        'description'        => 'Jobs',
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'jobs' ),
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'menu_position'      => null,
			'taxonomies'         => array(),
			'supports'           => array( 'title' )
		);
		register_post_type( 'job', $args );

		$labels = array(
			'name'               => 'Announcements',
			'singular_name'      => 'Announcement',
			'menu_name'          => 'Announcements',
			'name_admin_bar'     => 'Announcement',
			'add_new'            => 'Add New',
			'add_new_item'       => 'Add New Announcement',
			'new_item'           => 'New Announcement',
			'edit_item'          => 'Edit Announcement',
			'view_item'          => 'View Announcement',
			'all_items'          => 'All Announcements',
			'search_items'       => 'Search Announcements',
			'parent_item_colon'  => 'Parent Announcements:',
			'not_found'          => 'No announcements found.',
			'not_found_in_trash' => 'No announcements found in Trash.'
		);
		$args = array(
			'labels'             => $labels,
	        'description'        => 'Announcements',
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'announcements' ),
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'menu_position'      => null,
			'taxonomies'         => array(),
			'supports'           => array( 'title' )
		);
		register_post_type( 'announcement', $args );

		$labels = array(
			'name'               => 'Articles',
			'singular_name'      => 'Article',
			'menu_name'          => 'Articles',
			'name_admin_bar'     => 'Article',
			'add_new'            => 'Add New',
			'add_new_item'       => 'Add New Article',
			'new_item'           => 'New Article',
			'edit_item'          => 'Edit Article',
			'view_item'          => 'View Article',
			'all_items'          => 'All Articles',
			'search_items'       => 'Search Articles',
			'parent_item_colon'  => 'Parent Articles:',
			'not_found'          => 'No articles found.',
			'not_found_in_trash' => 'No articles found in Trash.'
		);
		$args = array(
			'labels'             => $labels,
	        'description'        => 'Articles',
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'articles' ),
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'menu_position'      => null,
			'taxonomies'         => array(),
			'supports'           => array( 'title' )
		);
		register_post_type( 'article', $args );
	}

	function register_taxonomies() {
		//this is where you can register custom taxonomies
	}

	function add_to_context( $context ) {
		$context['menu'] = new TimberMenu();
		$context['site'] = $this;
		return $context;
	}

	function add_to_twig( $twig ) {
		/* this is where you can add your own fuctions to twig */
		//$twig->addExtension( new Twig_Extension_StringLoader() );
		//$twig->addFilter( 'myfoo', new Twig_Filter_Function( 'myfoo' ) );
		//return $twig;
	}

}

/************* HIDE ACF FROM MENU ***************/
add_filter('acf/settings/show_admin', 'my_acf_show_admin');

function my_acf_show_admin( $show ) {
	$current_user = wp_get_current_user();

    if ($current_user->user_login == 'loyall') {
    	return current_user_can('manage_options');
    } elseif ($current_user->user_login == 'admin') {
    	return current_user_can('manage_options');
    } else {
    	return false;
    }
}
/************* END HIDE ACF FROM MENU ***************/

/************* ACF OPTIONS PAGE ***************/

function mytheme_timber_context( $context ) {
    $context['option'] = get_fields('option');
    return $context;
}
add_filter( 'timber_context', 'mytheme_timber_context'  );

if( function_exists('acf_add_options_sub_page') ) {
	acf_add_options_sub_page(array(
		'page_title' => 'Site Options',
		'menu_title' => 'Site Options',
		'menu_slug' => 'site_options',
		'capability' => 'edit_posts',
		'parent_slug' => '',
		'position' => false,
		'icon_url' => false,
		'redirect' => false,
	));
}

/************* END OPTIONS PAGE ***************/

// /************* CUSTOMIZE LOGIN LOGO ***************/
// add_action("login_head", "my_login_head");
// function my_login_head() {
// 	echo "
// 	<style>
// 	body.login #login h1 a {
// 		background: url('".get_bloginfo('template_url')."/assets/src/img/logo.png') no-repeat scroll center top transparent;
// 		height: 80px;
// 		width: 300px;
// 	}
// 	</style>
// 	";
// }
// /************* END ***************/

// /************* REMOVE APPEARANCE CUSTOMIZE ***************/

// function remove_customize_page(){
// 	global $submenu;
// 	unset($submenu['themes.php'][6]);
// }
// add_action('admin_menu', 'remove_customize_page');

// /************* END REMOVE APPEARANCE CUSTOMIZE ***************/

/************* HIDE DEFAULT POST TYPE MENU ***************/
// add_action('admin_menu','remove_default_post_type');    function remove_default_post_type() {  	remove_menu_page('edit.php');  }
/************* END HIDE DEFAULT POST TYPE MENU ***************/

new LaunchframeSite();

