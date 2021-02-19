{% import '_globals.html' as globals %}{% extends "_barebones.html" %}{% block content %}<?php

//======================================================================
//
// FUNCTIONS.PHP
//
// Table of Contents:
// 1. Initial Setup
// 2. Kirki Setup
// 3. Custom Post Types
// 4. Custom Taxonomies
// 5. Helper Functions
// 6. Content Generation Functions
// 7. CMB2 Helper Functions
// 8. Meta Boxes
//
//======================================================================


//======================================================================
// 1. INITIAL SETUP
//======================================================================


//-----------------------------------------------------
// Import a custom navwalker for Bootstrap 4
//-----------------------------------------------------

require_once get_template_directory() . '/inc/class-wp-bootstrap-navwalker.php';


//-----------------------------------------------------
// Theme and Post Support
//-----------------------------------------------------

function {{globals.code_prefix}}enable_theme_support() {
{% if globals.theme_support_html5 %}
	// Add theme support for html5 markup
	$args = array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'script',
		'style',
	);
	add_theme_support( 'html5', $args );{% endif %}
{% if globals.theme_support_titletag %}
	// Add theme support for the title tag
	add_theme_support( 'title-tag' );{% endif %}
{% if globals.theme_support_thumbnails %}
	// Add theme support for post thumbnails
	add_theme_support( 'post-thumbnails' );{% endif %}
}
add_action( 'after_setup_theme', '{{globals.code_prefix}}enable_theme_support' );

{% if globals.nav_menus %}
function {{globals.code_prefix}}register_custom_nav_menus() {
	register_nav_menus(
		array({% for item in globals.nav_menus %}
			'{{item.location}}' => '{{item.label}}',{% endfor %}
		)
	);
}
add_action( 'after_setup_theme', '{{globals.code_prefix}}register_custom_nav_menus' );{% endif %}

{% if globals.image_sizes %}
//-----------------------------------------------------
// Custom Image Sizes
//-----------------------------------------------------
{% for item in globals.image_sizes %}
add_image_size( '{{item.name}}', {{item.width}}, {{item.height}}, {{item.cropped}} );{% endfor %}
{% endif %}

//-----------------------------------------------------
// Configure required plugins
//-----------------------------------------------------

require_once get_template_directory() . '/inc/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', '{{globals.code_prefix}}register_required_plugins' );

function {{globals.code_prefix}}register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(
{% if globals.require_cmb2 %}
		array(
			'name'      => 'CMB2',
			'slug'      => 'cmb2',
			'required'  => true,
		),{% endif %}{% if globals.require_classic_editor %}
		array(
			'name'      => 'Classic Editor',
			'slug'      => 'classic-editor',
			'required'  => true,
		),{% endif %}{% if globals.require_github_updater %}
		array(
			'name'      => 'GitHub Updater',
			'slug'      => 'github-updater',
			'source'    => 'https://github.com/afragen/github-updater/archive/master.zip',
			'required'  => true,
		),{% endif %}{% if globals.require_cmb2_roadway_segments %}
		array(
			'name'      => 'CMB2 Roadway Segments',
			'slug'      => 'cmb2-roadway-segments',
			'source'    => 'https://github.com/pixelwatt/cmb2-roadway-segments/archive/master.zip',
			'required'  => true,
		),{% endif %}

	);

	$config = array(
		'id'           => '{{globals.code_textdomain}}',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => 'themes.php',            // Parent menu slug.
		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => true,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	);

	tgmpa( $plugins, $config );
}


//-----------------------------------------------------
// Enqueue scripts and styles
//-----------------------------------------------------

function {{globals.code_prefix}}scripts() {
	wp_enqueue_style( '{{globals.code_textdomain}}', get_template_directory_uri() . '/theme.min.css', '', '{{globals.theme_version}}' );{% if globals.googlefonts_css_url %}
	wp_enqueue_style( '{{globals.code_textdomain}}-google-fonts', '{{globals.googlefonts_css_url}}', '', null );{% endif %}
	wp_enqueue_script( '{{globals.code_textdomain}}', get_template_directory_uri() . '/assets/js/scripts.min.js', array( 'jquery' ), '{{globals.theme_version}}', false );{% if globals.fontawesome_kit_url %}
	wp_enqueue_script( '{{globals.code_textdomain}}-fontawesome', '{{globals.fontawesome_kit_url}}', false, null, false );{% endif %}
{% if globals.jquery_version %}
	if ( ! is_admin() ) {
		wp_deregister_script( 'jquery' );
		wp_register_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/{{globals.jquery_version}}/jquery.min.js', false, '{{globals.jquery_version}}' );
		wp_enqueue_script( 'jquery' );
	}{% endif %}

}

