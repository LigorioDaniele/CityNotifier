
function selectTypes(typeGroup) {
    // Get a reference to the subtype select.
    var TypeSelect = document.getElementById("ceSub");
	
	// Create a two dimension array containing subtype for each group.
	var subtype = [["all","incidente","Malore","Ferito"],
				["all","Incidente", "Buca","Coda","Lavori in corso","Strada impraticabile"],
				["all","Incendio", "Tornado", "Neve", "Alluvione"],
				["all","Furto", "Attentato"],
				["all","Partita", "Manifestazione", "Concerto"]];
				
	if ((typeGroup >= 0) && (typeGroup <= subtype.length)) {
		TypeSelect.options.length = 0;

		// Index was in range, so access our array and create options.
		for (var i = 0; i < subtype[typeGroup - 1].length; i++) {
		   TypeSelect.options[TypeSelect.options.length] = new Option(subtype[typeGroup - 1][i], i);
		}

	}
}


function selectTypes1(typeGroup) {
    // Get a reference to the subtype select.
    var TypeSelect = document.getElementById("noSub");
	
	// Create a two dimension array containing subtype for each group.
	var subtype = [["incidente","Malore","Ferito"],
				["Incidente", "Buca","Coda","Lavori in corso","Strada impraticabile"],
				["Incendio", "Tornado", "Neve", "Alluvione"],
				["Furto", "Attentato"],
				["Partita", "Manifestazione", "Concerto"]];
				
	if ((typeGroup >= 0) && (typeGroup <= subtype.length)) {
		TypeSelect.options.length = 0;

		// Index was in range, so access our array and create options.
		for (var i = 0; i < subtype[typeGroup - 1].length; i++) {
		   TypeSelect.options[TypeSelect.options.length] = new Option(subtype[typeGroup - 1][i], i);
		}

	}
  
}

