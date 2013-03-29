// JavaScript Document
jQuery(document).ready(function(){
		var $_GET = {};

		document.location.search.replace(/\??(?:([^=]+)=([^&]*)&?)/g, function () {
			function decode(s) {
				return decodeURIComponent(s.split("+").join(" "));
			}
		
			$_GET[decode(arguments[1])] = decode(arguments[2]);
		});
		
		//document.write($_GET["toon"]);


       /*******
	   HIDE DIVS
	   ********/
        //Hide div w/id leiding, verhuur,
       var showed = false;
	   //kalender
	   if ($_GET["toon"] != "datum"){
		   //
		   //document.write("toon niet")
		   jQuery("#kalender").css("display","none");
		   
	   }else{
		   showed = true;
		   jQuery("#kalender").show("fast");
		   //document.write($_GET["toon"]);
	   }
	   
	   //leiding
	   if ($_GET["toon"] != "leiding"){
		   //
		   //document.write("toon niet")
		   jQuery("#leiding").css("display","none");
		   
	   }else{
		   showed = true;
		   jQuery("#leiding").show("fast");
		   //document.write($_GET["toon"]);
	   }
	   
	    //muziekkapel
	   if ($_GET["toon"] != "muziekkapel"){
		   //
		   //document.write("toon niet")
		   jQuery("#muziekkapel").css("display","none");
		   
	   }else{
		   showed = true;
		   jQuery("#muziekkapel").show("fast");
		   //document.write($_GET["toon"]);
	   }

	  //verhuur, extra div wordt getoond
	   	   if ($_GET["toon"] != "verhuur"){
		   //
		   //document.write("toon niet")
		   jQuery("#verhuur").css("display","none");
		   
	   }else{
		   showed = true;
		   jQuery("#verhuur").show("fast");
		   //document.write($_GET["toon"]);
	   }
	   
	   //garage
	    if ($_GET["toon"] != "garage"){
		   //
		   //document.write("toon niet")
		   jQuery("#garage").css("display","none");
		   
	   }else{
		   showed = true;
		   jQuery("#garage").show("fast");
		   //document.write($_GET["toon"]);
	   }
	   
	   //tenten
	    if ($_GET["toon"] != "tenten"){
		   //
		   //document.write("toon niet")
		   jQuery("#tenten").css("display","none");
		   
	   }else{
		   showed = true;
		   jQuery("#tenten").show("fast");
		   //document.write($_GET["toon"]);
	   }
	   
	   //Lokalen
	    if ($_GET["toon"] != "lokalen"){
		   //
		   //document.write("toon niet")
		   jQuery("#lokalen").css("display","none");
		   
	   }else{
		   showed = true;
		   jQuery("#lokalen").show("fast");
		   //document.write($_GET["toon"]);
	   }
	   
	   //andere
	   	    if ($_GET["toon"] != "andere"){
		   //
		   //document.write("toon niet")
		   jQuery("#andere").css("display","none");
		   
	   }else{
		   showed = true;
		   jQuery("#andere").show("fast");
		   //document.write($_GET["toon"]);
	   }
	   if ($_GET["toon"] != "toevoegen"){
		   //
		   //document.write("toon niet")
		   jQuery("#toevoegen").css("display","none");
		   
	   }else{
		   showed = true;
		   jQuery("#toevoegen").show("fast");
		   //document.write($_GET["toon"]);
	   }

	   /*******
	   Klik op verhuur
	   ********/
	  jQuery("#show_verhuur").click(function(){
      
        // If checked
        if (jQuery("#show_verhuur").is(":checked"))
        {
            //show the hidden div
			jQuery("#leiding").hide("fast");
            jQuery("#verhuur").show("fast");
        }
        else
        {     
            //otherwise, hide it
            jQuery("#verhuur").hide("fast");
        }
      });
	   
       /*******
	   KLik op leiding
	   ********/
	   jQuery("#show_leiding").click(function(){
       

        // If checked
        if (jQuery("#show_leiding").is(":checked"))
        {
            //show the hidden div
			jQuery("#verhuur").hide("fast");
            jQuery("#leiding").show("fast");
        }
        else
        {     
            //otherwise, hide it
            jQuery("#leiding").hide("fast");
        }
      });
   	   /*******
	   Klik op info
	   ********/
   	     jQuery("#show_info").click(function(){
       
        // If checked
        if (jQuery("#show_info").is(":checked"))
        {
            //show the hidden div
			jQuery("#leiding").hide("fast");
			jQuery("#verhuur").hide("fast");
			jQuery("#site").hide("fast");
            jQuery("#info").show("fast");
        }
        else
        {     
            //otherwise, hide it
            jQuery("#info").hide("fast");
        }
      });
	   /*******
	   Klik op site
	   ********/
		jQuery("#show_site").click(function(){
       
        // If checked
        if (jQuery("#show_site").is(":checked"))
        {
            //show the hidden div
			jQuery("#leiding").hide("fast");
			jQuery("#verhuur").hide("fast");
			jQuery("#info").hide("fast");
            jQuery("#site").show("fast");
        }
        else
        {     
            //otherwise, hide it
            jQuery("#site").hide("fast");
        }
      });
		/*******
	   Klik op muziekkapel
	   ********/
		jQuery("#show_muziekkapel").click(function(){
       
        // If checked
        if (jQuery("#show_muziekkapel").is(":checked"))
        {
            //show the hidden div
			jQuery("#leiding").hide("fast");
			jQuery("#verhuur").hide("fast");
			jQuery("#info").hide("fast");
        }
        else
        {     
            //otherwise, hide it
            jQuery("#muziekkapel").hide("fast");
        }
      });
		
		jQuery("#show_kalender").click(function(){
		if (showed ==false){
			jQuery("#kalender").show("fast");
			showed = true;
		}else{
		
		jQuery("#kalender").hide("fast");
		showed = false;
		}
		
		});
		
		/**************VERHUURPAGINA********************/
		/*******
	   Klik op garage
	   ********/
	   var showedg = false;
	   
   	     jQuery(".show_garage").toggle(function() {
       			//show the hidden div
				jQuery("#garage").toggle("fast");
				jQuery("#tenten").hide("fast");
				jQuery("#lokalen").hide("fast");
				jQuery("#andere").hide("fast");
				//showedg = true;
			}, function(){
				jQuery("#garage").toggle("fast");
				jQuery("#tenten").hide("fast");
				jQuery("#lokalen").hide("fast");
				jQuery("#andere").hide("fast");
				//showed = false;
			});
		 
		/*******
		Klik op tenten
		********/
   	     jQuery(".show_tenten").toggle(function(){
            	//show the hidden div
				jQuery("#garage").hide("fast");
				jQuery("#tenten").toggle("fast");
				jQuery("#lokalen").hide("fast");
				jQuery("#andere").hide("fast");
			}, function(){
				jQuery("#garage").hide("fast");
				jQuery("#tenten").toggle("fast");
				jQuery("#lokalen").hide("fast");
				jQuery("#andere").hide("fast");
				//showed = false;
			});	 
		 
		 /*******
	   Klik op lokalen
	   ********/
   	     jQuery(".show_lokalen").toggle(function(){ 
				//show the hidden div
				jQuery("#garage").hide("fast");
				jQuery("#tenten").hide("fast");
				jQuery("#lokalen").toggle("fast");
				jQuery("#andere").hide("fast");
				//showed=true;
			}, function(){
				jQuery("#garage").hide("fast");
				jQuery("#tenten").hide("fast");
				jQuery("#lokalen").toggle("fast");
				jQuery("#andere").hide("fast");
				//showed = false;
			});
	 
		 /*******
	   Klik op andere
	   ********/
   	     jQuery(".show_andere").click(function(){
       
        // If checked
       		if (showed == false){ 
				//show the hidden div
				jQuery("#garage").toggle("fast");
				jQuery("#tenten").toggle("fast");
				jQuery("#lokalen").toggle("fast");
				jQuery("#andere").toggle("fast");
        	}else{
				jQuery("#andere").toggle("fast");
				showed = false;
			} 
      });
		 
		 
		  /*******
	   Klik op andere
	   ********/
   	     jQuery(".show_toevoegen").click(function(){
       
        // If checked
        
            //show the hidden div
			jQuery("#toevoegen").show("fast");
        
      });
											
						  
    });
