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
			'title'        => esc_html__( '{{globals.code_textdomain}} Theme Options', '{{globals.code_textdomain}}' ),
			'object_types' => array( 'options-page' ),

			/*
			 * The following parameters are specific to the options-page box
			 * Several of these parameters are passed along to add_menu_page()/add_submenu_page().
			 */

			'option_key'      => '{{globals.code_prefix}}options', // The option key and admin menu page slug.
			// 'icon_url'        => 'dashicons-palmtree', // Menu icon. Only applicable if 'parent_slug' is left empty.
			'menu_title'      => esc_html__( 'Theme Options', '{{globals.code_textdomain}}' ), // Falls back to 'title' (above).
			'parent_slug'     => 'themes.php', // Make options page a submenu item of the themes menu.
			// 'capability'      => 'manage_options', // Cap required to view options-page.
			// 'position'        => 1, // Menu position. Only applicable if 'parent_slug' is left empty.
			// 'admin_menu_hook' => 'network_admin_menu', // 'network_admin_menu' to add network-level options page.
			// 'display_cb'      => false, // Override the options-page form output (CMB2_Hookup::options_page_output()).
			// 'save_button'     => esc_html__( 'Save Theme Options', 'myprefix' ), // The text for the options-page save button. Defaults to 'Save'.
		)
	);

	$cmb_options->add_field(
		array(
			'name'     => __( '<span style="font-size: 1.25rem; font-weight: 800; line-height: 1; text-transform: none;">Social Media Accounts</span>', '{{globals.code_textdomain}}' ),
			'id'       => 'social_info',
			'type'     => 'title',
		)
	);

	$group_field_social_accounts = $cmb_options->add_field(
		array(
			'id'          => 'social_accounts',
			'type'        => 'group',
			'description' => __( 'Configure social account links below.', '{{globals.code_textdomain}}' ),
			// 'repeatable'  => false, // use false if you want non-repeatable group
			'options'     => array(
				'group_title'       => __( 'Account {% raw %}{#}{% endraw %}', '{{globals.code_textdomain}}' ), // since version 1.1.4, {% raw %}{#}{% endraw %} gets replaced by row number
				'add_button'        => __( 'Add Another Account', '{{globals.code_textdomain}}' ),
				'remove_button'     => __( 'Remove Account', '{{globals.code_textdomain}}' ),
				'sortable'          => true,
				'closed'         => true, // true to have the groups closed by default
				// 'remove_confirm' => esc_html__( 'Are you sure you want to remove?', '{{globals.code_textdomain}}' ), // Performs confirmation before removing group.
			),
		)
	);

	$cmb_options->add_group_field(
		$group_field_social_accounts,
		array(
			'name' => 'Service',
			'id'   => 'service',
			'type' => 'radio',
			'default' => 'facebook',
			'desc' => __( 'Which service are you adding a link for?', '{{globals.code_textdomain}}' ),
			'options' => array({% for item in globals.social_options %}
				'{{item.id}}' => esc_attr__( '{{item.label}}', '{{globals.code_textdomain}}' ),{% endfor %}
			),
		)
	);

	$cmb_options->add_group_field(
		$group_field_social_accounts,
		array(
			'name' => __( 'Profile URL', '{{globals.code_textdomain}}' ),
			'desc' => __( 'Enter the full URL for your profile.', '{{globals.code_textdomain}}' ),
			'id'   => 'url',
			'type' => 'text_url',
		)
	);

	$cmb_options->add_field(
		array(
			'name'     => __( '<span style="font-size: 1.25rem; font-weight: 800; line-height: 1; text-transform: none;">Footer Options</span>', '{{globals.code_textdomain}}' ),
			'id'       => 'footer_info',
			'type'     => 'title',
		)
	);

	$cmb_options->add_field(
		array(
			'name'     => __( 'Copyright', '{{globals.code_textdomain}}' ),
			'id'       => 'footer_copyright',
			'type'     => 'wysiwyg',
		)
	);

	/*
	 * Options fields ids only need
	 * to be unique within this box.
	 * Prefix is not needed.
	 */

}
{% endblock %}