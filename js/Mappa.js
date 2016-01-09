var map;
var markers =[];
 var   lat=44.495771;
  var lon=11.344744;
var geocoder;
function initialize() {
    
  var mapOptions = {
    mapTypeId : google.maps.MapTypeId.ROADMAP,
    center : new google.maps.LatLng(44.495771, 11.344744),
        zoom: 16
    
  };
  
  map = new google.maps.Map(document.getElementById('map-canvas'),
      mapOptions);
  
    navigator.geolocation.getCurrentPosition(function(position) {
         lat = position.coords.latitude;
         lon = position.coords.longitude;
 
//          var   lat=44.495771;
//             var lon=11.344744;
  
         var pos = new google.maps.LatLng(lat, lon);
     
        
     $('#noLat').val(lat);
        $('#noLon').val(lon);
      $('#ceLat').val(lat);
        $('#ceLon').val(lon);
        var marker = new google.maps.Marker({
      position: pos,
      map: map
    });
    
        var infowindow = new google.maps.InfoWindow({
        map: map,
        position: pos,
        content: 'Sei qui.'
        });
        infowindow.open(map, marker);

    setTimeout(function () { infowindow.close(); }, 5000);

      map.setCenter(pos);
   
   geocoder = new google.maps.Geocoder();
    })
  
  }

function creaMarker(id, Lati, Lngi, type, subtype, description, inizioString, state, reliability) {
      if (reliability <= 0.3) {
                            reliability = "bassa";
                        } else if (reliability >= 0.6) {
                            reliability = "alta";
                        }else if(reliability >0.3 & reliability <0.6 ){
                             reliability = "media";
                        }
		if (subtype == "incidente") {
			var image = {
				url : 'marker/incidente.png'
			};
		} else if (subtype =="buca") {
			var image = {
				url : 'marker/buca.png'
			};
		} else if (subtype == "coda") {
			var image = {
				url : 'marker/coda.png'
			};
		} else if (subtype == "lavori_in_corso") {
			var image = {
				url : 'marker/lavori.png'
			};
		} else if (subtype =="strada_impraticabile") {
			var image = {
				url : 'marker/stradaImpraticabile.png'
			};
		}else if (subtype =="incidente") {
			var image = {
				url : 'marker/incidente.png'
			};
		}else if (subtype =="malore") {
			var image = {
				url : 'marker/malore.png'
			};
		}else if (subtype =="ferito") {
			var image = {
				url : 'marker/ferito.png'
			};
		}else if (subtype =="furto") {
			var image = {
				url : 'marker/furto.png'
			};
		}else if (subtype =="attentato") {
			var image = {
				url : 'marker/attentato.png'
			};
		}else if (type =="problemi_ambientali") {
			var image = {
				url : 'marker/ambiente.png'
			};
		}else if (subtype =="partita") {
			var image = {
				url : 'marker/partita.png'
			};
		}else if (subtype =="manifestazione") {
			var image = {
				url : 'marker/manifestazione.png'
			};
		}else if (subtype =="concerto") {
			var image = {
				url : 'marker/concerto.png'
			};
		}
               

	
     var pos = new google.maps.LatLng(Lati,Lngi);
     //creo il marker
                  var m = new google.maps.Marker({
			position : pos,
			map : map,
                        icon : image,
			animation : google.maps.Animation.DROP,
                        title : id
                    });
                    markers.push(m);
                    //inserisco le info dentro la infowindow
                    
       var Id='<label><strong>Id:</strong>'+ id+'</label>';
	var Tipo = '<label><strong>Tipo: </strong>'+ type+'</label>';
	var Sottotipo = '<label><strong>Sottotipo: </strong>'+ subtype+'</label>';
	var Descrizione = '<label><strong>Descrizione: </strong></label>';
	for(var i=0;i<description.length;i++){	    	 
	   	if(i==5){
	   		break;
	   	} 
		if(description[i]!=""){	    		
	   		 Descrizione=Descrizione+'<br><label>' + description[i]+ '</label>';
	   	 }
    }

	
//    var tFresc = new Date(freschezza*1000);
//	var tFrescString=tFresc.toLocaleDateString()+"<br>"+tFresc.toLocaleTimeString(); 
	var TempoInizio = '<label><strong>Data: </strong></label>'+'<label>' + inizioString+'</label>';
//	var aFreschezza = '<label><strong>Freschezza: </strong></label>'+'<label>' + tFrescString+'</label>';
	var Stato = '<label><strong>Stato: </strong>' + state+'</label>';
	 var Reliability = '<label><strong>Affidabilità: </strong>' + reliability+'</label>';
	


	var c= '<div class="info_marker">'+Id + 
                '<br>' +Tipo+ 
                '<br>' +Sottotipo+ 
                '<br>' +Descrizione+ 
                '<br>' +TempoInizio+ 
                '<br>'+Stato+
                '<br>'+Reliability+
               
                 '<button type="button" onclick="apriStato('+id+')" class="btn btn-success">Open</button>'+
                '<button type="button" onclick="chiudiStato('+id+')"class="btn btn-danger">Close</button>'+
                '<button type="button" onclick="archiviaStato('+id+')"class="btn btn-info">archivied</button>'+'</div></div>';
        
  
      
	var infoWindow = new google.maps.InfoWindow({
            zoom:10,
		content :  c,
		maxWidth: 350
	});
       

	//acchiappo evento click sul marker e imposto un timer sulla infowindow
	google.maps.event.addListener(m, 'click', function() {
		infoWindow.open(map, m);
//		 setTimeout(function () { infoWindow.close(); }, 20000);
		
	});
		
       
}

function rimuoviMarker() {
	if (markers.length>0) {
        for (i=0; i < markers.length; i++) {
            markers[i].setMap(null);
        }
    markers.length = 0;
    }
   
    return true;
}




//google.maps.event.addDomListener(window, 'load', initialize);