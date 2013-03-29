<?php
function addlinks($text = ""){
	 // The Regular Expression filter
	 $reg_exUrl = "/(((http|https|ftp|ftps)\:\/\/)|www)[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
	 // Check if there is a url in the text
	 if(preg_match($reg_exUrl, $text, $url)) {
	 // make the urls hyper links
	 return  preg_replace($reg_exUrl, "<a href='{$url[0]}' style=' color: #302D26; text-decoration:underline';>{$url[0]}</a> ", $text);
	 } else {
	 // if no urls in the text just return the text
	 return $text;
	 }
}
function fileExists($path){
    return (@fopen($path,"r")==true);
}
?>