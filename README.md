# Method Generator

This project allows you to rapidly create custom builds of the [Method](https://github.com/pixelwatt/method) theme using Gulp and Nunjucks.

## Prerequisites:

To compile custom theme releases using the included gulp tasks, you'll need:
* [Node / NPM](https://nodejs.org/en/)
* [Gulp](https://gulpjs.com/) (v4.0.0+)

## Getting Started:

1. First, install the project's dependencies by running the following command from method-generator's root folder: `npm install --save-dev`
2. Next, copy `njk/templates/_globals-defaults.html` to `njk/templates/_globals.html`. This new file will be used when compiling a custom version of the base theme.
3. Reconfigure the new `_globals.html` file to reflect your project (documentation for global variables coming soon).
4. When you're ready to compile, from the method-generator's root folder run the following command: `gulp build-custom`. This will copy the stock version of the theme into a new directory, `./custom`, compile core theme files with the custom variavles you've set, and copy them over the stock files in `./custom`
5. To fully rebrand the theme, you'll need to replace 3 image files with your own:
	* `./custom/screenshot.png`: The screenshot displayed when choosing a theme from the Wordpress admin. The resolution of this image should be 1200px x 900px
	* `./custom/assets/images/login-bg.jpg`: The background image to use for the login page (only required if the custom_login_enable global variable was set to true )
	* `./custom/assets/images/login-logo.png`: The logo to use for the login page. Should be no wider than 250px (only required if the custom_login_enable global variable was set to true )
6. That's it! You should have a custom theme ready to use for development!

## Developing with Method

For documentation on building with the Method theme (or a custom version of it), head over to the [theme project](https://github.com/pixelwatt/method).

## Tasks / Roadmap:
- [x] Ensure that the compiled version of functions.php passes phpcs checks for Wordpress-core standards (aside from 2 minor issues)
- [ ] Write full project documentation
- [ ] Implement gulp tasks to pull latest assets of js libraries and combine during the `build-custom` task
- [ ] Add option to compile the theme without support for blog posts
- [ ] Include Bootstrap variables file as a njk template to allow fonts and core colors to be configured via the \_globals.html file.