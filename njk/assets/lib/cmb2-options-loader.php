{% import '_globals.html' as globals %}{% extends "_barebones.html" %}{% block content %}<?php

//======================================================================
// CMB2 OPTIONS LOADER
//======================================================================

function {{globals.code_prefix}}load_cmb2_options( &$obj, $temps ) {
	foreach ( $temps as $temp ) {
		$prefix = str_replace( '-', '_', $temp );
		switch ( $temp ) {
			case 'example':
				$obj->add_field(
					array(
						'name'     => __( '<span style="font-size: 1.5rem; font-weight: 900;">Example Section</span>', '{{globals.code_textdomain}}' ),
						'id'   => '_{{globals.code_prefix}}example_info',
						'type'     => 'title',
					)
				);
				$obj->add_field(
					array(
						'name'     => __( 'Headline', '{{globals.code_textdomain}}' ),
						'desc'     => __( {{globals.code_prefix}}get_tags_badge() . 'Provide a headline for this item.', '{{globals.code_textdomain}}' ),
						'id'   => '_{{globals.code_prefix}}example_headline',
						'type'     => 'text',
					)
				);
				break;
			default:
				break;
		}
	}
	return;
}
{% endblock %}