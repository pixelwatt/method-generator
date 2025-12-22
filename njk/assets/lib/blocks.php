{% import '_globals.html' as globals %}{% extends "_barebones.html" %}{% block content %}<?php

//======================================================================
// THEME BLOCK FUNCTIONS
//======================================================================

//-----------------------------------------------------
// Register global stylesheet
//-----------------------------------------------------

function {{globals.code_prefix}}block_assets() {
    wp_enqueue_style( '{{globals.code_textdomain}}-global', get_stylesheet_directory_uri() . '/assets/css/global.css', ( ! is_admin() ? array('wp-block-library', 'wp-block-library-theme', 'global-styles') : '' ), THEME_VERSION );
}

add_action( 'enqueue_block_assets', '{{globals.code_prefix}}block_assets' );{% endblock %}