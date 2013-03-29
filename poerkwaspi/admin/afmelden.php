<?php

	###############################################
    #                                             #
    #		--- CMS 1.0 - LOGOUT ---        	  #
    #                                             #
    #		Author: Jasper De Smet				  #
	#		Email: contact@jasperdesmet.be        #
	#		Website: www.jasperdesmet.be          # 
	#		Last edited: 20 November 2010         #
    #		Version: 1.0                          #
	#                                             #
    ###############################################

# session_start
session_start();

// Unset variables.
$_SESSION = array();

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

# destroy the session.
session_destroy();
header('Location: ../login.php');
?>