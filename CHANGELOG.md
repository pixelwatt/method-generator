## 1.2.1

This release updates _globals-defaults.html to reflect the version number changes for Method v1.2.1.

---

## 1.2.0

This release includes several additions and bugfixes. Now, functions.php is broken out into several files in the /lib folder to support a more streamlined workflow.

New Globals:
* require_cmb2_mapbox - (default: false) If true, the theme will require the CMB2 Mapbox fieldtype plugins.
* js_use_matchheight - (default: true) If true, the path to the matchheight library will be added to the array of scripts to combine via the scripts gulp task.
* js_use_jarallax - (default: true) If true, the path to the jarallax library will be added to the array of scripts to combine via the scripts gulp task.
* localdev_url - (default: method.test:8080) The local developement URL to set as the proxy for browsersync.

Removed Globals:
* social_options

Other Changes:
* ( build/ ) Updated to v1.2.0
* ( njk/assets/gulpfile.js ) Method's gulpfile is now compiled by build/rebuild tasks, implementing support for the new js_use_matchheight, js_use_jarallax, and localdev_url globals
* ( njk/assets/lib/class-theme-layout.php ) Removed the build_social_icons() method, which is now located in the Method_Layout class.
* ( njk/assets/lib/cmb2-options-loader.php ) Added a $prefix variable, which is the name of the current options template, but with hypens instead of underscores.
* ( njk/assets/lib/helper-functions.php ) The returned classes for 'full_width_outer_col' now includes the 'full-width-outer-col' class.
* ( njk/assets/lib/helper-functions.php ) For both the method_get_post_array() and method_get_term_array() functions, the $none argument now defaults to being an empty string, with the function ignoring it if empty. If a non-empty string is provided, a "none" item will be added to the returned array as the first array value, with an empty key.
* ( njk/assets/lib/helper-functions.php ) The method_get_content() function was removed. Instead, use: `method_filter_content( get_the_content( null, false, $post->ID ) )` (if outside the layout class) or `$this->filter_content( get_the_content( null, false, $this->id ) )` (if inside the layout class)
* ( njk/assets/lib/theme-customization.php ) In the repeatable options group for social media accounts, the service is now picked via a select element and not radio buttons. Additionally, an option for _None_ was added, and is now the default.
* ( njk/assets/lib/theme-support.php ) Added array for CMB2 Mapbox to potential required plugin arrays.

---

## 1.1.6

Changes:
* ( build/ ) Updated to v1.1.6
* ( njk/assets/functions.php ) Updated paths for 'tgm-plugin-activation' and 'wp-bootstrap-navwalker'
* ( njk/templates/_globals-defaults.html ) Updated the version number for 1.1.6

---

## 1.1.5

Changes:
* ( build/ ) Updated to v1.1.5
* ( njk/templates/_globals-defaults.html ) Updated the version number for 1.1.5

---

## 1.1.4

Changes:
* ( build/ ) Updated to v1.1.4
* ( njk/templates/_globals-defaults.html ) Updated the version number for 1.1.4

---

## 1.1.3

This release contains no major changes on the generator-side, but includes and supports Method v1.1.3, which includes several additions to the Method_Layout class.

---

## 1.1.2

This release contains no major changes on the generator-side, but includes and supports Method v1.1.2, which includes updates to the layout class.

---

## 1.1.1

This update removes Bootstrap settings from globals and no longer generates a custom _variables.scss file. Variable overrides can more be set in the theme.scss file to avoid editing Bootstrap scss files.

---

## 1.1.0

This release supports the v1.1.0 release of the Method theme and its new abstract layout class.

Changes:
* ( build/ ) Updated to v1.1.0
* ( njk/assets/functions.php ) Fixed a reference to an undeclared variable in the check_key() function.
* ( njk/assets/functions.php ) Rewrote the theme layout class to extend the new Method_Layout class. This makes it possible to easily upgrade the core layout class as it's updated, since its now isolated and should not need to be directly edited.
* ( package.json ) Fixed references to old project names.

---

