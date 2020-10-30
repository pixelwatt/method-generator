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