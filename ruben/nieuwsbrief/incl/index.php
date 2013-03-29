<pre>
<?php

require 'mailman.php';
require 'config.php';

$mm=new Mailman($_adminurl,$_list,$_adminpw);
//get a list of lists as an array
//print_r($mm->lists());
//echo $mm->subscribe('user@example.co.uk');
$members=$mm->members();
print_r($members);
echo count($members[0]);

//eof