## 1.0.15

Changes:
* ( build/ ) Updated to v1.0.15
* ( njk/assets/functions.php ) Fixed an issue with the unload_meta method in the layout class (an ID does not need to be passed to the method)
* ( package.json ) Changed dependencies to latest-available versions.

Please note: If you encounter a problem when installing dependencies, upgrade to the latest node release and reattempt installation.

---

## 1.0.14

Changes:
* ( build/ ) Updated to v1.0.14
* ( njk/assets/assets/css/bootstrap/\_variables.scss ) Rolled in Bootstrap v4.5.3 changes into the variables njk template so that generated assets will work with the v4.5.3 release used in Method.

---

## 1.0.13

Changes:
* ( build/ ) Updated to v1.0.13
* ( njk/assets/functions.php ) Added a new method to the layout class, get_headline(), to provide a uniform method for handeling fields that support format tags. This also allows for cleaner code, as the method handles logic for checking if a meta key is empty, falling back to an optionally provided fallback, and then not rendering anything. While fallback strings are not processed in any way, metakeys are passed through esc_html() and then the format_tags method if not empty. Example usage: $this->get_headline( 'my_meta_key', '<h2>', '</h2>', 'Fallback' )
* ( njk/assets/functions.php ) Added a new function, {{globals.code_prefix}}get_tags_badge(), that returns HTML for a "Tags Supported" badge. This badge can be inserted into CMB2 field descriptions for fields that will be passed through the format_tags() method of the layout class. Clicking the badge will open a dialog listing available tags. If you add additional tags to the format_tags() method, you should update the dialog's text to detail them so that content editors know that they are available and what they do.
* ( njk/assets/assets/css/admin-styles.css ) Added an admin CSS file, which currently contains styles for the "Tags Supported" badge (span.{{globals.code_textdomain}}-tags-opener)
* ( njk/assets/functions.php ) Added a new function, {{globals.code_prefix}}admin_scripts(), that registers admin-styles.css, the jquery ui dialog plugin, and styles for the current version of WordPress-bundled jquery ui for the admin area of the site via admin_enqueue_scripts
* ( njk/assets/functions.php ) Added a new function, {{globals.code_prefix}}admin_footer_function(), that injects js and html for the format tags dialog into the admin footer via admin_footer
* ( njk/assets/functions.php ) Added support for inserting em tags to strings processed with the format_tags method.
* ( njk/assets/functions.php ) Added new methods to the layout class for loading a second set of post meta, retrieving loaded meta in a similiar fashion to the get_meta() method, and unloading the meta. This was added for easier handling of meta in archive layout components. ( load_meta(), get_loaded_meta(), get_serialized_loaded_meta(), unload_meta() )
* ( njk/assets/functions.php ) Added a new method to the layout class, get_loaded_headline(), for indentical headline processing to the get_headline() method, but with loaded meta instead.

---

## 1.0.12

Changes:
* ( build/ ) Updated to v1.0.12
* ( gulpfile.js ) Removed localdev functions.
* ( njk/assets/assets/css/bootstrap/\_variables.scss ) Added the Bootstrap variables file and tied color/font variables to globals in \_globals-defaults.html
* ( functions.php ) Added a new function, method_str_replace_assoc(), to find/replace strings using values from an associative array.
* ( functions.php ) Modified markup for the layout class default 'active' component to look like the 404 template.
* ( functions.php ) Added a new function to the layout class, format_tags(), for replacing format tags with html markup.
* ( njk/assets/login.js ) Removed the login.js file as granim is no longer used for custom login pages.
* ( njk/templates/\_globals-defaults.html ) Added formatting to the file make it easier to browse as more variables are added.
* ( njk/templates/\_globals-defaults.html ) Added variables for Bootstrap's base color pallet, primary and secondary brand colors, and select features.
* ( njk/templates/\_globals-defaults.html ) Added a variable, bootstrap_font_family_sans_serif, to prepend an additional sans-serif font family to Boostrap's default sans-serif font stack. Default: false
* ( njk/templates/\_globals-defaults.html ) Added a variable, bootstrap_font_family_serif, that, if set to a serif font family, will add in a $font-family-serif variable into \_variables.scss, set to the provided family, and append Bootstrap 3's default serif stack to it.
* ( njk/templates/\_globals-defaults.html ) Added a variable, bootstrap_font_family_theme, that, if set to a serif font family, will add in a $font-family-theme variable into \_variables.scss, set to the provided family

