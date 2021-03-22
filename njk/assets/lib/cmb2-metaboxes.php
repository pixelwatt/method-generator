{% import '_globals.html' as globals %}{% extends "_barebones.html" %}{% block content %}<?php

//======================================================================
// CMB2 METABOXES
//======================================================================

/**
 * Front Page Metabox
 */

add_action( 'cmb2_admin_init', '{{globals.code_prefix}}register_page_front_metabox' );

function {{globals.code_prefix}}register_page_front_metabox() {
	$prefix = '_{{globals.code_prefix}}';

	$cmb_options = new_cmb2_box(
		array(
			'id'            => $prefix . 'metabox_page_front',
			'title'         => esc_html__( 'Front Page Options', 'cmb2' ),
			'object_types'  => array( 'page' ),
			'show_on' => array(
				'key' => 'front-page',
				'value' => '',
			),
		)
	);

	{{globals.code_prefix}}load_cmb2_options( $cmb_options, array( 'elements' ) );

}

/**
 * Default Page Metabox
 */

add_action( 'cmb2_admin_init', '{{globals.code_prefix}}register_page_default_metabox' );

function {{globals.code_prefix}}register_page_default_metabox() {
	$prefix = '_{{globals.code_prefix}}';

	$cmb_options = new_cmb2_box(
		array(
			'id'            => $prefix . 'metabox_page_default',
			'title'         => esc_html__( 'Additional Options', 'cmb2' ),
			'object_types'  => array( 'page' ),
			'show_on' => array(
				'key' => 'default-page-template',
				'value' => '',
			),
		)
	);

	{{globals.code_prefix}}load_cmb2_options( $cmb_options, array( 'example' ) );

}

/*
Example CMB2 registration for a custom page template:

add_action( 'cmb2_admin_init', '{{globals.code_prefix}}register_page_template_tmpname_metabox' );

function {{globals.code_prefix}}register_page_template_tmpname_metabox() {
	$prefix = '_{{globals.code_prefix}}';

	$cmb_options = new_cmb2_box(
		array(
			'id'            => $prefix . 'metabox_page_template_tmpname',
			'title'         => esc_html__( 'Template Options', 'cmb2' ),
			'object_types'  => array( 'page' ),
			'priority'     => 'high',
			'show_on'      => array(
				'key'   => 'page-template',
				'value' => 'templates/page-template-tmpname.php',
			),
		)
	);

	{{globals.code_prefix}}load_cmb2_options( $cmb_options, array( 'elements' ) );

}

*/
{% endblock %}