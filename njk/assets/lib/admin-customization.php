{% import '_globals.html' as globals %}{% extends "_barebones.html" %}{% block content %}<?php

function {{globals.code_prefix}}admin_scripts() {
    wp_enqueue_style( '{{globals.code_textdomain}}-admin', get_stylesheet_directory_uri() . '/assets/css/admin.css', '', THEME_VERSION );
}

add_action( 'admin_enqueue_scripts', '{{globals.code_prefix}}admin_scripts' );{% endblock %}