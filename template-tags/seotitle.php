<?php
/* umtag: credits
 *
 */

defined('ABSPATH') or die('huh?');
 
function umtag_seotitle() {
	wp_title(''); 
	if(wp_title('', false)) 
					{ echo "- "; bloginfo('name');  }
	if(is_home())   { echo ": "; bloginfo('description'); } 
	if(is_single()) { echo ": Archive "; }

} 


