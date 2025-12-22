{% import '_globals.html' as globals %}{% extends "_barebones.html" %}{% block content %}<?php

//======================================================================
// THEME OPTIONS
//======================================================================

add_action( 'cmb2_admin_init', '{{globals.code_prefix}}register_theme_options_metabox' );

function {{globals.code_prefix}}register_theme_options_metabox() {

	/**
	 * Registers options page menu item and form.
	 */
	$cmb_options = new_cmb2_box(
		array(
			'id'           => '{{globals.code_prefix}}theme_options_metabox',
			'title'        => __( '<span class="method-logo-wrap">&nbsp;</span><span class="visually-hidden">Method </span>Child Theme Settings | v' . THEME_VERSION, '{{globals.code_textdomain}}' ),
			'object_types' => array( 'options-page' ),

			'option_key'      => '{{globals.code_prefix}}options',
			'icon_url'        => 'data:image/svg+xml;base64,' . base64_encode('<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 153 153" fill="none"><path d="M122.09,40.67v79.72h-7.19v-63.54l-11.72,10.73-26.1,23.88-26.1-23.87-18.75-17.19v-9.64l9.29,8.6,30.83,28.2,4.72,4.32,4.72-4.32,30.83-28.21,9.46-8.68M32.22,96.02l7.02,6.43v17.95h-7.02v-24.38M129.09,24.75l-21.2,19.44-30.83,28.2-30.83-28.2-21.02-19.44v28.73l21.02,19.27,30.83,28.2,30.83-28.2v54.65h21.2V24.75h0ZM25.22,80.1v47.29h21.02v-28.03l-21.02-19.27h0Z" fill="currentColor"/></svg>'),
			'menu_title'      => esc_html__( 'Theme Settings', '{{globals.code_textdomain}}' ),
			'position'        => 3,
			'save_button'     => esc_html__( 'Update Settings', '{{globals.code_textdomain}}' ),
			'classes' => 'method-options-panel',
		)
	);

	/*
	$cmb_options->add_field(
		array(
			'name'     => __( '<span style="font-size: 1.25rem; font-weight: 800; line-height: 1; text-transform: none;">Some Section</span>', '{{globals.code_textdomain}}' ),
			'id'       => 'misc_info',
			'type'     => 'title',
		)
	);
	*/

}{% endblock %}