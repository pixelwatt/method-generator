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
// Get content by ID
//-----------------------------------------------------


function {{globals.code_prefix}}get_content( $id ) {
	$content_post = get_post( $id );
	$content = $content_post->post_content;
	$content = apply_filters( 'the_content', $content );
	$content = str_replace( ']]>', ']]&gt;', $content );
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

function {{globals.code_prefix}}get_post_array( $type, $none = false ) {
	//lets create an array of boroughs to loop through
	if ( true == $none ) {
		$output[0] = 'None';
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

function {{globals.code_prefix}}get_term_array( $tax, $none = false ) {
	//lets create an array of boroughs to loop through
	if ( true == $none ) {
		$output[0] = 'None';
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


function {{globals.code_prefix}}str_replace_assoc( array $replace, $subject ) {
	return str_replace( array_keys( $replace ), array_values( $replace ), $subject );
}


function {{globals.code_prefix}}get_tags_badge() {
	return '<span class="{{globals.code_textdomain}}-tags-opener">Tags Supported</span> ';
}
{% endblock %}