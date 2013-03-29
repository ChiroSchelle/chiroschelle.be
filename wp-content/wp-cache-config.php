<?php
/*
WP-Cache Config Sample File

See wp-cache.php for author details.
*/

$cache_enabled = true; //Added by WP-Cache Manager
$cache_max_time = 3600; //in seconds
//$use_flock = true; // Set it tru or false if you know what to use
$cache_path = ABSPATH . 'wp-content/cache/';
$file_prefix = 'wp-cache-';

// Array of files that have 'wp-' but should still be cached 
$cache_acceptable_files = array ( 0 => 'wp-atom.php', 1 => 'wp-comments-popup.php', 2 => 'wp-commentsrss2.php', 3 => 'wp-links-opml.php', 4 => 'wp-locations.php', 5 => 'wp-rdf.php', 6 => 'wp-rss.php', 7 => 'wp-rss2.php', 8 => 'wp-programma.php', ); //Added by WP-Cache Manager

$cache_rejected_uri = array ( 0 => 'wp-', 1 => '/leiding2', 2 => '/info/leidingsploeg/', 3 => '/ben/', 4 => '/test/', 5 => '/wp-programma', 6 => '/lees-database', 7 => '/programma2/', ); //Added by WP-Cache Manager
$cache_rejected_user_agent = array ( 0 => 'bot', 1 => 'ia_archive', 2 => 'slurp', 3 => 'crawl', 4 => 'spider');

// Just modify it if you have conflicts with semaphores
$sem_id = 5419;

if ( '/' != substr($cache_path, -1)) {
	$cache_path .= '/';
}

?>
