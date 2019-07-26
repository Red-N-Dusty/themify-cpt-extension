<?php 
/**
 * Plugin Name: Integrate CPT
 * Description: Custom Post Type Integration for Themify Themes
 * Version: 1.0.0
 * Author: Joshua White - Lead Web Developer with NMCO Media
 * Author URI: https://nmcomedia.com
 */

$GLOBALS['_wp_post_type_features'];

// Define directory where the plugin is installed
define( 'NMCO_CPT_DIR', realpath( dirname( __FILE__ ) ) );

// Make sure we don't expose any info if called directly
defined( 'ABSPATH' )or die( 'No direct access allowed.' );

include( NMCO_CPT_DIR . '/includes/post-type-custom.php' );

//Load Class file after theme setup. This way we can access and extend the Themify class.
function makeClassVisible(){
    include( NMCO_CPT_DIR . '/includes/class-themify-cpt.php' );
}
add_action('after_setup_theme', 'makeClassVisible');

if ( is_admin() ) {
	add_action( 'admin_init', 'nmco_cpt_admin_init' );
	add_action( 'admin_menu', 'nmco_cpt_admin_menu' );
}

function nmco_cpt_admin_init() {
	register_setting( 'nmco_cpt', 'nmco_cpt_return_url', 'nmco_cpt_options_return_url_sanitize' );
	register_setting( 'nmco_cpt', 'nmco_cpt_post_types' );
}

function nmco_cpt_admin_menu() {
	add_options_page( 'CPT Themify Integration', 'CPT Themify Integration', 'manage_options', 'nmco_cpt', 'nmco_cpt_options' );
}

function nmco_cpt_options() {
	include( NMCO_CPT_DIR . '/admin/cpt_options.php' );
}

function nmco_cpt_options_return_url_sanitize( $value ) {
	if ( !empty( $value ) ) {
		$url = esc_url( $value, array( 'http', 'https' ) );
		if ( !$url ) {
			add_settings_error( 'nmco_cpt_return_url', 'invalid_url', __( 'The provided Return URL is invalid.' ) );
		}
	}

	return $url;
}

//Add global settings tab to Themify's settings page. 
function addCPTGlobal($arg) {

    $nmco_cpt_post_types = get_option('nmco_cpt_post_types');
    // remove Setting General and Default Layout Tab
    /*unset($arg['panel']['settings']['tab']['general']);
    unset($arg['panel']['settings']['tab']['default_layouts']);*/

    $modules = array();

    foreach($nmco_cpt_post_types as $postType){
        $postTObj = get_post_type_object($postType);
        $cptLabel = $postTObj->labels->name;
        $module =array( 
            array(
                'title' => $cptLabel.' Archive Layout',
                'function' => 'themify_default_cpt_layout'
            ),
            array(
                'title' => $cptLabel.' Single Post Layout',
                'function' => 'themify_default_cpt_post_layout'
            )
        );
        $modules = array_merge($modules, $module);
    }
    // add new settings options
    $arg['panel']['settings']['tab']['cpt_layouts'] = array(
        'title' => 'CPT Layouts',
        'id' => 'cpt_layouts',
        'custom-module' => $modules
    );

    return $arg;
};
add_filter('themify_theme_config_setup', 'addCPTGlobal');

//Filter the single post template to override the Themify options object
function filterSingle ($single_template){
    global $post;
    global $themify;
    $cpt_post_types = get_option('nmco_cpt_post_types');
    $post_type = $post->post_type;

    if(in_array($post_type, $cpt_post_types)){
        $themify = new ThemifyCPT($post_type);
    }
    $single_template = locate_template('single.php');

    return $single_template;
}
add_filter( 'single_template', 'filterSingle' );

//Filter the index template to override the Themify options object
function filterIndex ($index_template){
    global $post;
    global $themify;
    if(!$post){return;}
    $cpt_post_types = get_option('nmco_cpt_post_types');
    $post_type = $post->post_type;

    if(in_array($post_type, $cpt_post_types)){
        $themify = new ThemifyCPT($post_type);
    }
    $index_template = locate_template('index.php');
    /*global $wp_query;
    echo "<pre>";
    print_r($wp_query);
    echo "</pre>";*/

    return $index_template;
}
add_filter( 'index_template', 'filterIndex' );

?>