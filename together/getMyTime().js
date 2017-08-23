function getMyTime()
{
  var time = new Date();
  var second = time.getSeconds();
  var minute = time.getMinutes();
  var hour = time.getHours();
  var day = time.getDate();
  var month_h = time.getMonth()+1;
  switch (month_h)
  {
	  case 1:
	    month = "leden";
		break;
  	  case 2:
	    month = "únor";
		break;
  	  case 3:
	    month = "březen";
		break;
  	  case 4:
	    month = "duben";
		break;
  	  case 5:
	    month = "květen";
		break;
  	  case 6:
	    month = "šerven";
		break;
  	  case 7:
	    month = "červenec";
		break;
  	  case 8:
	    month = "srpen";
		break;
  	  case 9:
	    month = "září";
		break;
  	  case 10:
	    month = "říjen";
		break;
  	  case 11:
	    month = "listopad";
		break;
  	  case 12:
	    month = "prosinec";
		break;
      default:
	    month = "undefined";
		break;
  }
  var year = time.getFullYear();
  
  var cas_ted = hour + ":" + minute + ":" + second + " | <strong>" + day + ". " + month + " " + year + "</strong>";
  return cas_ted;
}

function countdown( p_rok, p_mon, p_den, p_hod, p_min, p_sec, odsadit, text )
{
	var time = new Date();
	var t_second = time.getSeconds();
	var t_minute = time.getMinutes();
	var t_hour = time.getHours();
	var t_day = time.getDate();
	var t_month = time.getMonth()+1;
	var t_year = time.getYear()+1900;
	
	if ( p_rok < t_year || p_rok < 0 ||
		 p_mon > 12 || p_mon < 0 ||
		 p_den > 31 || p_den < 0 ||
		 p_hod > 23 || p_hod < 0 ||
		 p_min > 59 || p_min < 0 ||
		 p_sec > 59 || p_sec < 0 ) return false;
	
	var sec = p_sec - t_second;
	var mnt = p_min - t_minute;
	var hod = p_hod - t_hour;
	var day = p_den - t_day;
	var mon = p_mon - t_month;
	var year = p_rok - t_year;

	if ( sec < 0 ) { sec += 60; mnt--; }
	if ( mnt < 0 ) { mnt += 60; hod--; }
	if ( hod < 0 ) { hod += 24; day--; }
	if ( day < 0 ) { day += 30; mon--; } 
	if ( mon < 0 ) { mon += 12; year--; }
	if ( year < 0 || ( sec == 0 && mnt == 0 &&
					   hod == 0 && day == 0 &&
					   mon == 0 && year == 0 ) )
		return text += "Událost proběhla.";
	
	var countdown = "";
	if ( text ) countdown += text;
	if ( year ) countdown += year += year == 1 ? " rok " : ( year < 5 && year ? " roky " : " let " );
	if ( mon ) countdown += mon += mon == 1 ? " měsíc " : ( mon < 5 ? " měsíce " : " měsíců " );
	if ( day ) countdown += day += day == 1 ? " den " : ( day < 5 ? " dny " : " dní " );
	if ( odsadit ) countdown += "<br />";
	if ( hod ) countdown += hod += hod == 1 ? " hodina " : ( hod < 5 ? " hodiny " : " hodin " );
	if ( mnt ) countdown += mnt += mnt == 1 ? " minuta " : ( mnt < 5 ? " minuty " :  " minut " );
	if ( sec ) countdown += sec += sec == 1 ? " sekunda" : ( sec < 5 ? " sekundy " : " sekund" );
	
	return countdown;
}