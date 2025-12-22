{% import '_globals.html' as globals %}{% extends "_barebones.html" %}{% block content %}<?php

//-----------------------------------------------------
// Enqueue scripts and styles
//-----------------------------------------------------

function {{globals.code_prefix}}scripts() {
	// Uncomment below if using front.css
    // wp_enqueue_style( '{{globals.code_textdomain}}-front', get_stylesheet_directory_uri() . '/assets/css/front.min.css', '', THEME_VERSION );
}

add_action( 'wp_enqueue_scripts', '{{globals.code_prefix}}scripts' );{% endblock %}