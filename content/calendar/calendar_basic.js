	/* Kalender */
	var dm = d.getMonth() + 1;
	var dj = d.getYear() + 1900;
	var monthArray;

	calendar(dm, dj, 'calendar');

	function deleteCalendar() {
		document.getElementById("calendar").innerHTML = "";
	}

	function calendar(Monat, Jahr, calendarId) {
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
						cell.className = cell.className + ' today';
					}
					Tageszahl++;
				}
			}
		}
		return true;
	}

	// Calendar
	function getMonthEventArray(month, year) {
		$.post("./content/calendar/calendar_functions.php",
		{
			command: "getMonthArray",
			postMonth: month,
			postYear: year
		},
		function(data) {
			parseToCalendar(JSON.parse(data));
		});
	}

	/* Langsame Funktion, da zwei verschachtelte for-Schleifen. Das geht bestimmt besser! */
	function parseToCalendar(monthArray) {
		getAllDays = document.getElementsByClassName("calendartag");
		for (let i = 0; i < monthArray.length; i++) {
			for (let j = 0; j < getAllDays.length; j++) {
				if (getAllDays[j].textContent == monthArray[i]['eventDay']) {
					getAllDays[j].classList.add("text-danger");
					getAllDays[j].addEventListener("click", function() {
						/* Suche Element mit ID -> lösche ID -> setze ID auf das angeklickte Element */
						var oldSelected = document.getElementById("selected");
						if(oldSelected != null) {
							oldSelected.id = "";
						}
						getAllDays[j].id = "selected";
						eventDisplay = document.getElementById("eventDisplaySwitchable");
						eventId = monthArray[i]['id'];
						$.post("./content/calendar/calendar_functions.php", 
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
					getAllDays[j].classList.add("eventday");
				}
			}
		}
	}

function showEvent(eventArray) {
	var eventId = eventArray[0]["id"];

	displayEvent = "./content/calendar/eventorganizer/displayEvent.php?eventId="+eventId;
	$("#eventDisplaySwitchable").load(displayEvent);
}