add_action( 'wp_enqueue_scripts', '{{globals.code_prefix}}scripts' );


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
		</div>
	';
}

add_action( 'admin_footer', '{{globals.code_prefix}}admin_footer_function', 100 );


//======================================================================
// 2. THEME OPTIONS
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



//======================================================================
// 3. CUSTOM POST TYPES
//======================================================================


/*

add_action( 'init', '{{globals.code_prefix}}news_init' );

function {{globals.code_prefix}}news_init() {
	$labels = array(
		'name'               => _x( 'News', 'post type general name', '{{globals.code_textdomain}}' ),
		'singular_name'      => _x( 'News Item', 'post type singular name', '{{globals.code_textdomain}}' ),
		'menu_name'          => _x( 'News', 'admin menu', '{{globals.code_textdomain}}' ),
		'name_admin_bar'     => _x( 'News Item', 'add new on admin bar', '{{globals.code_textdomain}}' ),
		'add_new'            => _x( 'Add News Item', 'job', '{{globals.code_textdomain}}' ),
		'add_new_item'       => __( 'Add New News Item', '{{globals.code_textdomain}}' ),
		'new_item'           => __( 'New News Item', '{{globals.code_textdomain}}' ),
		'edit_item'          => __( 'Edit News Item', '{{globals.code_textdomain}}' ),
		'view_item'          => __( 'View News Item', '{{globals.code_textdomain}}' ),
		'all_items'          => __( 'News', '{{globals.code_textdomain}}' ),
		'search_items'       => __( 'Search News', '{{globals.code_textdomain}}' ),
		'parent_item_colon'  => __( 'Parent News:', '{{globals.code_textdomain}}' ),
		'not_found'          => __( 'No news found.', '{{globals.code_textdomain}}' ),
		'not_found_in_trash' => __( 'No news found in Trash.', '{{globals.code_textdomain}}' )
	);

	$args = array(
		'labels'             => $labels,
		'description'        => __( 'A description for the post type.', '{{globals.code_textdomain}}' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'query_var'          => true,
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position' 	 => 5,
		'menu_icon'			 => 'dashicons-megaphone',
		'supports'           => array( 'title' , 'editor' )
	);

	register_post_type( 'news', $args );
}

*/


//======================================================================
// 4. CUSTOM TAXONOMIES
//======================================================================


// Declare custom taxonomies here.

/*
add_action( 'init', '{{globals.code_prefix}}register_mytax', 0 );

function {{globals.code_prefix}}register_mytax() {
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name' => _x( 'My Tax Terms', 'taxonomy general name' ),
		'singular_name' => _x( 'My Tax Term', 'taxonomy singular name' ),
		'search_items' =>  __( 'Search My Tax Terms' ),
		'all_items' => __( 'All My Tax Terms' ),
		'parent_item' => __( 'Parent My Tax Term' ),
		'parent_item_colon' => __( 'Parent My Tax Term:' ),
		'edit_item' => __( 'Edit My Tax Term' ),
		'update_item' => __( 'Update My Tax Term' ),
		'add_new_item' => __( 'Add New My Tax Term' ),
		'new_item_name' => __( 'New My Tax Term Name' ),
		'menu_name' => __( 'My Tax Term' ),
	);

	register_taxonomy('mytax',array('myposttype'), array(
		'hierarchical' => true,
		'labels' => $labels,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => array( 'slug' => 'mytax' ),
		'show_admin_column' => true
	));
}
*/


//======================================================================
// 5. HELPER FUNCTIONS
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
	$output = $fb;
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


