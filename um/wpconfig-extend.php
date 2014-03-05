<?php

// Read: http://codex.wordpress.org/Editing_wp-config.php

/* You can: wp-admin/maint/repair.php */
//define('WP_ALLOW_REPAIR',true);

//define('WP_DEBUG',true);
//define('WP_DEBUG_DISPLAY',true);
//define('WP_ALLOW_MULTISITE',true);
//define ('EMPTY_TRASH_DAYS',7);

/* WordPress Cache */
//define('WP_CACHE',true);

/* Compression */
define('COMPRESS_CSS',true);
define('COMPRESS_SCRIPTS',true);
define('CONCATENATE_SCRIPTS',true);
define('ENFORCE_GZIP',true);

/* Updates */
define('WP_AUTO_UPDATE_CORE','minor');

/* Disable Editing */
//define('DISALLOW_FILE_EDIT',true);
//define('DISALLOW_FILE_MODS',true);

?>
