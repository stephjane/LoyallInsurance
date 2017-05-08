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
			'name'               => 'Resources',
			'singular_name'      => 'Resource',
			'menu_name'          => 'Resources',
			'name_admin_bar'     => 'Resource',
			'add_new'            => 'Add New',
			'add_new_item'       => 'Add New Resource',
			'new_item'           => 'New Resource',
			'edit_item'          => 'Edit Resource',
			'view_item'          => 'View Resource',
			'all_items'          => 'All Resources',
			'search_items'       => 'Search Resources',
			'parent_item_colon'  => 'Parent Resources:',
			'not_found'          => 'No resources found.',
			'not_found_in_trash' => 'No resources found in Trash.'
		);
		$args = array(
			'labels'             => $labels,
	        'description'        => 'Resources',
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'resources' ),
			'capability_type'    => 'post',
			'has_archive'        => false,
			'hierarchical'       => false,
			'menu_position'      => null,
			'taxonomies'         => array(),
			'supports'           => array( 'title' )
		);
		register_post_type( 'resource', $args );
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