//-----------------------------------------------------
// Function to replace strings found in an array
// src: https://www.php.net/manual/en/function.str-replace.php#95198
//-----------------------------------------------------

function {{globals.code_prefix}}str_replace_assoc( array $replace, $subject ) {
	return str_replace( array_keys( $replace ), array_values( $replace ), $subject );   
}


//======================================================================
// 6. CONTENT GENERATION FUNCTIONS
//======================================================================


class {{globals.code_layoutclass}} {
	private $elements = array();
	private $meta = array();
	private $loaded_meta = array();
	private $opts = array();
	private $id;
	private $html;
	private $modals;
	private $scripts;
	private $attr = array();

	public function build_page( $pid = '', $archive = false ) {
		$this->opts = get_option( '{{globals.code_prefix}}options' );
		if ( true == $archive ) {
			global $wp_query;
			$this->attr['is_archive'] = true;
			$this->attr['post_type'] = ( {{globals.code_prefix}}check_key( $wp_query->query_vars['post_type'] ) ? $wp_query->query_vars['post_type'] : 'post' );
			if ( 'post' == $this->attr['post_type'] ) {
				$this->attr['category'] = ( {{globals.code_prefix}}check_key( $wp_query->queried_object->name ) ? $wp_query->queried_object->name : '' );
			}
			$this->attr['taxonomy'] = ( {{globals.code_prefix}}check_key( $wp_query->query_vars['taxonomy'] ) ? $wp_query->query_vars['taxonomy'] : '' );
			$this->determine_attributes();
			$this->build_layout();
			return $this->html . $this->modals . $this->scripts;
		} elseif ( ( ! empty( $pid ) ) && ( false == $archive ) ) {
			$this->attr['is_archive'] = false;
			$this->attr['post_type'] = get_post_type( $this->id );
			$this->id = $pid;
			$this->meta = get_post_meta( $this->id );
			if ( 'page' == $this->attr['post_type'] ) {
				$fp = get_option( 'page_on_front' );
				if ( $fp == $this->id ) {
					$this->attr['is_front'] = true;
				}
			}
			$this->determine_attributes();
			$this->build_layout();
			return $this->html . $this->modals . $this->scripts;
		} else {
			return false;
		}
	}


	private function determine_attributes() {
		global $wp_query;
		if ( true == $this->attr['is_archive'] ) {
			switch ( $this->attr['post_type'] ) {
				case 'post':
					$this->attr['components'] = array( 'activated' );
					break;
			}
		} else {
			switch ( $this->attr['post_type'] ) {
				case 'page':
					if ( $this->attr['is_front'] ) {
						$this->attr['components'] = array( 'activated' );
					} else {
						$template = get_page_template_slug( $this->id );
						switch ( $template ) {
							case 'templates/page-template-custom.php':
								$this->attr['components'] = array( 'activated' );
								break;
							default:
								$this->attr['components'] = array( 'activated' );
								break;
						}
					}
					break;
				case 'post':
					$this->attr['components'] = array( 'activated' );
					break;
				default:
					break;
			}
		}
		return;
	}


	private function build_layout() {
		$this->build_header();
		$this->build_components();
		$this->build_footer();
		return;
	}


	private function build_header() {
		$this->scripts .= '

		';
		$this->html .= '
		
		';
		return;
	}


	private function build_footer() {
		$this->html .= '
		
		';
		return;
	}


	private function inject_modal( $mid, $mclass = '', $title, $content, $prefiltered = false, $lg = false, $scrollable = false ) {
		$this->modals .= '
			<div class="modal fade" id="' . $mid . '" tabindex="-1" role="dialog" aria-labelledby="' . $mid . 'Label" aria-hidden="true">
				<div class="modal-dialog' . ( $scrollable ? ' modal-dialog-scrollable' : '' ) . ( $lg ? ' modal-lg' : '' ) . '" role="document">
					<div class="modal-content">
      					<div class="modal-header">
        					<h5 class="modal-title" id="exampleModalLabel">' . $title . '</h5>
        					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          						<span aria-hidden="true">&times;</span>
        					</button>
      					</div>
      					<div class="modal-body">
      						' . ( $prefiltered ? $content : {{globals.code_prefix}}filter_content( $content ) ) . '
      					</div>  
    				</div>
  				</div>
			</div>

		';
	}


