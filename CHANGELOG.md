## v2-1.0.0-beta5

This release brings Method Generator up to date with Method Child v1.0.0-beta5 and adds automation to the build-custom task, including an optional git push of the finished build. It consolidates all changes made since v2-1.0.0-beta2 ( including the v2-1.0.0-beta3 and v2-1.0.0-beta4 tags ).

Generator changes:
* ( gulpfile.js ) build-custom can now push the finished build to a git remote. After rendering, the new push-custom task initializes a repository in ./custom, makes an initial commit, and pushes it to the configured remote and branch. This is skipped unless `push_custom_build` is true and `git_remote_url` is set in njk/templates/_globals.html.
* ( njk/templates/_globals-defaults.html ) Added a "GIT Push" section with `push_custom_build` ( default: false ), `git_remote_url`, and `git_branch` ( default: main ). Copy this section into your existing _globals.html to use the new push option.
* ( gulpfile.js ) rebuild-custom is now a series of three tasks: render-custom ( the previous rebuild-custom ), clean-custom, and push-custom. The new clean-custom task removes .git, node_modules, and package-lock.json from ./custom.
* ( gulpfile.js ) Added a build-notify task, which prints a completion message with a link to the documentation at the end of build-custom.
* ( gulpfile.js ) Nunjucks is now configured explicitly for both render tasks: autoescaping is off, block trimming is off, and template caching is disabled.
* ( README.md ) Updated the banner image, and the readme now points to Method Child and to the Method wiki at https://method.wiki.
* ( package.json ) Bumped version to v2-1.0.0-beta5.

Template changes ( to match Method Child v1.0.0-beta3 through v1.0.0-beta5 ):
* ( method-child ) Submodule now points to Method Child v1.0.0-beta5.
* ( REMOVED FILE: njk/assets/lib/theme-options.php ) Generated themes no longer register their own "Theme Settings" options page. Theme-specific options are now added to Method's options page instead.
* ( njk/assets/lib/blocks.php ) The global stylesheet is now only enqueued on the front end. In the block editor it is loaded with `add_editor_style()` so that its scope is limited to the content iframe.
* ( njk/assets/lib/blocks.php ) Core block patterns are now removed from the block editor by default.
* ( njk/assets/lib/blocks.php ) Added commented examples for registering block pattern categories, block categories, heading block styles, theme button styles, secondary theme button styles and their label, theme button label styles, and theme icons ( `method_theme_icons` filter ). Function names, slugs, and text domains in these examples use your configured code prefix, text domain, and theme name.
* ( njk/assets/lib/theme-setup.php ) Added commented examples for adding social platforms ( `method_available_social_platforms` filter ), adding theme-specific options to Method's options page ( `method_options_before_fields` action ), and enabling responsive embeds ( `method-responsive-embeds` theme support ).
* ( njk/assets/style.css ) Fixed the theme header comment, which was missing its closing `*/`.
* ( njk/templates/_globals-defaults.html ) Default theme version is now 1.0.0-beta5, and the default Theme URI now points to https://method.wiki.
