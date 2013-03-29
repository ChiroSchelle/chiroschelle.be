$(document).ready(function() {

	//rotation speed and timer
	var speed = 6000;
	var run = setInterval('rotate()', speed);	
	
	//grab the width and calculate left value
	var item_width = $('#slider li').outerWidth(); 
	var left_value = item_width * (-1); 

	//move the last item before first item, just in case user click prev button
	$('#slider li:first').before($('#slider li:last'));
	
	//set the default item to the correct position 
	$('#slider ul').css({'left' : left_value});

	//if user clicked on next button
	$('#next').click(function() {

		//get the right position
		var left_indent = parseInt($('#slider ul').css('left')) - item_width;

		//slide the item
		$('#slider ul:not(:animated)').animate({'left' : left_indent}, 1000, function () {
			
			//move the first item and put it as last item
			$('#slider li:last').after($('#slider li:first'));                 	
			
			//set the default item to correct position
			$('#slider ul').css({'left' : left_value});

		});
		 
		//cancel the link behavior
		return false;

	});        
	
	//if mouse hover, pause the auto rotation, otherwise rotate it
	$('#slider').hover(

		function() {
			clearInterval(run);
		}, 
		function() {
			run = setInterval('rotate()', speed);	
		}
	); 
});

//a simple function to click next link
//a timer will call this function, and the rotation will begin :)  
function rotate() {
	$('#next').click();
}


