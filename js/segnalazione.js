
function inviaNotifica(){
  var valore=$('#noType :selected').val();
  if (valore==0){
                    alert("devi selezionare una tipologia")
                }else{
                    
                    rimuoviMarker();
		var type=$('#noType :selected').text();
  
                
	type=type.toLowerCase();
	type=type.replace(" ","_");
	var subtype=$('#noSub :selected').text();
	subtype=subtype.toLowerCase();
	subtype=subtype.replace(" ","_");
        var via=$("#via").val();
        var indirizzo=$("#indirizzo").val();
	var lat=$("#noLat").val();
	var lng=$("#noLon").val();
	var descrizione=$("#noDes").val();
        var jsonData={"type":{"type":type,"subtype":subtype},"via":via,"indirizzo":indirizzo,"lat":lat,"lng":lng,"description":descrizione};
        $(document).ready(function() {
          $.ajax({
        type: "POST",
         url: "index.php/site/add",
        data: {jsonResponse:jsonData},
        success: 
          function(segnala){
           ricercaTabella();
          },
            error : function(xhr, status) {
//        alert('Spiacente, c\'è  stato un problema!');
    },
    complete : function(xhr, status) {
        alert('Richiesta fatta!');
    }
        });
	});	

                }
}
//da cordinate a indirizzo
function decodSegnalazione() {
  
     var lat = $("#noLat").val(); 
      var lon = $("#noLon").val(); 
	var latlng = new google.maps.LatLng(lat,lon);
	geocoder.geocode({'latLng': latlng}, function(results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
	   var indirizzo = {
               civico: results[0].address_components[0].long_name,
				via: results[0].address_components[1].long_name,
				citta: results[0].address_components[2].long_name
			};
	var address = indirizzo.via+" "+indirizzo.civico+", "+indirizzo.citta;
        var via = indirizzo.via;
	$('#indirizzo').val(address);
        $('#via').val(via);
    pos = new google.maps.LatLng(lat, lon);
                  map.setCenter(pos);
//                   if (cerchio != null) {
//                   cerchio.setMap(null);
//                   }
                   
    } else {
      console.log('Geocoder failed due to: ' + status);
    }
  });
}
function getCordinateSegnalazione(){
    var input_address = $("#indirizzo").val();  
            var geocoder = new google.maps.Geocoder();  
            geocoder.geocode( { address: input_address }, function(results, status) {  
                if (status == google.maps.GeocoderStatus.OK) {  
                     var lat = results[0].geometry.location.lat();  
                    $('#noLat').val(lat);  
                     var lon = results[0].geometry.location.lng();  
                     $('#noLon').val(lon); 
                 var pos = new google.maps.LatLng(lat, lon);
                  map.setCenter(pos);
                decodSegnalazione();// lo uso per modificare anche il campo via per il controllo distanza
                  }  
                else {  
                    alert("Indirizzo non trovato!");  
                    }  
                });  
      }
      
      function popolaStato(){
          var utente =$("#utenteLabel").text();
//alert(utente);
     
	
       $("#ceStato option[value='2']").remove();
          
              
          
      }