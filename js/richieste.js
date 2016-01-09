
function decod() {
    var lat = $("#ceLat").val();
    var lon = $("#ceLon").val();
    var latlng = new google.maps.LatLng(lat, lon);
    geocoder.geocode({'latLng': latlng}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            var indirizzo = {
                via: results[0].address_components[1].long_name,
                civico: results[0].address_components[0].long_name,
                citta: results[0].address_components[2].long_name
            };
            var address = indirizzo.via + " " + indirizzo.civico + ", " + indirizzo.citta;
            $('#ceAddress').val(address);
            pos = new google.maps.LatLng(lat, lon);
            map.setCenter(pos);
//            disegnaCerchio(pos, map);
        } else {
            console.log('Geocoder failed due to: ' + status);
        }
    });
}

function getCordinateRichieste() {

    var input_address = $("#ceAddress").val();
    var geocoder = new google.maps.Geocoder();
    geocoder.geocode({address: input_address}, function(results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            var lat = results[0].geometry.location.lat();
            $('#ceLat').val(lat);
            var lon = results[0].geometry.location.lng();
            $('#ceLon').val(lon);
            var pos = new google.maps.LatLng(lat, lon);
            map.setCenter(pos);
            //          disegnaCerchio(pos,map);
        }
        else {
            alert("Indirizzo non trovato!");
        }
    });
}
//function disegnaCerchio(pos,map){
//     
//     var raggios = $("#ceRaggio").val();  
//     var raggio = parseInt(raggios);
//     var proprieta = {
//      strokeColor: '#FF0000',
//      strokeOpacity: 0.5,
//      strokeWeight: 2,
//      fillColor: '#FF0000',
//      fillOpacity: 0.1,
//      radius: raggio,
//      map: map,
//     center: pos,
//      
//    };
//    // Add the circle for this city to the map.
//    cerchio = new google.maps.Circle(proprieta);
// }
// function cancellaCerchio(){
//      cerchio.setMap(null);
// }
function apriStato(id){
var jsonData={"id":id};
        $(document).ready(function() {
          $.ajax({
        type: "POST",
         url: "index.php/site/apriStato",
        data: {jsonResponse:jsonData},
        success: 
          function(apri){
            ricercaTabella();
          },
            error : function(xhr, status) {
    },
    complete : function(xhr, status) {
        alert('Richiesta fatta!');
    }
        });
	});	
}
function chiudiStato(id){
 var jsonData={"id":id};
        $(document).ready(function() {
          $.ajax({
        type: "POST",
         url: "index.php/site/chiudiStato",
        data: {jsonResponse:jsonData},
        success: 
          function(chiudi){
            ricercaTabella();
          },
            error : function(xhr, status) {
    },
    complete : function(xhr, status) {
        alert('Richiesta fatta!');
    }
        });
	});	
}

function archiviaStato(id) {
    //controllo che l'utente sia autorizzato all'archiviazione
    $.ajax({
        url: 'index.php/site/isAdmin',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            //prendo il risultato che mi indicherà la tipologia di utente
            var risposta = response;
            //se l'utente è autorizzato allora setto l'evento come archiviato
            if (risposta == 1) {
                var jsonData = {"id": id};
                $(document).ready(function() {
                    $.ajax({
                        type: "POST",
                        url: "index.php/site/archiviaStato",
                        data: {jsonResponse: jsonData},
                        success:
                                function(archivia) {
                                    ricercaTabella();
                                },
                        error: function(xhr, status) {
                        },
                        complete: function(xhr, status) {
                            alert('evento archiviato!');
                        }
                    });
                });
            } else {
                risposta = "not"
            }
        },
        error: function(xhr, status) {
            alert('Spiacente, c\'è  stato un problema!');
        },
        complete: function(xhr, status) {
            alert('Non hai i permessi per archiviare un evento');
        }
    });
}
 function showData(){
     var today = new Date();
     var dataFine =  today.getDate()+"/"+today.getMonth()+1+"/"+today.getFullYear();
     var dataInizio =  today.getDate()-1+"/"+today.getMonth()+1+"/"+today.getFullYear();
     var ora = today.getHours();
     var minuti = today.getMinutes();
         var datai = Date.parse(dataInizio);
	var dataf = Date.parse(dataFine);
 $('#ceData').val(dataInizio+"-"+dataFine+" "+ora+":"+minuti);
}
 function richiesta(){
        ricercaLocale();
      ricercaRemota();
}

