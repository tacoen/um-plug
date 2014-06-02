=== Plugin Name ===
Contributors: tacoen
Donate link: 
Tags: customization
Requires at least: 3.8.1
Tested up to: 3.9.1
Stable tag: 1.1.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

UM Themes tool kits, a Wordpress developer Toolkit for creating/ maintaining/ optimizing a theme.

== Description ==

UM Themes core and tool kits, a Wordpress developer Toolkit for creating/ maintaining/ optimizing a theme.

== Features ==
  * Minimize: Option to Dashboard Load, WP Header,
  * Option to disable:  WP Toolbar, Gravatar Loads, 
  * Alter CDN, if you don't like Google CDN or behind firewall
  * Shorten WP resources URI (URL Rewrites)
  * Come with Handy jQuery Function for more controls on user view.
  * Ajax Login
  * Reduce load by use static generated-minimized stylesheet
  * Reduce load by Minified UM-Theme related Javascripts (1.0.4)
  * Develop your own reset.css, reset your own Wordpress style (Moved to themes, since 1.0.0)
  * Chunks for static contents, Chunks will avaliable as shortcode or widgets 
  * Facebook, Twitter contact method
  * Pluggable template tag
  * Pluggable template part
  * Pluggable JS/CSS Addon for Page Template (since 1.0.0)
  * Unicode webfonts

= Links = 

  * Demo avaliable at http://umumum.qsandbox.com/ -- Access-code: 0000 
  * [UM-Plug GitHub Repository](https://github.com/tacoen/um-plug)
  * [UM-Themes GitHub Repository](https://github.com/tacoen/um-theme)
  
= Onepage/Page templates Add ons = 

  * [wow.js](http://mynameismatthieu.com/WOW/) and animate.css
  * [impress.js](http://bartaz.github.io/impress.js/)
  * [fullpage.js](http://alvarotrigo.com/fullPage/)
  * [OnePageScroll.js](http://www.thepetedesign.com/demos/onepage_scroll_demo.html)
  * [Freewall.js](http://vnjs.net/www/project/freewall/)

== Installation ==

1. Upload the zip file and extract it to your `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Configure the options

== Frequently Asked Questions ==

= A question that someone might have =

An answer to that question.

= What about foo bar? =

Answer to foo bar dilemma.

== Screenshots ==

1. Customize Screen with Media Queries.
2. Options

== Changelog ==

= 1.1.5 = 
  * Replace umi with umi-wp, Icomoon, using unicode char (as equals, e.g: raquo is &raquo;) <http://icomoon.io/>

= 1.1.4 = 
  * Media Queries in wp-head, <http://css3mediaqueries.com> instead in .css files
  * Adjust-abale media max-width in Themes Options
  
= 1.1.3 = 
  * Media Queries
  * 3 Size Media Queries (Desktop,Tablet,Handheld) in Customize Options

= 1.1.2 =
  * Bug fix for minified css
  * Bug fix for private cdn links options
  * Split head, and foot minified javascripts
  
= 1.1.1 = 
  * UM Themes Compability, All UM-Themes shall look nice even without UM-Plug Plugins 
  
= 1.1.0 = 
  * Reorganized UM-Plug Options Menu
  * Pulling back um-core to Plugins as backup-sets
  
= 1.0.5 = 
  * Added fontastic.me <http://.fontastic.me> generated font style.css as umui(umi)

= 1.0.4 = 
  * Minified Theme related Javascripts (um-gui-lib.js)
  
= 1.0.3 = 
  * Page Template Addons: [wow.js](http://mynameismatthieu.com/WOW/) and animate.css
  * um-reset.php now only for heredoc's (.entry-content and .comment-content ), normalizer, um-reset-ui.css, wp-reset.css are now enqueue into header, all still concatenate as um-reset.css
  
= 1.0.2 = 
  * Page Template Addons: [impress.js](http://bartaz.github.io/impress.js/)
  * Page Template Addons: [fullpage.js](http://alvarotrigo.com/fullPage/)
  * Page Template Addons: [OnePageScroll.js](http://www.thepetedesign.com/demos/onepage_scroll_demo.html)
  * Page Template Addons: [Freewall.js](http://vnjs.net/www/project/freewall/)

= 1.0.1 = 
  * Add OnePage (Page Template) addons
  * Neater theme checklist

= 1.0.0 = 
  * Avaliable in Wordpress.org
  * Move color scheme to theme (um-core) as Theme options
  * Move um-reset to theme (um-core) as Theme options
  * Move um-gui-lib to theme (um-core) as Theme options
  * Move um-ajaxlogin to theme (um-core) as Theme options
  
= 0.1.5

  * Minimize: Option to Dashboard Load, WP Header,
  * Alter CDN, if you don't like Google CDN or behind firewall
  * Shorten WP resources URI (URL Rewrites)
  * Develop your own reset.css, reset your own Wordpress style  
  * Chunks for static content, Chunks avaliable as shortcode and widgets
  * Pluggable template tag
  * Pluggable template part
  * Come with Handy jQuery Function for more controls on user view
  * Ajax Login
  * Option to disable:  WP Toolbar, Gravatar Loads, 
  * Reduce load by use static generated-minimized stylesheet
  * Facebook, Twitter contact method
  * Initial Github Release

== Upgrade Notice ==

