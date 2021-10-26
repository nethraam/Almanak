<?php
function translate ($t) {
	
	switch ($t) {
	
	case "monday": $tt = "lundi"; break; 
	case "tuesday": $tt = "mardi"; break; 
	case "wednesday": $tt = "mercredi"; break; 
	case "thursday": $tt = "jeudi"; break; 
	case "friday": $tt = "vendredi"; break; 
	case "saturday": $tt = "samedi"; break; 
	case "sunday": $tt = "dimanche"; break; 
	
	case "january": $tt = "janvier"; break; 
	case "february": $tt = "février"; break; 
	case "march": $tt = "mars"; break; 
	case "april": $tt = "avril"; break; 
	case "may": $tt = "mai"; break; 
	case "june": $tt = "juin"; break; 
	case "july": $tt = "juillet"; break; 
	case "august": $tt = "aoüt"; break; 
	case "september": $tt = "septembre"; break; 
	case "october": $tt = "octobre"; break; 
	case "november": $tt = "novembre"; break; 
	case "december": $tt = "décembre"; break; 
	
	case "title": $tt = "titre"; break;
	case "description": $tt = "description"; break;
	
	case "year view": $tt = "vue de l'année"; break;
	case "month view": $tt = "vue du mois"; break;
	case "add event": $tt = "ajouter événement"; break;
	case "users": $tt = "utilisateurs"; break;
	case "settings": $tt = "paramètres"; break;
	case "logout": $tt = "se déconnecter"; break;

	
	default: $tt=$t;
	}
	return $tt;
}


?>