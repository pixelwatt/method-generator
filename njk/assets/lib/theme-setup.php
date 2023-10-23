{% import '_globals.html' as globals %}{% extends "_barebones.html" %}{% block content %}<?php

//-----------------------------------------------------
// Theme and Post Support
//-----------------------------------------------------

function {{globals.code_prefix}}enable_theme_support() {
{% if globals.theme_support_html5 %}
	// Add theme support for html5 markup
	$args = array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'script',
		'style',
	);
	add_theme_support( 'html5', $args );{% endif %}
{% if globals.theme_support_titletag %}
	// Add theme support for the title tag
	add_theme_support( 'title-tag' );{% endif %}
{% if globals.theme_support_thumbnails %}
	// Add theme support for post thumbnails
	add_theme_support( 'post-thumbnails' );{% endif %}
}
add_action( 'after_setup_theme', '{{globals.code_prefix}}enable_theme_support' );

{% if globals.nav_menus %}
function {{globals.code_prefix}}register_custom_nav_menus() {
	register_nav_menus(
		array({% for item in globals.nav_menus %}
			'{{item.location}}' => '{{item.label}}',{% endfor %}
		)
	);
}
add_action( 'after_setup_theme', '{{globals.code_prefix}}register_custom_nav_menus' );{% endif %}

{% if globals.image_sizes %}
//-----------------------------------------------------
// Custom Image Sizes
//-----------------------------------------------------
{% for item in globals.image_sizes %}
add_image_size( '{{item.name}}', {{item.width}}, {{item.height}}, {{item.cropped}} );{% endfor %}
{% endif %}

//-----------------------------------------------------
// Enqueue scripts and styles
//-----------------------------------------------------

function {{globals.code_prefix}}scripts() {
	wp_enqueue_style( '{{globals.code_textdomain}}', get_template_directory_uri() . '/theme.min.css', '', '{{globals.theme_version}}' );{% if globals.googlefonts_css_url %}
	wp_enqueue_style( '{{globals.code_textdomain}}-google-fonts', '{{globals.googlefonts_css_url}}', '', null );{% endif %}
	wp_enqueue_script( '{{globals.code_textdomain}}', get_template_directory_uri() . '/assets/js/scripts.min.js', array( 'jquery' ), '{{globals.theme_version}}', false );{% if globals.fontawesome_kit_url %}
	wp_enqueue_script( '{{globals.code_textdomain}}-fontawesome', '{{globals.fontawesome_kit_url}}', false, null, false );{% endif %}
{% if globals.jquery_version %}
	if ( ! is_admin() ) {
		wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/{{globals.jquery_version}}/jquery.min.js', false, '{{globals.jquery_version}}' );
		wp_enqueue_script( 'jquery' );
	}{% endif %}

}

add_action( 'wp_enqueue_scripts', '{{globals.code_prefix}}scripts' );


//-----------------------------------------------------
// Set option key for Method_Utility class
//-----------------------------------------------------

function {{globals.code_prefix}}method_utility_option_key_callback( $string ) {
    // (maybe) modify $string.
    return '{{globals.code_prefix}}options';
}
add_filter( 'method_utility_option_key', '{{globals.code_prefix}}method_utility_option_key_callback', 10, 1 );


//-----------------------------------------------------
// Configure required plugins
//-----------------------------------------------------

require_once get_template_directory() . '/inc/tgm-plugin-activation/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', '{{globals.code_prefix}}register_required_plugins' );

function {{globals.code_prefix}}register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(
{% if globals.require_cmb2 %}
		array(
			'name'      => 'CMB2',
			'slug'      => 'cmb2',
			'required'  => true,
		),{% endif %}{% if globals.require_classic_editor %}
		array(
			'name'      => 'Classic Editor',
			'slug'      => 'classic-editor',
			'required'  => true,
		),{% endif %}{% if globals.require_github_updater %}
		array(
			'name'      => 'GitHub Updater',
			'slug'      => 'github-updater',
			'source'    => 'https://github.com/afragen/github-updater/archive/master.zip',
			'required'  => true,
		),{% endif %}{% if globals.require_cmb2_roadway_segments %}
		array(
			'name'      => 'CMB2 Roadway Segments',
			'slug'      => 'cmb2-roadway-segments',
			'source'    => 'https://github.com/pixelwatt/cmb2-roadway-segments/archive/master.zip',
			'required'  => true,
		),{% endif %}{% if globals.require_cmb2_mapbox %}
		array(
			'name'      => 'CMB2 Mapbox',
			'slug'      => 'cmb2-mapbox',
			'source'    => 'https://github.com/pixelwatt/cmb2-mapbox/archive/master.zip',
			'required'  => true,
		),{% endif %}{% if globals.require_method_alerts %}
		array(
			'name'      => 'Method Alerts',
			'slug'      => 'method-alerts',
			'source'    => 'https://github.com/pixelwatt/method-alerts/archive/main.zip',
			'required'  => true,
		),{% endif %}{% if globals.require_method_gallery %}
		array(
			'name'      => 'Method Gallery',
			'slug'      => 'method-gallery',
			'source'    => 'https://github.com/pixelwatt/method-gallery/archive/main.zip',
			'required'  => true,
		),{% endif %}{% if globals.require_method_podcast %}
		array(
			'name'      => 'Method Podcast',
			'slug'      => 'method-podcast',
			'source'    => 'https://github.com/pixelwatt/method-podcast/archive/main.zip',
			'required'  => true,
		),{% endif %}{% if globals.require_elliston %}
		array(
			'name'      => 'Elliston',
			'slug'      => 'elliston',
			'source'    => 'https://github.com/theboldagency/elliston/archive/master.zip',
			'required'  => true,
		),{% endif %}

	);

	$config = array(
		'id'           => '{{globals.code_textdomain}}',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => 'themes.php',            // Parent menu slug.
		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => true,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	);

	tgmpa( $plugins, $config );
}
{% endblock %}