=== um-plug ===
Contributors: tacoen 
Requires at least: 3.8.1
Tested up to: 3.9.1
Stable tag: 1.1.9

UM Wordpress themes core and tool-kits, a Wordpress developer Toolkit for creating/ maintaining/ optimizing a theme.

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
  * Reduce load by Minified UM-Theme related Javascripts 
  * Chunks for static contents, Chunks will avaliable as shortcode or widgets 
  * Facebook, Twitter contact method
  * Pluggable template tag (shortcod-ed where possible)
  * Pluggable template part
  * Pluggable JS/CSS Addon for Page Template
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

1. Extract the zip file and just drop the contents in the wp-content/plugins/ directory of your WordPress installation and then activate the Plugin from Plugins page.
1. Configure the options

== Frequently Asked Questions ==

= An answer of question that someone might have =

(https://github.com/tacoen/UM-Plug/wiki)

== Screenshots ==

1. Customize Screen with Media Queries.
2. Options
3. Theme Setup
4. Overview
5. Chunks

== Changelog ==

= 1.1.9 =
  * Fix 10px padding in images
  * More tweak options

= 1.1.8 =
  * Better css/js minified method
  
= 1.1.6 =
  * Move chunks out of template directory to uploads
  * Rename template-tags directory into umtag directory
  * PHP 5.4+ PCRE Fix
  
= 1.1.5 = 
  * Replace umi with umi-wp, Icomoon, using unicode char (as equals, e.g: raquo is &raquo;) <http://icomoon.io/>
  * Webfonts as options

= 1.1.4 = 
  * Media Queries in wp-head, <http://css3mediaqueries.com> instead in .css files
  * Adjust-abale media max-width in Themes Options
  * CSS base custome-Header features in UM-Themes ('um-headimg')
  * Style filenaming Compability: reset.css and others rebuilding-styles were moved into css/ path, medium.css, and small.css moved into theme roots
  
= 1.1.3 = 
  * Media Queries
  * 3 Size Media Queries (Desktop,Tablet,Handheld) in Customize Options

= 1.1.2 =
  * Bug fix for minified css
  * Bug fix for private cdn links options
  * Split head, and foot minified javascripts
  * Utilize WP-Admin Contextual Help
  
= 1.1.1 = 
  * UM Themes Compability, All UM-Themes shall look nice even without UM-Plug Plugins 
  * Style filenaming Compability (default.css are now base.css, um-reset are now reset.css)
  
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
