<div class="p-3 row">
	<div class="col d-flex flex-shrink-1 justify-content-center">
		<button type="button" class="btn button-calender" onclick="--dm; calendar(dm, dj, 'calendar');"><i class="bi-arrow-left-circle button-icon"></i></button>
	</div>
	<div class="col d-flex flex-grow-1 justify-content-center align-items-end">
		<h5 id="headline"></h5>
	</div>
	<div class="col d-flex flex-shrink-1 justify-content-center ">
		<button type="button" class="btn button-calender" onclick="++dm; calendar(dm, dj, 'calendar');"><i class="bi-arrow-right-circle button-icon"></i></button>
	</div>
</div>
<div class="row">
	<div class="col d-flex justify-content-center">
		<table id="calendar" class="table text-white border"> </table>
	</div>
</div>
<div id="test"></div>
<script type="text/javascript">
	/* Kalender */
	const d = new Date();
	var dm = d.getMonth() + 1;
	var dj = d.getYear() + 1900;
	var monthArray;

	calendar(dm, dj, 'calendar');

	function deleteCalendar() {
		document.getElementById("calendar").innerHTML = "";
	}

	function calendar(Monat, Jahr, calendarId, eventArray) {
		/* Platzhalter für Eventteil */
		getMonthEventArray(Monat, Jahr); // Rückgabe: Alle Events für diesen Monat in einem Array

		deleteCalendar();
		if (Monat < 1) {
			Monat = 12;
			dm = 12;
			--Jahr;
			--dj;
		} else if (Monat > 12) {
			Monat = 1;
			dm = 1;
			++Jahr;
			++dj;
		}

		const Monatsname = new Array("Januar", "Februar", "März", "April", "Mai",
			"Juni", "Juli", "August", "September", "Oktober", "November", "Dezember");
		const Tag = new Array("Mo", "Di", "Mi", "Do", "Fr", "Sa", "So");
		// aktuelles Datum für die spätere Hervorhebung ermitteln
		const jetzt = new Date();
		let DieserTag = -1;
		if ((jetzt.getFullYear() == Jahr) && (jetzt.getMonth() + 1 == Monat))
			DieserTag = jetzt.getDate();
		// ermittle Wochentag des ersten Tags im Monat halte diese Information in Start fest
		// getDay liefert 0..6 für So..Sa. Wir möchten aber Mo=0 bis So=6, darum +6 und mod 7.
		const Zeit = new Date(Jahr, Monat - 1, 1);
		const Start = (Zeit.getDay() + 6) % 7;
		// die meisten Monate haben 31 Tage...
		let Stop = 31;
		// ...April (4), Juni (6), September (9) und November (11) haben nur 30 Tage...
		if (Monat == 4 || Monat == 6 || Monat == 9 || Monat == 11)
			--Stop;
		// ...und der Februar nur 28 Tage...
		if (Monat == 2) {
			Stop = Stop - 3;
			// ...außer in Schaltjahren
			if (Jahr % 4 == 0) Stop++;
			if (Jahr % 100 == 0) Stop--;
			if (Jahr % 400 == 0) Stop++;
		}
		const tabelle = document.getElementById(calendarId);
		if (!tabelle) return false;
		// schreibe Tabellenüberschrift
		const headline = document.getElementById("headline");
		headline.innerHTML = Monatsname[Monat - 1] + " " + Jahr;
		// schreibe Tabellenkopf
		const headRow = tabelle.insertRow(0);
		for (var i = 0; i < 7; i++) {
			var cell = headRow.insertCell(i);
			cell.innerHTML = Tag[i];
		}
		// ermittle Tag und schreibe Zeile
		let Tageszahl = 1;
		// Monate können 4 bis 6 Wochen berühren. Darum laufen, bis die Tageszahl hinter dem Monatsletzen liegt.
		for (let i = 0; Tageszahl <= Stop; i++) {
			let row = tabelle.insertRow(1 + i);
			for (let j = 0; j < 7; j++) {
				let cell = row.insertCell(j);
				// Zellen vor dem Start-Tag in der ersten Zeile und Zeilen nach dem Stop-Tag werden leer aufgefüllt
				if (((i == 0) && (j < Start)) || (Tageszahl > Stop)) {
					cell.innerHTML = ' ';
				} else {
					// normale Zellen werden mit der Tageszahl befüllt und mit der Klasse calendartag markiert
					cell.innerHTML = Tageszahl;
					cell.className = 'calendartag';
					// und der aktuelle Tag (today) wird noch einmal speziell mit der Klasse "today" markiert
					if (Tageszahl == DieserTag) {
						cell.className = cell.className + ' today rounded';
					}
					Tageszahl++;

					/* Variablen verfügbar: Tageszahl, Monat, Jahr */
					// Vergleiche alle Tageszahlen in diesem Monat mit unserem Array
					//console.log("Tag: "+Tageszahl+" | Monat: "+Monat+" | Jahr: "+Jahr);
				}
			}
		}
		return true;
	}

	// Calendar
	function getMonthEventArray(month, year) {
		var xhttp = new XMLHttpRequest();
		xhttp.onload = function() {
			parseToCalendar(JSON.parse(this.response));
		}
		xhttp.open("GET", "./content/calendar/events.php?f=monthArray&m=" + month + "&y=" + year);
		xhttp.send();
	}

	/* Langsame Funktion, da zwei verschachtelte for-Schleifen. Das geht bestimmt besser! */
	function parseToCalendar(monthArray) {
		console.log(monthArray);
		getAllDays = document.getElementsByClassName("calendartag");
		for (let i = 0; i < monthArray.length; i++) {
			for (let j = 0; j < getAllDays.length; j++) {
				if (getAllDays[j].textContent == monthArray[i]['eventDay']) {
					getAllDays[j].classList.add("text-danger");
					getAllDays[j].addEventListener("click", function() {
						eventDisplay = document.getElementById("eventDisplaySwitchable");
						eventId = monthArray[i]['id'];
						$.post("./system/functions.php", 
						{
							command: "getSpecificEvent",
							postId: eventId
						},
						function(data) {
							eventDisplay.innerHTML = "";
							eventArray = JSON.parse(data);
							showEvent(eventArray);
						});
					});
					getAllDays[j].style.cursor = "pointer";
				}
			}
		}
	}

function showEvent(eventArray) {
	var eventId = eventArray[0]["id"];
	var eventTitle = eventArray[0]["title"];
	var eventDesc = eventArray[0]["description"];
	var eventStart = eventArray[0]["start"];
	var eventEnd = eventArray[0]["end"];

	$.post("./system/functions.php", 
	{
		command: "getCategoryImage",
		postId: eventArray[0]["event_cat"]
	},
	function(data) {
		var htmlCode = "<div class ='col calendar-event mb-2 p-2 bg-lightdark rounded'>";
		htmlCode += "<div class='row d-flex align-content-center text-center bg-blackened m-1 p-1 rounded'>";
		htmlCode += "<h4>"+eventTitle+"</h4>";
		htmlCode += "</div><div class='row'><div class='col'>";
		htmlCode += data;
		htmlCode += "</div><div class='col flex-grow-1'><hr/><div class='row p-2'>";
		htmlCode +=	"Beginn: "+eventStart;
		htmlCode += "</div><div class='row p-2'>";
		htmlCode += eventDesc;
		htmlCode += "</div></div></div></div>";
		$("#eventDisplaySwitchable").append(htmlCode);
	});
}
</script>