	private function build_components() {
		if ( true == $this->attr['is_archive'] ) {
			global $wp_query;
		}
		foreach ( $this->attr['components'] as $component ) {
			switch ( $component ) {
				case 'activated':
					// Placeholder element. Should be removed from production theme.
					$this->html .= '
						<div class="error404">
							<div class="container-fluid">
								<div class="row justify-content-center align-items-center">
									<div class="col-12 col-sm-8 col-md-5 col-lg-4">
										<div class="error404-content text-center">
											<h1>Epic!</h1>
											<br>
											<h2>You\'re Up &amp Running.</h2>
											<p>This site is now running a build of Method.</p>
											<a href="https://github.com/pixelwatt/method" target="_blank" class="btn btn-lg btn-primary m-auto">Method on GitHub</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					';
					break;
				default:
					break;
			}
		}
		return;
	}


	private function array_to_ul( $array ) {
		$array = maybe_unserialize( $array );
		$output = '';

		if ( ! empty( $array ) ) {
			if ( is_array( $array ) ) {
				$output .= '<ul>';
				foreach ( $array as $item ) {
					$output .= '<li>' . esc_html( $item ) . '</li>';
				}
				$output .= '</ul>';
			}
		}
		return $output;
	}

	private function array_to_p( $array, $class = '' ) {
		$array = maybe_unserialize( $array );
		$output = '';

		if ( ! empty( $array ) ) {
			if ( is_array( $array ) ) {
				$output .= '<p' . ( ! empty( $class ) ? ' class="' . $class . '"' : '' ) . '>';
				$ac = count( $array );
				$i = 1;
				foreach ( $array as $item ) {
					$output .= esc_html( $item ) . ( $i != $ac ? '<br>' : '' );
					$i++;
				}
				$output .= '</p>';
			}
		}
		return $output;
	}

	private function format_tags( $text ) {
		$tags = array(
			'[br]' => '<br>',
			'[mbr]' => '<br class="d-inline d-md-none">',
			'[dbr]' => '<br class="d-xs-none d-sm-none d-md-inline">',
			'[strong]' => '<strong>',
			'[/strong]' => '</strong>',
			'[em]' => '<em>',
			'[/em]' => '</em>',
		);
		return {{globals.code_prefix}}str_replace_assoc( $tags, $text );
	}

	private function get_headline( $key, $before, $after, $fallback = '' ) {
		$output = '';
		if ( ( $this->get_meta( $key ) ) || ( ! empty( $fallback ) ) ) {
			$output = $before . ( $this->get_meta( $key ) ? $this->format_tags( esc_html( $this->get_meta( $key ) ) ) : $fallback ) . $after;
		}
		return $output;
	}

	private function get_loaded_headline( $key, $before, $after, $fallback = '' ) {
		$output = '';
		if ( ( $this->get_loaded_meta( $key ) ) || ( ! empty( $fallback ) ) ) {
			$output = $before . ( $this->get_loaded_meta( $key ) ? $this->format_tags( esc_html( $this->get_loaded_meta( $key ) ) ) : $fallback ) . $after;
		}
		return $output;
	}

	private function load_meta( $id ) {
		$this->loaded_meta = get_post_meta( $id );
		return;
	}

	private function unload_meta() {
		$this->loaded_meta = array();
		return;
	}

	private function get_loaded_meta( $key ) {
		$output = false;
		if ( isset( $this->loaded_meta[ "{$key}" ][0] ) ) {
			if ( ! empty( $this->loaded_meta[ "{$key}" ][0] ) ) {
				$output = $this->loaded_meta[ "{$key}" ][0];
			}
		}
		return $output;
	}

	private function get_serialized_loaded_meta( $key ) {
		$output = false;
		if ( isset( $this->loaded_meta[ "{$key}" ][0] ) ) {
			if ( ! empty( $this->loaded_meta[ "{$key}" ][0] ) ) {
				$output = maybe_unserialize( $this->loaded_meta[ "{$key}" ][0] );
			}
		}
		return $output;
	}

