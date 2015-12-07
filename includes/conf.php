<!-- classUtil.php
//
// MAINTENANCE HISTORY
// DATE         PROGRAMMER AND DETAILS
// 07-12-15     Rahul Sharma    	Original
//									Enabled mod_rewrite for cleaner URLs
//
//-------------------------------------------------------------------------------------
-->
<?php

// page title
define('PAGE_TITLE', 'URL Shortener');

// mysql connection info
define('MYSQL_USER', 'root');
define('MYSQL_PASS', '');
define('MYSQL_HOST', 'localhost');
define('MYSQL_DB', 'db_urlshortener');

// mysql table
define('URL_TABLE', 'tbl_urls');

// use mod_rewrite, enable for cleaner URL
define('REWRITE', true);	// mod_rewrite must be enabled
?>