function ricercaLocale() {
    rimuoviMarker();
    var cetype = $('#ceType :selected').text();
    cetype = cetype.toLowerCase();
    cetype = cetype.replace(" ", "_");
    var cesubtype = $('#ceSub :selected').text();
    cesubtype = cesubtype.toLowerCase();
    cesubtype = cesubtype.replace(" ", "_");
    if (cesubtype == "") {
        cesubtype = "all";
    }
    var celat = $('#ceLat').val();
    var celng = $('#ceLon').val();
    var ceradius = $('#ceRaggio').val();
    var ceTimemax = Math.round((new Date()).getTime() / 1000);
    var ceTimemin = ceTimemax - 86400;
    var cestatus = $('#ceStato :selected').text();
    $.ajax({
        url: 'index.php/site/richieste',
        data: {scope: "local", type: cetype, subtype: cesubtype, lat: celat, lng: celng, radius: ceradius, timemin: ceTimemin, timemax: ceTimemax, status: cestatus},
        type: 'GET',
        dataType: 'json',
        success: function(jsonData) {
            var request_time = jsonData.request_time;
            var result = jsonData.result;
            var from_server = jsonData.from_server;
            var events = jsonData.events;
            if (events!=0){
          for (var i = 0; i < events.length; i++) {
                var id = events[i].event_id;
                var type = events[i].type.type;
                var subtype = events[i].type.subtype;
                var description = events[i].description;
                 var start_time = events[i].start_time;
                var start=new Date(start_time*1000);
                var inizioString=start.toLocaleDateString()+" "+start.toLocaleTimeString(); 
                var Lati = events[i].locations[0].lat;
                var Lngi = events[i].locations[0].lng;
                   var reliability=events[i].reliability;
                var state = events[i].status;
                var reliability = events[i].reliability;
                var Nnotifications = events[i].Nnotifications
                creaMarker(id, Lati, Lngi, type, subtype, description, inizioString, state, reliability);
            }
        }
        },
        error: function(xhr, status) {
            alert('Spiacente, c\'è  stato un problema!');
        },
        complete: function(xhr, status) {
            alert('Richiesta fatta!');
        }
    });
}
function ricercaRemota() {
    rimuoviMarker();
    var cetype = $('#ceType :selected').text();
    cetype = cetype.toLowerCase();
    cetype = cetype.replace(" ", "_");
    var cesubtype = $('#ceSub :selected').text();
    cesubtype = cesubtype.toLowerCase();
    cesubtype = cesubtype.replace(" ", "_");
    if (cesubtype == "") {
        cesubtype = "all";
    }
    var celat = $('#ceLat').val();
    var celng = $('#ceLon').val();
    var ceradius = $('#ceRaggio').val();
    var ceTimemax = Math.round((new Date()).getTime() / 1000);
    var ceTimemin = ceTimemax - 86400;

    var cestatus = $('#ceStato :selected').text();
    $.ajax({
        url: 'index.php/site/richieste',
        data: {scope: "remote", type: cetype, subtype: cesubtype, lat: celat, lng: celng, radius: ceradius, timemin: ceTimemin, timemax: ceTimemax, status: cestatus},
        type: 'GET',
        dataType: 'json',
        success: function(jsonData) {
            var request_time = jsonData.request_time;
            var result = jsonData.result;
            var from_server = jsonData.from_server;
            var events = jsonData.events;
             if (events!=0){
            for (var i = 0; i < events.length; i++) {
                var id = events[i].event_id;
                var type = events[i].type.type;
                var subtype = events[i].type.subtype;
                var description = events[i].description;
                  var start_time = events[i].start_time;
                var start=new Date(start_time*1000);
                var inizioString=start.toLocaleDateString()+" "+start.toLocaleTimeString(); 
                var Lati = events[i].locations[0].lat;
                var Lngi = events[i].locations[0].lng;
                   var reliability=events[i].reliability;
                var state = events[i].status;
                var Nnotifications = events[i].Nnotifications
                creaMarker(id, Lati, Lngi, type, subtype, description, inizioString, state, reliability);
            }
            }
        },
        error: function(xhr, status) {
            alert('Spiacente, c\'è  stato un problema!');
        },
        complete: function(xhr, status) {
            alert('Richiesta fatta!');
        }
    });
}
function ricercaTabella() {
    rimuoviMarker();
    $("tbody").empty();

    var cetype = $('#ceType :selected').text();
    cetype = cetype.toLowerCase();
    cetype = cetype.replace(" ", "_");
    var cesubtype = $('#ceSub :selected').text();
    cesubtype = cesubtype.toLowerCase();
    cesubtype = cesubtype.replace(" ", "_");
    if (cesubtype == "") {
        cesubtype = "all";
    }
    var celat = $('#ceLat').val();
    var celng = $('#ceLon').val();
    var ceradius = $('#ceRaggio').val();
    var ceTimemax = Math.round((new Date()).getTime() / 1000);
    var ceTimemin = ceTimemax - 86400;
    var cestatus = $('#ceStato :selected').text();
    $.ajax({
        url: 'index.php/site/richiesteTabella',
        data: {scope: "local", type: cetype, subtype: cesubtype, lat: celat, lng: celng, radius: ceradius, timemin: ceTimemin, timemax: ceTimemax, status: cestatus},
        type: 'GET',
        dataType: 'json',
        success: function(jsonData) {
            var request_time = jsonData.request_time;
            var result = jsonData.result;
            var from_server = jsonData.from_server;
            var events = jsonData.events;
            for (var i = 0; i < events.length; i++) {
                var id = events[i].event_id;
                var type = events[i].type.type;
                var subtype = events[i].type.subtype;
                var description = events[i].description;
                var start_time = events[i].start_time;
                var start=new Date(start_time*1000);
                var inizioString=start.toLocaleDateString()+" "+start.toLocaleTimeString(); 
                var reliability=events[i].reliability;
                var Lati = events[i].locations[0].lat;
                var Lngi = events[i].locations[0].lng;
                var state = events[i].status;
                var Nnotifications = events[i].Nnotifications;
                $("tbody").append("<tr><td>" + id + "</td><td>" + type + "</td><td>" + subtype + "</td><td>" + inizioString + "</td><td>" + state + "</td><$$</td></tr>");
                creaMarker(id, Lati, Lngi, type, subtype, description, inizioString, state, reliability);
            }
        },
        error: function(xhr, status) {
            alert('Spiacente, c\'è  stato un problema!');
        },
        complete: function(xhr, status) {
            alert('Richiesta fatta!');
        }
    });
}