<?php
if( !defined( 'ABSPATH' ) && !defined( 'WP_UNINSTALL_PLUGIN' ) )
    exit();

delete_option( 'lk-excerpt-length-value' );
delete_option( 'lk-excerpt-suffix-value' );
?>