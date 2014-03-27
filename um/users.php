<?php

add_filter('user_contactmethods', 'my_user_contactmethods');

// echo get_user_meta(1, 'twitter', true);             

function my_user_contactmethods($user_contactmethods){
//unset($user_contactmethods['jabber']);
 
  $user_contactmethods['twitter'] = 'Twitter Username';
  $user_contactmethods['facebook'] = 'Facebook Username';
 
  return $user_contactmethods;
}

?>