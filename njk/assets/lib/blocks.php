{% import '_globals.html' as globals %}{% extends "_barebones.html" %}{% block content %}<?php

//======================================================================
// THEME BLOCK FUNCTIONS
//======================================================================

//-----------------------------------------------------
// Optionally, register a custom block pattern category
// (or categories) if you intend to programmatically
// add patterns to the patterns directory of this theme
//-----------------------------------------------------
/*
function {{globals.code_prefix}}register_pattern_categories() {
    register_block_pattern_category(
        '{{globals.code_textdomain}}-page-components',
        array( 'label' => __( 'Page Components', '{{globals.code_textdomain}}' ) )
    );
}

add_action( 'init', '{{globals.code_prefix}}register_pattern_categories' );
*/

//-----------------------------------------------------
// Optionally, register custom block categories if you
// intend to build custom blocks for this theme.
//-----------------------------------------------------
/*
add_filter( 'block_categories_all' , function( $categories ) {

    $new_category = array(
        'slug'  => '{{globals.code_textdomain}}-blocks',
        'title' => '{{globals.theme_name}} Blocks'
    );

    // Prepend the new category to the beginning of the array.
    array_unshift( $categories, $new_category );

    return $categories;

}, 25 );
*/

//-----------------------------------------------------
// Register global stylesheet
//-----------------------------------------------------

function {{globals.code_prefix}}block_assets() {
    if ( ! is_admin() ) {
        wp_enqueue_style( '{{globals.code_textdomain}}-global', get_stylesheet_directory_uri() . '/assets/css/global.css', array('wp-block-library', 'wp-block-library-theme', 'global-styles'), THEME_VERSION );
    }
}

add_action( 'enqueue_block_assets', '{{globals.code_prefix}}block_assets' );


//-----------------------------------------------------
// For the block editor, use add_editor_style() to
// limit scope to the content iframe
//-----------------------------------------------------

add_action('after_setup_theme', function() {
    add_theme_support('editor-styles');
    add_editor_style('assets/css/global.css');
});


//-----------------------------------------------------
// Remove core block patterns from the block editor.
// Comment out the following line to include core
// block patterns.
//-----------------------------------------------------

remove_theme_support( 'core-block-patterns' );


//-----------------------------------------------------
// Optionally, register custom styles for various types
// of heading blocks
//-----------------------------------------------------
/*
$heading_styles = array(
    array('name' => 'as-h1', 'label' => 'H1 Styles'),
    array('name' => 'as-h2', 'label' => 'H2 Styles'),
    array('name' => 'as-h3', 'label' => 'H3 Styles'),
);

foreach ($heading_styles as $style) {
    register_block_style('core/heading', $style);
    register_block_style('core/post-title', $style);
    register_block_style('core/query-title', $style);
}
*/


//-----------------------------------------------------
// Optionally, register theme button styles
//-----------------------------------------------------
/*
$btn_styles = array(
    array('name' => 'enclosed', 'label' => 'Enclosed'),
    array('name' => 'icon-only', 'label' => 'Icon Only'),
);

foreach ($btn_styles as $style) {
    register_block_style('method/theme-button', $style);
}
*/


//-----------------------------------------------------
// Optionally, register secondary button styles
//-----------------------------------------------------
/*
function {{globals.code_prefix}}theme_button_styles( $styles ) {
    $theme_styles = array(
        '' => 'Default',
        'small' => 'Small',
        'large' => 'Large',
    );
    return $theme_styles;
}
add_filter( 'method_block_theme_button_styles', '{{globals.code_prefix}}theme_button_styles', 10, 1 );
*/


//-----------------------------------------------------
// Optionally, register a label for secondary theme 
// button styles
//-----------------------------------------------------
/*
function {{globals.code_prefix}}theme_button_styles_label( $styles ) {
    return 'Button Size';
}
add_filter( 'method_block_theme_button_styles_label', '{{globals.code_prefix}}theme_button_styles_label', 10, 1 );
*/


//-----------------------------------------------------
// Optionally, register theme button label styles
//-----------------------------------------------------
/*
function {{globals.code_prefix}}theme_button_label_styles( $styles ) {
    $label_styles = array(
        '' => 'Default',
        'is-style-as-h1' => 'As H1',
        'is-style-as-h2' => 'As H2',
        'is-style-as-h3' => 'As H3',
    );
    return $label_styles;
}
add_filter( 'method_block_theme_label_styles', '{{globals.code_prefix}}theme_button_label_styles', 10, 1 );
*/


//-----------------------------------------------------
// Optionally, register svg icons for use in the theme
// button block (otherwise, options hidden in editor)
//-----------------------------------------------------
/*
function {{globals.code_prefix}}theme_button_icons( $styles ) {
    $theme_icons = array(
        '' => array(
            'svg' => '',
            'label' => 'None',
        ),
        'chevron-left' => array(
            'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-left" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0"/></svg>',
            'label' => 'Chevron (Left)',
        ),
        'chevron-right' => array(
            'svg' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708"/></svg>',
            'label' => 'Chevron (Right)',
        ),
    );
    return $theme_icons;
}
add_filter( 'method_block_theme_button_icons', '{{globals.code_prefix}}theme_button_icons', 10, 1 );
*/{% endblock %}