	private function get_meta( $key ) {
		$output = false;
		if ( isset( $this->meta[ "{$key}" ][0] ) ) {
			if ( ! empty( $this->meta[ "{$key}" ][0] ) ) {
				$output = $this->meta[ "{$key}" ][0];
			}
		}
		return $output;
	}

	private function get_serialized_meta( $key ) {
		$output = false;
		if ( isset( $this->meta[ "{$key}" ][0] ) ) {
			if ( ! empty( $this->meta[ "{$key}" ][0] ) ) {
				$output = maybe_unserialize( $this->meta[ "{$key}" ][0] );
			}
		}
		return $output;
	}

	private function get_option( $key ) {
		$output = false;
		if ( isset( $this->opts[ "{$key}" ] ) ) {
			if ( ! empty( $this->opts[ "{$key}" ] ) ) {
				$output = $this->opts[ "{$key}" ];
			}
		}
		return $output;
	}

	private function build_social_icons() {
		$output = '';

		$social_links = $this->get_option( 'social_accounts' );
		if ( ! empty( $social_links ) ) {
			if ( is_array( $social_links ) ) {
				$output .= '<ul class="s-ics">';

				foreach ( $social_links as $link ) {
					$service = ( isset( $link['service'] ) ? ( ! empty( $link['service'] ) ? $link['service'] : 'facebook' ) : 'facebook' );

					switch ( $service ) {
						{% for item in globals.social_options %}case '{{item.id}}':
							$fa = '{{item.fa}}';
							break;
						{% endfor %}default:
							$fa = 'fab fa-facebook-f';
							break;
					}

					$output .= ' <li>' . ( isset( $link['url'] ) ? ( ! empty( $link['url'] ) ? '<a href="' . $link['url'] . '">' : '' ) : '' ) . '<i class="' . $fa . '"></i><span class="sr-only sr-only-focusable"> ' . ucwords( $service ) . '</span>' . ( isset( $link['url'] ) ? ( ! empty( $link['url'] ) ? '</a>' : '' ) : '' ) . '</li>';
				}

				$output .= '</ul>';
			}
		}

		return $output;
	}

	/*
	Usage for archive pages:
	get_header();
	$layout = new {{globals.code_layoutclass}};
	echo $layout->build_page( '', true );
	get_footer();

	Usage for single pages:
	get_header();
	$layout = new {{globals.code_layoutclass}};
	echo $layout->build_page( $post->ID );
	get_footer();

	*/
}

//======================================================================
// 7. CMB2 HELPER FUNCTIONS
//======================================================================


function {{globals.code_prefix}}get_tags_badge() {
	return '<span class="{{globals.code_textdomain}}-tags-opener">Tags Supported</span> ';
}


/**
* Include metabox only on the default page template (page.php). Heavily based of Ed Townend's front-page solution
* @author Rob Clark
*
* @param bool $display
* @param array $meta_box
* @return bool display metabox
*/
function {{globals.code_prefix}}cmb2_metabox_include_default_page( $display, $meta_box ) {
	if ( ! isset( $meta_box['show_on']['key'] ) ) {
		return $display;
	}
	if ( 'default-page-template' !== $meta_box['show_on']['key'] ) {
		return $display;
	}
	$post_id = 0;
	// If we're showing it based on ID, get the current ID
	if ( isset( $_GET['post'] ) ) {
		$post_id = $_GET['post'];
	} elseif ( isset( $_POST['post_ID'] ) ) {
		$post_id = $_POST['post_ID'];
	}
	if ( ! $post_id ) {
		return false;
	}
	$front_page = get_option( 'page_on_front' );
	$page_template = get_page_template_slug( $post_id );
	if ( ( empty( $page_template ) ) && ( $post_id != $front_page ) ) {
		$is_it_basic = true;
	} else {
		$is_it_basic = false;
	}
	// there is a front page set and we're on it!
	return $is_it_basic;
}
add_filter( 'cmb2_show_on', '{{globals.code_prefix}}cmb2_metabox_include_default_page', 10, 2 );


/*
Example Usage:

$cmb_options = new_cmb2_box( array(
	'id'            => $prefix . 'metabox',
	'title'         => esc_html__( 'Page Template Options', 'cmb2' ),
	'object_types'  => array( 'page' ),
	'show_on' => array( 'key' => 'default-page-template', 'value' => '' ),
) );
*/


