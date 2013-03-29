<?php

class login {
	

               
        var $ingelogd;

        function login() {
 			$this->ingelogd = false; //default uitgelogd
            session_start(); //start een sessie
            if(isset($_POST['loguit'])) $this->loguit();
            elseif(isset($_COOKIE['member_id'])&isset($_COOKIE['pass_hash'])) {
     	  		$sql = "id = ".(int)$_COOKIE['member_id']."  AND password = '".addslashes($_COOKIE['pass_hash'])."'";
     	  		$controle = $this->controleer_paswoord($sql);
	         	$this->ingelogd = $controle;  
            }
            if(isset($_POST['member_name'])&isset($_POST['pass'])&!$this->ingelogd) {   //geen elseif, wordt dan sobieso uitgevoerd, ook als je last hebt met verkeerde info in cookies en via form wilt inloggen
     			$sql = "name = '".addslashes($_POST['member_name'])."' AND password = '".md5(addslashes($_POST['pass']))."'";
     			$controle = $this->controleer_paswoord($sql);
    			$this->ingelogd = $controle; 
    	    if($this->ingelogd) {
                setcookie ("member_id",$_SESSION['member_id'],time() + 3600*24*30,'/','localhost');
                setcookie ("pass_hash",md5($_POST['pass']),time() + 3600*24*30,'/','localhost');
                }
    } 
        }//end function
           
        function controleer_paswoord($a) {
        	require('db_connect.php'); //script voor databaseconnect ( mysql_connect en mysql_select_db)
          	$sql = "SELECT naam,id FROM users WHERE ".$sql2; //nu volledige query
          	$result = mysql_query($sql) or die (mysql_error());
          	if($row = mysql_fetch_object($result)) {
               $_SESSION['count']=1;
               $_SESSION['member_id']=$row->id;
               $_SESSION['member_name']=$row->name;
               return true; //ingelogd
               }
       		else return false; //niet ingelogd
       		
       }//end function

             
           
        function is_ingelogd() {        
			return $this->ingelogd;
        }
       
        function get_output() {
			if($this->is_ingelogd) return '<div>Je bent ingelogd als: '.$_SESSION['member_name'].'. Je hebt al '.$_SESSION['count'].' pagina\'s bezocht. <form action="'.$_SERVER['REQUEST_URI'].'" method="post"><input type="submit" name="loguit" value="Log me uit" /></form></div>';
            else return '<div><form action="'.$_SERVER['REQUEST_URI'].'" method="post"><input type="text" name="member_name" /><input type="password" name="pass" /><input type="submit" name="submit" value="Log me in" /></form></div>' ;
        }//end function
           
        function loguit() {
       		session_unset();
     		session_destroy();
     		setcookie ("member_id", "", time() - 3600,"/", "jouw_domein.be");
		    setcookie ("pass_hash", "", time() - 3600,"/", "jouw_domein.be");
     		$this->ingelogd = false;

        }
}//end function
      
//end class

$bezoeker = new login();

?>