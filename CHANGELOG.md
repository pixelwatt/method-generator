## 1.0.9

This release implements name changes (Sunrise is now Method), and includes minor fixes and enhacements.

Changes:
- ( build/ ) Updated the compiled Sunrise theme to v1.0.9
- ( njk/assets/login.css ) Fixed a hard-coded text color for links in p#nav (now uses globals.custom_login_accent), and implemented the new globals.custom_login_btn_color variable (used for button and message text color)
- ( njk/assets/login.js ) Tweaked the gradient set
- ( njk/templates/\_globals-defaults.html ) Changed all name references to reflect the new theme name, added the new custom_login_btn_color variable
- ( README.md ) Updated theme name references.

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