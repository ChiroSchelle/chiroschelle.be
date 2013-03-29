var imageparking;
var shadowparking;
var shapeparking;
var map;

  function initialize() {
		console.log(templateDir);
		var latlng = new google.maps.LatLng(51.126629674096506,4.335265159606934);
		var myOptions = {
		  zoom: 14,
		  center: latlng,
		  backgroundColor: '#ffffff',
		  maxZoom:17,
		  minZoom:8,
		  mapTypeId: google.maps.MapTypeId.ROADMAP,
		  mapTypeControl: false,
		};
		map = new google.maps.Map(document.getElementById("map"), myOptions);
		
		var fuifLocation = new google.maps.LatLng(51.12436090082851,4.336177110671997);	
		var stfLocation = new google.maps.LatLng(51.12845125572378,4.333312511444092);
		
		var image = new google.maps.MarkerImage(
				templateDir + '/img/gm_marker.png',
				new google.maps.Size(50,50),
				new google.maps.Point(0,0),
				new google.maps.Point(25,50)
			  );
		
		  var imagestf = new google.maps.MarkerImage(
			templateDir + '/img/gm_marker_stf.png',
			new google.maps.Size(12,50),
			new google.maps.Point(0,0),
			new google.maps.Point(6,50)
		  );

		var shadow = new google.maps.MarkerImage(
			templateDir + '/img/gm_shadow.png',
			new google.maps.Size(78,50),
			new google.maps.Point(0,0),
			new google.maps.Point(25,50)
		  );
		
		 var shadowstf = new google.maps.MarkerImage(
			templateDir + '/img/gm_marker_stf_shadow.png',
			new google.maps.Size(40,50),
			new google.maps.Point(0,0),
			new google.maps.Point(6,50)
		  );
		
		var shape = {
			coord: [28,2,35,3,37,4,39,5,40,6,42,7,43,8,44,9,44,10,45,11,46,12,47,13,47,14,48,15,48,16,48,17,49,18,49,19,49,20,49,21,49,22,49,23,49,24,49,25,49,26,49,27,49,28,49,29,49,30,49,31,49,32,49,33,48,34,48,35,48,36,47,37,47,38,46,39,45,40,44,41,44,42,43,43,42,44,40,45,39,46,37,47,35,48,32,49,20,49,17,48,15,47,13,46,12,45,10,44,9,43,8,42,8,41,7,40,6,39,5,38,5,37,4,36,4,35,4,34,3,33,3,32,3,31,3,30,3,29,3,28,3,27,3,26,3,25,3,24,3,23,3,22,3,21,3,20,4,19,4,18,4,17,5,16,5,15,6,14,6,13,7,12,7,11,8,10,9,9,10,8,11,7,12,6,14,5,16,4,18,3,22,2,28,2],
			type: 'poly'
		  }; 

  var shapestf = {
    coord: [10,0,10,1,10,2,10,3,10,4,10,5,10,6,10,7,10,8,10,9,10,10,10,11,10,12,10,13,10,14,10,15,10,16,10,17,10,18,10,19,10,20,10,21,10,22,10,23,10,24,10,25,10,26,10,27,10,28,10,29,11,30,11,31,10,32,10,33,10,34,10,35,10,36,10,37,10,38,9,39,10,40,10,41,10,42,10,43,10,44,10,45,10,46,11,47,11,48,11,49,0,49,0,48,1,47,1,46,2,45,2,44,2,43,2,42,2,41,2,40,3,39,3,38,3,37,3,36,4,35,4,34,4,33,4,32,3,31,3,30,5,29,5,28,6,27,5,26,6,25,6,24,6,23,6,22,6,21,6,20,7,19,7,18,7,17,7,16,7,15,7,14,8,13,8,12,8,11,8,10,8,9,8,8,8,7,9,6,9,5,9,4,9,3,9,2,9,1,9,0,10,0],
    type: 'poly'
  };
		var fuifMarker = new google.maps.Marker({
			draggable: false,
			raiseOnDrag: false,
			icon: image,
			shadow: shadow,
			shape: shape,
			map: map,
			title: 'Was het nu \'80 \'90 of 2000?',
			position: fuifLocation,
			clickable:true
		  });
		
		var stfMarker = new google.maps.Marker({
			draggable: false,
			raiseOnDrag: false,
			icon: imagestf,
			shadow: shadowstf,
			shape: shapestf,
			map: map,
			title: 'Schevetorenfeesten',
			position: stfLocation,
			clickable:true
		  });


		var infoWindowFuif = new google.maps.InfoWindow();		
		var optionsfuif = {position: new google.maps.LatLng(39.943962, 3.891220),
   				title: 'Title',
   				content: '<div class="infowindow"><h3>Was het nu \'80 \'90 of \'2000</h3><p>Fuifterrein, ingang via de Rupelstraat.<br/>Kapelstraat is afgesloten.</p><div>'};
				
		var infoWindowStf = new google.maps.InfoWindow();		
		var optionsstf = {position: new google.maps.LatLng(39.943962, 3.891220),
   				title: 'Title',
   				content: '<div class="infowindow"><h3>Schevetorenfeesten</h3><p>In en rond het park en sporthal</p><div>'};
		
		google.maps.event.addListener(fuifMarker, 'click', function(){
				infoWindowStf.close();
				infoWindowFuif.setOptions(optionsfuif);
     			infoWindowFuif.open(map, fuifMarker);
			});
		
		google.maps.event.addListener(stfMarker, 'click', function(){
				infoWindowFuif.close();
				infoWindowStf.setOptions(optionsstf);
     			infoWindowStf.open(map, stfMarker);
			});
		
		google.maps.event.addListener(map, 'click', function(){
   			infoWindowFuif.close();
			infoWindowStf.close();
 			});

//start parkingshit
	var imageparking = new google.maps.MarkerImage(
	templateDir + '/img/gm_marker_parking.png',
	new google.maps.Size(30,30),
	new google.maps.Point(0,0),
	new google.maps.Point(15,30)
  );

var shadowparking = new google.maps.MarkerImage(
	templateDir + '/img/gm_marker_parking_shadow.png',
	new google.maps.Size(48,30),
	new google.maps.Point(0,0),
	new google.maps.Point(15,30)
  );

var shapeparking = {
	coord: [28,0,29,1,29,2,29,3,29,4,29,5,29,6,29,7,29,8,29,9,29,10,29,11,29,12,29,13,29,14,29,15,29,16,29,17,29,18,29,19,29,20,29,21,29,22,29,23,29,24,29,25,29,26,29,27,29,28,29,29,1,29,0,28,0,27,0,26,0,25,0,24,0,23,0,22,0,21,0,20,0,19,0,18,0,17,0,16,0,15,0,14,0,13,0,12,0,11,0,10,0,9,0,8,0,7,0,6,0,5,0,4,0,3,0,2,1,1,2,0,28,0],
	type: 'poly'
  };

var markers = [];
var iterator = 0;

var parkings = [
	new google.maps.LatLng(51.13032303785728,4.33634877204895),
	new google.maps.LatLng(51.122242859716636,4.329203367233276),
	new google.maps.LatLng(51.12175800407712,4.345425367355347)
	
  ];

  $(document).ready(function() {
	
	for (var i = 0; i < parkings.length; i++) {
		  setTimeout(function() {
			addMarker();
		  }, i * 600);
		}
		
  });
		
function addMarker() {
	markers.push(new google.maps.Marker({
	  position: parkings[iterator],
	  map: map,
	  clickable:false,
	  draggable: false,
	  raiseOnDrag: false,
	  animation: google.maps.Animation.DROP,
	  icon: imageparking,
	  shadow: shadowparking,
	  shape: shapeparking,	
	}));
	iterator++;
  }			
	  
	 function toggle(){
		 for (var k = 0; k < parkings.length; k++) {
			var marker = markers[k];
			if(typeof marker != 'undefined'){
					if(marker.getVisible() == true){
						marker.setVisible(false);
					}
					else{
						marker.setVisible(true);
					}
			 }
		 }
	 };
	 
	 $(document).ready(function() {	 
		 $(function(){
		   $('#toggleparking').change(function () {
			if ($(this).is(':checked')){
			 toggle();
			}
			else{
			  toggle();
			}
		   }).change();
		  });
		});
  
		
}
//einde initialize
	  

  


  
  
	 
  