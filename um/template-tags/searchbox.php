<?php
/* umtag: searchbox
 *
 */
 
defined('ABSPATH') or die('huh?');
 
function searchbox() { 
//global $current_user; get_currentuserinfo();
//print_r($current_user);
?><div id="um-site-search"><?php get_search_form(); ?></div><?php } 