---

## 1.0.11

Changes:
* ( build/ ) Updated to v1.0.11
* ( njk/assets/functions.php ) Fixed empty lines generated when not requiring all plugins to appears to WordPress coding standard gods
* ( njk/assets/login.css ) Added styles to set a background image and color for body.login, removed styles for #bg-canvas, as it is no longer injected into the login page.
* ( njk/templates/\_globals-defaults.html ) Updated to path for custom_login_logo to use the new svg logo in included in Method v1.0.11
* ( njk/templates/\_globals-defaults.html ) Removed the custom_login_bg_blending option, as granim is no longer included or used for the login page.
* ( njk/templates/\_globals-defaults.html ) Updated the path for custom_login_bg to no longer begin with a forward-slash.

---

## 1.0.10

Changes:
* ( build/ ) Updated to v1.0.10 
* ( njk/templates/\_globals-defaults.html ) Updated theme name and version number references.
* ( njk/templates/\_globals-defaults.html ) Added a new variable, github_theme_uri, to add theme support for the GitHub Updater plugin. Set to false to omit.
* ( njk/templates/\_globals-defaults.html ) Changed the default value for require_classic_editor to false, so that the Classic Editor plugin is no longer required by default.
* ( njk/templates/\_globals-defaults.html ) Added variables to optionally make compiled themes require "CMB2 Roadway Segments" and "GitHub Updater"
* ( njk/assets/style.css ) Added conditional to add the GitHub Plugin URI to theme info if globals.github_theme_uri is set (and not to false)
* ( njk/assets/functions.php ) Added conditionals to set "CMB2 Roadway Segments" and "GitHub Updater" as required plugins if the corresponding global variables are set to true
* ( njk/assets/functions.php ) Changed the handle for the theme's combined/compressed js to be the value of globals.code_textdomain
* ( njk/assets/functions.php ) Fixed a bug with CMB2 helper function names that caused CMB2 to not function.
* ( README.md ) Added information about prerequisites for installation, installation instructions, and project tasks.
* ( gulpfile.js / package.json ) Removed a significant number of dependencies not needed for this this project.
* ( gulpfile.js ) Renamed the "rebuild-sunrise" task to "rebuild-method"

---

## 1.0.9

This release implements name changes (Sunrise is now Method), and includes minor fixes and enhacements.

Changes:
- ( build/ ) Updated the compiled Sunrise theme to v1.0.9
- ( njk/assets/login.css ) Fixed a hard-coded text color for links in p#nav (now uses globals.custom_login_accent), and implemented the new globals.custom_login_btn_color variable (used for button and message text color)
- ( njk/assets/login.js ) Tweaked the gradient set
- ( njk/templates/\_globals-defaults.html ) Changed all name references to reflect the new theme name, added the new custom_login_btn_color variable
- ( README.md ) Updated theme name references.

---

## 1.0.8

This release includes minor bugfixes and adds njk files for all templates for correct class naming.

Changes:
- ( build/ ) Updated the compiled Sunrise theme to v1.0.8
- ( functions.php ) Updated the commented code examples at the end of the layout class code to use the class name provided in globals.html
- ( functions.php ) Updated the function names for CMB2 helpers to use the theme prefix provided in globals.html
- ( front-page.php, index.php, page.php, single.php ) Added njk templates for the theme's included template files so that the class name provided in globals.html can be included in the files
- ( package.json ) Updated the version number. Version numbers will now coincide with the release of the Sunrise theme built with the project.
- ( README.md ) Added additional content. Still need to find time to write out documentation.
- ( CHANGELOG.md ) Added a changelog