/**
 * Include metabox on front page
 * @author Ed Townend
 * @link https://github.com/CMB2/CMB2/wiki/Adding-your-own-show_on-filters
 *
 * @param bool $display
 * @param array $meta_box
 * @return bool display metabox
 */
function {{globals.code_prefix}}cmb2_metabox_include_front_page( $display, $meta_box ) {
	if ( ! isset( $meta_box['show_on']['key'] ) ) {
		return $display;
	}

	if ( 'front-page' !== $meta_box['show_on']['key'] ) {
		return $display;
	}

	$post_id = 0;

	// If we're showing it based on ID, get the current ID
	if ( isset( $_GET['post'] ) ) {
		$post_id = $_GET['post'];
	} elseif ( isset( $_POST['post_ID'] ) ) {
		$post_id = $_POST['post_ID'];
	}

	if ( ! $post_id ) {
		return false;
	}

	// Get ID of page set as front page, 0 if there isn't one
	$front_page = get_option( 'page_on_front' );

	// there is a front page set and we're on it!
	return $post_id == $front_page;
}
add_filter( 'cmb2_show_on', '{{globals.code_prefix}}cmb2_metabox_include_front_page', 10, 2 );


/*
Example usage:

$cmb_options = new_cmb2_box( array(
	'id'            => $prefix . 'metabox',
	'title'         => esc_html__( 'Front Page Options', 'cmb2' ),
	'object_types'  => array( 'page' ),
	'show_on' => array( 'key' => 'front-page', 'value' => '' ),
) );
*/


//======================================================================
// 8. CMB2 OPTIONS LOADER
//======================================================================

function {{globals.code_prefix}}load_cmb2_options( &$obj, $temps ) {
	foreach ( $temps as $temp ) {
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



//======================================================================
// 9. CMB2 META BOXES
//======================================================================

/**
 * Front Page Metabox
 */

add_action( 'cmb2_admin_init', '{{globals.code_prefix}}register_page_front_metabox' );

function {{globals.code_prefix}}register_page_front_metabox() {
	$prefix = '_{{globals.code_prefix}}';

	$cmb_options = new_cmb2_box(
		array(
			'id'            => $prefix . 'metabox_page_front',
			'title'         => esc_html__( 'Front Page Options', 'cmb2' ),
			'object_types'  => array( 'page' ),
			'show_on' => array(
				'key' => 'front-page',
				'value' => '',
			),
		)
	);

	{{globals.code_prefix}}load_cmb2_options( $cmb_options, array( 'elements' ) );

}

/**
 * Default Page Metabox
 */

add_action( 'cmb2_admin_init', '{{globals.code_prefix}}register_page_default_metabox' );

function {{globals.code_prefix}}register_page_default_metabox() {
	$prefix = '_{{globals.code_prefix}}';

	$cmb_options = new_cmb2_box(
		array(
			'id'            => $prefix . 'metabox_page_default',
			'title'         => esc_html__( 'Additional Options', 'cmb2' ),
			'object_types'  => array( 'page' ),
			'show_on' => array(
				'key' => 'default-page-template',
				'value' => '',
			),
		)
	);

	{{globals.code_prefix}}load_cmb2_options( $cmb_options, array( 'example' ) );

}

/*
Example CMB2 registration for a custom page template:

add_action( 'cmb2_admin_init', '{{globals.code_prefix}}register_page_template_tmpname_metabox' );

function {{globals.code_prefix}}register_page_template_tmpname_metabox() {
	$prefix = '_{{globals.code_prefix}}';

	$cmb_options = new_cmb2_box(
		array(
			'id'            => $prefix . 'metabox_page_template_tmpname',
			'title'         => esc_html__( 'Template Options', 'cmb2' ),
			'object_types'  => array( 'page' ),
			'priority'     => 'high',
			'show_on'      => array(
				'key'   => 'page-template',
				'value' => 'templates/page-template-tmpname.php',
			),
		)
	);

	{{globals.code_prefix}}load_cmb2_options( $cmb_options, array( 'elements' ) );

}

*/

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