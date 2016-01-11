=== f(x) SSL ===
Contributors: turtlepod
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=TT23LVNKA3AU2
Tags: private site, members only, protect rss
Requires at least: 4.0
Tested up to: 4.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Simple SSL(HTTPS) Plugin.

== Description ==

**[f(x) SSL](http://genbu.me/plugins/fx-ssl/)** is a very simple plugin to force your site to use HTTPS.

After installation of this plugin, you can enable this in "Settings > General" under "SSL (HTTPS)" Section.

**Features:**

1. Super simple and easy to use. Only one checkbox.
1. Clear installation instruction.
1. Integrate to the WordPress "General" Settings seamlessly.
1. Fix URL in content, widget, etc to use HTTPS to make sure all images, etc loaded properly.
1. The GPL v2.0 or later license. :) Use it to make something cool.
1. Support available at [Genbu Media](https://genbu.me/contact-us/).


== Installation ==

1. Navigate to "Plugins > Add New" Page from your Admin.
2. To install directly from WordPress.org repository, search the plugin name in the search box and click "Install Now" button to install the plugin.
3. To install from plugin .zip file, click "Upload Plugin" button in "Plugins > Add New" Screen. Browse the plugin .zip file, and click "Install Now" button.
4. Activate the plugin.
5. Make sure you have `define( 'FORCE_SSL_ADMIN', true );` in your wp-config.php. For more info, please read [WordPress administration over SSL](https://codex.wordpress.org/Administration_Over_SSL).
6. Make sure you use HTTPS in "WordPress Address (URL)" and "Site Address (URL)" option in "General Settings".
7. Navigate to "Settings > General" page in "SSL (HTTPS)" Section.
8. Enable the plugin and visit your site front end.

== Frequently Asked Questions ==

= How to get SSL/HTTPS License ? =

In order to enable access to HTTPS/SSL, you need to have a SSL License and install it in your server. If you don't have one, please consult to your hosting company.

== Screenshots ==

1. Settings

== Changelog ==

= 1.1.0 - 11 Jan 2015 =
* Update readme.
* Update Notice.
* Use get_option() instead of get_bloginfo() to get site url.
* Use temporary redirect.

= 1.0.0 - 11 Jan 2015 =
* Init

== Upgrade Notice ==

= 1.0.0 =
initial relase.

= 1.0.1 =
Bug Fix.

== Other Notes ==

Notes for developer: 

= Github =

Development of this plugin is hosted at [GitHub](https://github.com/turtlepod/fx-ssl). Pull request and bug reports are welcome.

= Options =

This plugin save the options in single option name: `fx-ssl`.


= Hooks =

List of hooks available in this plugin:

**filter:** `fx_ssl_notice_fail` (string)

Plugin activation notice if feature is not supported.

**filter:** `fx_ssl_notice_success` (string)

Plugin activation notice if feature is supported.

**filter:** `fx_ssl_notice_active` (string)

Plugin activation notice if feature is supported and already active.

**filter:** `fx_ssl_settings_section_description` (string)

Settings description.

**filter:** `fx_ssl_fix_url` (string)

If you need to pass other URL to parse to content, excerpt, text widget, etc.
