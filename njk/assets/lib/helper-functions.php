{% import '_globals.html' as globals %}{% extends "_barebones.html" %}{% block content %}<?php

//======================================================================
// HELPER FUNCTIONS
//======================================================================


//-----------------------------------------------------
// Get common CSS classes
//-----------------------------------------------------

function {{globals.code_prefix}}get_class( $class ) {
	$output = '';

	if ( ! empty( $class ) ) {
		switch ( $class ) {
			{% for item in globals.css_classes %}case '{{item.id}}':
				$output = '{{item.class}}';
				break;
			{% endfor %}default:
				break;
		}
	}

	return $output;
}


//-----------------------------------------------------
// Run a string through Wordpress' content filter
//-----------------------------------------------------

function {{globals.code_prefix}}filter_content( $content ) {
	if ( ! empty( $content ) ) {
		$content = apply_filters( 'the_content', $content );
	}
	return $content;
}


//-----------------------------------------------------
// Check an array key to see if it exists
//-----------------------------------------------------

function {{globals.code_prefix}}check_key( $key ) {
	$output = false;
	if ( isset( $key ) ) {
		if ( ! empty( $key ) ) {
			$output = true;
		}
	}
	return $output;
}


//-----------------------------------------------------
// Add the array_key_first() function for older PHP
//-----------------------------------------------------

if ( ! function_exists( 'array_key_first' ) ) {
	function array_key_first( array $arr ) {
		foreach ( $arr as $key => $unused ) {
			return $key;
		}
		return null;
	}
}


//-----------------------------------------------------
// Get an array of post IDs and titles
//-----------------------------------------------------

function {{globals.code_prefix}}get_post_array( $type, $none = '' ) {
	//lets create an array of boroughs to loop through
	if ( ! empty( $none ) ) {
		$output[0] = $none;
	} else {
		$output = array();
	}

	//The Query
	$items = get_posts( 'post_type=' . $type . '&post_status=publish&posts_per_page=-1' );

	if ( $items ) {
		foreach ( $items as $post ) :
			setup_postdata( $post );
			$output[ "{$post->ID}" ] = get_the_title( $post->ID );
		endforeach;
		wp_reset_postdata();
	}

	return $output;
}


//-----------------------------------------------------
// Get an array of term ids and names
//-----------------------------------------------------

function {{globals.code_prefix}}get_term_array( $tax, $none = '' ) {
	//lets create an array of boroughs to loop through
	if ( ! empty( $none ) ) {
		$output[0] = $none;
	} else {
		$output = array();
	}

	//The Query
	$items = get_terms( $tax );

	if ( $items ) {
		foreach ( $items as $term ) :
			$output[ "{$term->term_id}" ] = $term->name;
		endforeach;
	}

	return $output;
}


//-----------------------------------------------------
// Get an array of nav menus created in the menu editor
//-----------------------------------------------------

function {{globals.code_prefix}}get_menus_array() {
	$menus  = get_terms( 'nav_menu', array( 'hide_empty' => true ) );
	$output = array();

	if ( ! empty( $menus ) ) {
		foreach ( $menus as $menu ) {
			$output[ $menu->term_id ] = $menu->name;
		}
	}

	return $output;
}


//-----------------------------------------------------
// Additional utility functions
//-----------------------------------------------------

function {{globals.code_prefix}}str_replace_assoc( array $replace, $subject ) {
	return str_replace( array_keys( $replace ), array_values( $replace ), $subject );
}


function {{globals.code_prefix}}get_tags_badge() {
	return '<span class="{{globals.code_textdomain}}-tags-opener">Tags Supported</span> ';
}
{% endblock %}