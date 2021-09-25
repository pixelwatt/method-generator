{% import '_globals.html' as globals %}{% extends "_barebones.html" %}{% block content %}<?php

function {{globals.code_prefix}}admin_scripts() {
	$wp_scripts = wp_scripts();
	wp_enqueue_script( 'jquery-ui-dialog' );
    wp_enqueue_style( 'jquery-ui', 'https://ajax.googleapis.com/ajax/libs/jqueryui/' . $wp_scripts->registered['jquery-ui-core']->ver . '/themes/smoothness/jquery-ui.css', '', '', false );
    wp_enqueue_style( '{{globals.code_textdomain}}', get_template_directory_uri() . '/assets/css/admin-styles.css', '', '{{globals.theme_version}}' );
}

add_action( 'admin_enqueue_scripts', '{{globals.code_prefix}}admin_scripts' );


function {{globals.code_prefix}}admin_footer_function() {
	echo '
		<script>
		  jQuery( function() {
		    jQuery( "#{{globals.code_textdomain}}-tags-dialog" ).dialog({
		      autoOpen: false,
		      width: 600,
		    });
		 
		    jQuery( ".{{globals.code_textdomain}}-tags-opener" ).on( "click", function() {
		      jQuery( "#{{globals.code_textdomain}}-tags-dialog" ).dialog( "open" );
		    });
		  });
		</script>

		<div id="{{globals.code_textdomain}}-tags-dialog" title="About Tags">
		  <p>Format tags allow you to safely format text for certain options that don\'t support HTML formatting, such as headlines. Below is a listing of currently-available tags:</p>
		  <hr>
		  <h5>[strong]...[/strong]</h5>
		  <p>This tag allows you to bold portions of text by wrapping the desired text in <code>[strong]...[/strong]</code>.<br><em>(Ex: "I want [strong]this[/strong] to be bold.")</em></p>
		  <hr>
		  <h5>[em]...[/em]</h5>
		  <p>Similiar to the [strong] tag, this tag allows you to italicize portions of text by wrapping the desired text in <code>[em]...[/em]</code>.<br><em>(Ex: "I want [em]this[/em] to be italic.")</em></p>
		  <hr>
		  <h5>[br]</h5>
		  <p>This tags allows you to insert a line break. Use <code>[br]</code> for the line break to appear on all devices, <code>[mbr]</code> for the line break to only appear on mobile, and <code>[dbr]</code> for the break to only appear on desktop.<br><em>(Ex: "I want this text on line 1,[br]and this text on line 2.")</em></p>
	';
	do_action( 'method_after_tags_dialog_html' );
	echo '
		</div>
	';
}

add_action( 'admin_footer', '{{globals.code_prefix}}admin_footer_function', 100 );

//======================================================================
// 10. DASHBOARD / EDITOR OPTIMIZATIONS
//======================================================================

//-----------------------------------------------------
// Remove editor button to add Ninja Forms
//-----------------------------------------------------

add_action( 'admin_head', '{{globals.code_prefix}}remove_add_new_nf_button' );

function {{globals.code_prefix}}remove_add_new_nf_button() {
	echo '<style>
		#wp-content-media-buttons .button.nf-insert-form {display:none !important; visibility: hidden !important;}
	</style>';
}

//-----------------------------------------------------
// Remove sidebar metabox for appending a Ninja Form
//-----------------------------------------------------

add_action( 'add_meta_boxes', function() {
	remove_meta_box( 'nf_admin_metaboxes_appendaform', ['page', 'post'], 'side' );
}, 99 );


//-----------------------------------------------------
// Lower Yoast metabox priority
//-----------------------------------------------------

function {{globals.code_prefix}}lower_wpseo_priority( $html ) {
	return 'low';
}
add_filter( 'wpseo_metabox_prio', '{{globals.code_prefix}}lower_wpseo_priority' );

{% if globals.custom_login_enable %}
//======================================================================
// 11. LOGIN CUSTOMIZATION
//======================================================================

//-----------------------------------------------------
// Change the login page logo URL to link to the site.
//-----------------------------------------------------

function {{globals.code_prefix}}custom_login_url( $url ) {
	return get_site_url();
}
add_filter( 'login_headerurl', '{{globals.code_prefix}}custom_login_url' );


//-----------------------------------------------------
// Enqueue scripts and styles for login.
//-----------------------------------------------------

function {{globals.code_prefix}}login_scripts() {
	wp_enqueue_style( '{{globals.code_textdomain}}-login', get_template_directory_uri() . '/login.css' );
}

add_action( 'login_enqueue_scripts', '{{globals.code_prefix}}login_scripts' );{% endif %}

{% endblock %}