<?php
function translate ($t) {
	
	switch ($t) {
	
	case "monday": $tt = "maandag"; break; 
	case "tuesday": $tt = "dinsdag"; break; 
	case "wednesday": $tt = "woensdag"; break; 
	case "thursday": $tt = "donderdag"; break; 
	case "friday": $tt = "vrijdag"; break; 
	case "saturday": $tt = "zaterdag"; break; 
	case "sunday": $tt = "zondag"; break; 
	
	case "january": $tt = "januari"; break; 
	case "february": $tt = "februari"; break; 
	case "march": $tt = "maart"; break; 
	case "april": $tt = "april"; break; 
	case "may": $tt = "mei"; break; 
	case "june": $tt = "juni"; break; 
	case "july": $tt = "juli"; break; 
	case "august": $tt = "augustus"; break; 
	case "september": $tt = "september"; break; 
	case "october": $tt = "oktober"; break; 
	case "november": $tt = "november"; break; 
	case "december": $tt = "december"; break; 
	
	case "first": $tt = "eerste"; break; 
	case "second": $tt = "tweede"; break; 
	case "third": $tt = "derde"; break; 
	case "fourth": $tt = "vierde"; break; 
	case "last": $tt = "laatste"; break; 
	
	case "title": $tt = "titel"; break;
	case "description": $tt = "omschrijving"; break;
	
	case "year view": $tt = "jaarweergave"; break;
	case "month view": $tt = "maandweergave"; break;
	case "list view": $tt = "lijstweergave"; break;
	case "add event": $tt = "evenement toevoegen"; break;
	case "users": $tt = "gebruikers"; break;
	case "user": $tt = "gebruiker"; break;
	case "settings": $tt = "instellingen"; break;
	case "logout": $tt = "uitloggen"; break;
	case "logged in as": $tt = "ingelogd als"; break;
	case "username": $tt = "gebruikersnaam"; break;
	case "password": $tt = "wachtwoord"; break;
	case "confirm password": $tt = "bevestig wachtwoord"; break;
	case "submit": $tt = "verzenden"; break;
	case "language": $tt = "taal"; break;
	case "starting year of the calendar": $tt = "jaar waarin de kalender start"; break;
	case "future years of the calendar": $tt = "aantal jaren zichtbaar vanaf huidig jaar"; break;
	case "add user": $tt = "gebruiker toevoegen"; break;
	case "update user": $tt = "gebruiker gegevens wijzigen"; break;
	case "delete user": $tt = "gebruiker verwijderen"; break;
	case "user group": $tt = "gebruiker type"; break;
	case "your data is updated": $tt = "de gegevens zijn aangepast"; break;
	case "the data has been added": $tt = "de gegevens zijn toegevoegd"; break;
	case "Sorry, you are not allowed to access this page.": $tt = "sorry, je heb niet de juiste rechten om deze pagina te bekijken"; break;
	case "close": $tt = "sluit"; break;
	case "change event": $tt = "activiteit aanpassen"; break;
	case "delete event": $tt = "activiteit verwijderen"; break;
	case "date": $tt = "datum"; break;
	case "starttime": $tt = "beginuur"; break;
	case "endtime": $tt = "einduur"; break;
	case "please enter a username and a password": $tt = "gelieve gebruikersnaam en wachtwoord in te vullen"; break;
	case "please enter a title": $tt = "gelieve een titel in te vullen"; break;
	case "you entered two different passwords": $tt = "bevestiging wachtoord onjuist"; break;
	case "go to nexy year": $tt = "datum"; break;
	case "goto previous year": $tt = "ga naar vorig jaar"; break;
	case "goto next year": $tt = "ga naar volgend jaar"; break;
	case "goto previous month": $tt = "ga naar vorige maand"; break;
	case "goto next month": $tt = "ga naar volgende maand"; break;
	case "add event on": $tt = "voeg evenement toe op"; break;
	case "starttime hours": $tt = "begintijd uren"; break;
	case "starttime minutes": $tt = "begintijd minuten"; break;
	case "endtime hours": $tt = "eindtijd uren"; break;
	case "endtime minutes": $tt = "eindtijd minuten"; break;
	case "wrong username or password": $tt = "gebruikersnaam of wachtwoord onjuist"; break;
	case "login": $tt = "inloggen"; break;
	case "from": $tt = "vanaf"; break;
	case "to": $tt = "tot"; break;
	case "today": $tt = "vandaag"; break;
	case "there are no activities in" : $tt = "er zijn geen activiteiten in"; break;
	case 'Are you sure you want to delete this activity?' : $tt= 'Weet je zeker dat je deze activiteit wilt verwijderen?'; break;
	case 'Are you sure you want to delete this user?' : $tt= 'Weet je zeker dat je deze gebruiker wilt verwijderen?'; break;
	case "delete": $tt = "verwijderen"; break;
	case "cancel": $tt = "annuleren"; break;
	case "the activity has been deleted!"; $tt="de activiteit is verwijderd!"; break; 
	case "username already exist, please choose another one!"; $tt="gebruikersnaam bestaat al, gelieve een andere te kiezen!"; break;
	case "nth weekday of month": $tt = "dag van de maand"; break; 
	case "before easter": $tt = "voor pasen"; break; 
	case "after easter": $tt = "na pasen"; break; 
	case "select holiday type": $tt = "kies feestdag type"; break;
	case "add holiday": $tt = "feestdag toevoegen"; break;
	case "days before easter": $tt = "dagen voor pasen"; break;
	case "days after easter": $tt = "dagen na pasen"; break;
	case "of": $tt = "van"; break;
	case "holidays": $tt = "feestdagen"; break;
	case "general": $tt = "algemeen"; break;
	case "the data has been updated": $tt = "de gegevens zijn aangepast"; break;
	case "update event": $tt = "evenement updaten"; break;
	case "save and copy": $tt = "opslaan en kopiëren"; break;
	case "more options": $tt = "meer opties"; break;
	case "save": $tt = "opslaan"; break;
	case "repeat": $tt = "herhaal"; break;
	case "times": $tt = "maal"; break;
	case "repeat every": $tt = "herhaal elke"; break;
	case "days": $tt = "dagen"; break;
	
	
	
	default: $tt=$t;
	}
	return $tt;
}


?>