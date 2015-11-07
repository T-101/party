function fetchParties() {
	$.post( 'ajax.php', { action: 'getParties'}, function(data) {
		printParties(data);
	});
}

function printParties(data) {
	for (var i = 0; i < data.length; i++) {
		var startDate = date2finstring(dateConv(data[i].startdate));
		var endDate = date2finstring(dateConv(data[i].enddate));
		var outstr = 	'<tr>'
		//		outstr +=		'<td>' + data[i].id + '</td>';
		outstr +=		'<td>' + data[i].name + '</td>';
		outstr +=		'<td>' + startDate + '</td>';
		//		outstr +=		'<td>' + endDate + '</td>';
		outstr +=		'<td>' + data[i].place;
		outstr +=		'<td><button type="button" id="removeParty" class="btn btn-xs btn-danger" value="'+data[i].name+'" name="' + data[i].id + '">X</button>';
		outstr +=		'</tr>'
$("#partyTable tr:last").after(outstr);
}
}

function removeParty( partyId ) {
	var r = confirm("Are you sure you want to delete " + partyId.name);
	if (r == true) {
		console.log("true")
		$.ajax({
			type: 'POST',
			url: 'ajax.php',
			data: {action: 'deleteParty', party: partyId.id },
			success: function(data) { window.location.href = ""; }
		});
	}
}

function addParty () {
	var partyObject = {name: $("#newPartyName").val(), partystart: $("#newPartyStart").val(), partyend: $("#newPartyEnd").val(), partyplace: $("#newPartyPlace").val() }
	console.log("Partyname: " + partyObject.name);
	console.log("Partystart: " + partyObject.partystart);
	console.log("Partyend: " + partyObject.partyend);
	console.log("Partyplace: " + partyObject.partyplace);

	

	if(partyObject.partyend.length == 0) {partyObject.partyend = partyObject.partystart}
		if(partyObject.partystart.length == 0) { alert("Party startdate cannot be empty")
	} else {
		$.ajax({
			type: 'POST',
			url: 'ajax.php',
			data: {
				action: 'addParty',
				partyname: partyObject.name,
				partystart: partyObject.partystart,
				partyend: partyObject.partyend,
				partyplace: partyObject.partyplace },
				success: function(data) { window.location.href = ""; },
				failure: function(data) { console.log('failure! data: ' + data) },
				error:   function(jqXHR, textStatus, errorThrown) {
					console.log("Error, status = " + textStatus + ", " +
						"error thrown: " + errorThrown
						);
				}
			});
	}
}

function checkValues() {
	if ($("#newPartyName").val().length > 0 && $("#newPartyPlace").val().length > 0) {
		$("#addPartySubmit").prop("disabled", false)
	} else {
		$("#addPartySubmit").prop("disabled", true)
	}
}

function date2finstring ( dateObject ) {
	//var days = ["Sun","Mon","Tues","Wed","Thu","Fri","Sat"];
	var months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
	//var day = days[dateObject.getDay()];
	var date = dateObject.getDate();
	var month = months[dateObject.getMonth()];
	var year = dateObject.getFullYear();
	//return day + ' ' + date + ' ' + month + ' ' + year;
	return date + ' ' + month + ' ' + year;
}

function dateConv (isoDate) {
	var datere = /(\d{4})-(\d{2})-(\d{2})/;
	var dateArray = datere.exec(isoDate);
	var dateObject = new Date(
		(+dateArray[1]),	// year
    	(+dateArray[2])-1,	// month starts at 0
    	(+dateArray[3])		// day
    	);
	return dateObject;
}

function onReady() {
	// Hide partyadd view
	$("#partyAdd").hide();
	$("#addPartySubmit").prop("disabled", true);
	// Get list of parties in database
	fetchParties();
	// Event to listen and remove party
	$("body").on('click', "#removeParty", function() {
		var partyObject = { name: $(this).attr("value"), id: $(this).attr("name") };
		console.log(partyObject.name);
		removeParty(partyObject);
	});
	// Event to listen newparty click
	$("#addPartyLink").click(function(){
		$("#partyList").hide();
		$("#partyAdd").show();
		$("#newPartyName").focus();
		$(".dateInput").datepicker({
			dateFormat: "yy-mm-dd",
			firstDay: 1
		});
	});
	// Event to submit a new party
	$("#addPartySubmit").click(function(){
		addParty();
	});
	// Event to check that all fields have values
	$(document).keyup(function(){checkValues()});
}

$(document).ready(onReady)