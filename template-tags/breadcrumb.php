<?php
/* 	umtag: breadcrumb 
 *
 */

 defined('ABSPATH') or die('huh?');


function umtag_breadcrumb() { um_breadcrumb_script();  }

function um_breadcrumb_script() {

	echo '<ul id="um-crumbs">';
				echo '<li><a href="';
				echo  home_url();
				echo '">';
				if (!is_home()) {
					echo 'Home';
				} else {
					echo 'Welcome';
				}
				echo "</a></li>";
				if (is_category() || is_single()) {
						echo '<li>';
						the_category(' </li><li> ');
						if (is_single()) {
								echo "</li><li>";
								the_title();
								echo '</li>';
						}
				} elseif (is_page()) {
						echo '<li>';
						echo the_title();
						echo '</li>';
				}
		elseif (is_tag()) {single_tag_title();}
		elseif (is_day()) {echo"<li>Archive for "; the_time('F jS, Y'); echo'</li>';}
		elseif (is_month()) {echo"<li>Archive for "; the_time('F, Y'); echo'</li>';}
		elseif (is_year()) {echo"<li>Archive for "; the_time('Y'); echo'</li>';}
		elseif (is_author()) {echo"<li>Author Archive"; echo'</li>';}
		elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {echo "<li>Blog Archives"; echo'</li>';}
		elseif (is_search()) {echo"<li>Search Results"; echo'</li>';}
	echo '</ul>';
}


?>