// JavaScript Document

function showItems( where, table, limit, platnost ){
	
	platnost = platnost == 0 ? 0 : 1;
	var sortBy = document.getElementsByClassName( 'changeSort' )[0].value;
	var desc = document.getElementsByClassName( 'changeSort' )[1].value;
	var month = document.getElementsByClassName( 'changeSort' )[2].value;
	var pozn = document.getElementsByClassName( 'changeSort' )[3].value;
	var year = document.getElementsByClassName( 'changeSortBtn' )[0].value;
	var pattern = document.getElementsByClassName( 'changeSortBtn' )[1].value;
	if ( /^  +/.test(pattern) ) {
		alert( 'řetězec začínal dvěma mezarama!' );
		document.getElementsByClassName( 'changeSortBtn' )[1].value = '';
		pattern = '';
	}
	var patternArray = pattern.split( '  ' );
	var ANDY = [];
	var ORY = [];
	
	var prikaz = 'SELECT * FROM '+table+' WHERE platnost = '+platnost+' AND vyber=0';
	if ( month != '' ) prikaz += ' AND datum LIKE \'%25-'+month+'-%25\'';
	if ( pozn != '' ) prikaz += ' AND pozn = \''+pozn+'\'';
	if ( year != '' ) prikaz += ' AND datum LIKE "%25'+year+'-%25"';
	if ( patternArray.length != 1 || ( patternArray[0] != '' && patternArray[0] != '!') ) {
		
		for ( var i = 0; i < patternArray.length; i++ ) {
			if ( patternArray[i] == '' ) continue;
			if ( patternArray[i][0] != '!' ) { // positive pattern
				ORY[ORY.length] = patternArray[i];
			}
			else if ( patternArray[i][0] == '!' && patternArray[i].length > 1 ) { // ! - negative pattern
				ANDY[ANDY.length] = patternArray[i].substr( 1, patternArray[i].length );
			}
		}
		
		for ( var i = 0; i < ORY.length; i++ ) {
			prikaz += i != 0 ? ' OR' : ' AND ( ';
			prikaz += ' ( nazev LIKE "%25'+ORY[i]+'%25" OR popis LIKE "%25'+ORY[i]+'%25" OR pozn LIKE "%25'+ORY[i]+'%25" OR typ LIKE "%25'+ORY[i]+'%25" )';
			if ( i+1 == ORY.length ) prikaz += ' )';
		}
		for ( i = 0; i < ANDY.length; i++ )
			prikaz += ' AND ( nazev NOT LIKE "%25'+ANDY[i]+'%25" AND popis NOT LIKE "%25'+ANDY[i]+'%25" AND pozn NOT LIKE "%25'+ANDY[i]+'%25" AND typ NOT LIKE "%25'+ANDY[i]+'%25" )';
	}
	prikaz += ' ORDER BY '+sortBy+' '+desc;
	prikaz += ' LIMIT 0, '+limit;
	
	//prikaz = prikaz.replace( /'/g, '"' );
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	} else {
		// code for IE6, IE5
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById( where ).innerHTML = xmlhttp.responseText;
		}
	};
	xmlhttp.open( "POST", "together/scripty/showItems.php", true );
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( "prikaz="+prikaz+"&table="+table+"&where="+where+"&platnost="+platnost );
};

function showStatus( where, who ){
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttpStat = new XMLHttpRequest();
	} else {
		// code for IE6, IE5
		xmlhttpStat = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttpStat.onreadystatechange = function() {
		if (xmlhttpStat.readyState == 4 && xmlhttpStat.status == 200) {
			document.getElementById( where ).innerHTML = xmlhttpStat.responseText;
		}
	};
	xmlhttpStat.open( "POST", "together/scripty/showStatus.php", true );
	xmlhttpStat.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttpStat.send( "where="+where+"&utrata_check_state_table=utrata_check_state_"+who+"&utrata_table=utrata_"+who+"&utrata_akt_hodnota_table=utrata_akt_hodnota_"+who+"&who="+who );
};


function updateItem( id, table, where ){	
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		var xmlhttp = new XMLHttpRequest();
	} else {
		// code for IE6, IE5
		var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			showItems( where, table, 300 );
		}
	};
	xmlhttp.open( "POST", "together/scripty/updateItem.php", true );
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( "id="+id+"&table="+table );
};
function deleteItem( id, table, where, platnost ){
	var enter = confirm( 'Opravdu chceš smazat?' );
	if ( !enter ) return;
	
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		var xmlhttp = new XMLHttpRequest();
	} else {
		// code for IE6, IE5
		var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			showItems( where, table, 300, platnost );
		}
	};
	xmlhttp.open( "POST", "together/scripty/deleteItem.php", true );
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( "id="+id+"&table="+table );
};

function updateState( typ, table, whereAfter, value, who ){
	xmlhttpU = new XMLHttpRequest();
	xmlhttpU.onreadystatechange = function() {
		if (xmlhttpU.readyState == 4 && xmlhttpU.status == 200) {
			showStatus( whereAfter, who );
		}
	};
	xmlhttpU.open( "POST", "together/scripty/updateState.php", true );
	xmlhttpU.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttpU.send( "typ=" + typ + "&table=" + table + "&value=" + value );
};

function clearSearch( name, x )
{
	x = x == 0 ? 0 : 1;
	document.getElementsByClassName( 'changeSort' )[0].selectedIndex = 1;
	document.getElementsByClassName( 'changeSort' )[1].selectedIndex = 1;
	document.getElementsByClassName( 'changeSort' )[2].selectedIndex = 0;
	document.getElementsByClassName( 'changeSort' )[3].selectedIndex = 0;
	document.getElementsByClassName( 'changeSortBtn' )[0].value = '';
	document.getElementsByClassName( 'changeSortBtn' )[1].value = '';
	
	showItems( 'hereTable', 'utrata_'+name, LIMIT, x );
}

function send_ucty( where, who )
{
	var month = document.getElementById( 'mesic_send' ).value;
	var year = document.getElementById( 'rok_send' ).value;
	if ( month == '' || year == 'rok' || parseInt(year) != year || year < 2015 )
	{
		return;
	}
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		var xmlhttpMother = new XMLHttpRequest();
	} else {
		// code for IE6, IE5
		var xmlhttpMother = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttpMother.onreadystatechange = function() {
		if ( xmlhttpMother.readyState == 4 && xmlhttpMother.status == 200 ) {
			document.getElementById( where ).innerHTML = xmlhttpMother.responseText;
		}
	};
	xmlhttpMother.open( "POST", "together/scripty/sendToMother.php", true );
	xmlhttpMother.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttpMother.send( "month="+month+"&year="+year+"&table="+TABLE+"&mother="+MOTHER+"&where="+where+"&who="+who );
}

function reallySendToMother( month, year, mother, subject, message , headers, where )
{
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		var xmlhttpMother = new XMLHttpRequest();
	} else {
		// code for IE6, IE5
		var xmlhttpMother = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttpMother.onreadystatechange = function() {
		if ( xmlhttpMother.readyState == 4 && xmlhttpMother.status == 200 ) {
			document.getElementById( where ).innerHTML = xmlhttpMother.responseText;
		}
	};
	xmlhttpMother.open( "POST", "together/scripty/sendMailToMother.php", true );
	xmlhttpMother.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttpMother.send( "month="+month+"&year="+year+"&mother="+mother+"&subject="+subject+"&message="+message+"&headers="+headers );
}

function showMenu( where, j, h, sendMonthlyToMother, name )
{
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		var xmlhttpMenu = new XMLHttpRequest();
	} else {
		// code for IE6, IE5
		var xmlhttpMenu = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttpMenu.onreadystatechange = function() {
		if ( xmlhttpMenu.readyState == 4 && xmlhttpMenu.status == 200 ) {
			document.getElementById( where ).innerHTML = xmlhttpMenu.responseText;
		}
	};
	xmlhttpMenu.open( "POST", "together/scripty/showMenu.php", true );
	xmlhttpMenu.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttpMenu.send( "j="+j+"&h="+h+"&sendMonthly="+sendMonthlyToMother+"&name="+name );
}


function otherCurrency( div, curr ) {
	var val = document.getElementById('otherCurrency').checked;
	if ( val == false ) {
		document.getElementById(div).innerHTML = '';
	} else {
		if (window.XMLHttpRequest) {
			// code for IE7+, Firefox, Chrome, Opera, Safari
			var xmlhttp = new XMLHttpRequest();
		} else {
			// code for IE6, IE5
			var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function() {
			if ( xmlhttp.readyState == 4 && xmlhttp.status == 200 ) {
				document.getElementById( div ).innerHTML = xmlhttp.responseText;
			}
		};
		xmlhttp.open( "POST", "together/scripty/showCurrencies.php", true );
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xmlhttp.send( 'currency=' + curr );
	}
}

/**
* kurz měny
* 
*/
function getCurseValue( from, input, Select ) {
	var to = Select.options[Select.selectedIndex].value
	
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		var xmlhttp = new XMLHttpRequest();
	} else {
		// code for IE6, IE5
		var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if ( xmlhttp.readyState == 4 && xmlhttp.status == 200 ) {
			document.getElementById( input ).value = xmlhttp.responseText;
		}
	};
	xmlhttp.open( "POST", "together/scripty/getCurseValue.php", true );
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( 'to=' + from + "&from=" + to );
}


/**
* uložit záznam o útratě do DB
* 
*/
function nahratItem( DIV, login, passwd, user ) {
	
	var writeSuccess = '<p>Položka byla nahrána do databáze.</p>' +
	'<form method="post" action="">' +
	'		<input name="jmeno" value="' + login + '" type="hidden" />' +
	'		<input name="heslo" value="' + passwd + '" type="hidden" />' +
	'		<input type="hidden" name="sekce" value="pridat" />' +
	'		<button type="submit" name="dalsi" class="menu">Přidal talší položku</button>' +
	'</form>';
	
	var name = document.getElementById( 'nahr_name' ).value;
	var desc = document.getElementById( 'nahr_desc' ).value;
	var vyber = document.getElementById( 'nahr_vyber' ).checked == false ? 0 : 1;
	var odepsat = document.getElementById( 'nahr_odepsat' ).checked == false ? 0 : 1; 
	var Select = document.getElementById( 'nahr_pozn' );
	var pozn = Select.options[Select.selectedIndex].value;
	Select = document.getElementById( 'nahr_type' );
	var type = Select.options[Select.selectedIndex].value;
	var date = document.getElementById( 'nahr_date' ).value;
	var price = document.getElementById( 'cena' ).value;	
	var course = 1;
	var otherCurrency = document.getElementById( 'otherCurrency' ).checked;
	
	if ( otherCurrency ) course = document.getElementById( 'courseHere' ).value;
	
	if ( name == '' ) {
		document.getElementById( 'fillName' ).innerHTML = 'Vyplň název';
		return;
	} else document.getElementById( 'fillName' ).innerHTML = '';
	if ( price == '' ) {
		document.getElementById( 'fillPrice' ).innerHTML = 'Vyplň cenu';
		return;
	} else document.getElementById( 'fillPrice' ).innerHTML = '';
	
	
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		var xmlhttp = new XMLHttpRequest();
	} else {
		// code for IE6, IE5
		var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if ( xmlhttp.readyState == 4 && xmlhttp.status == 200 ) {
			if ( xmlhttp.responseText == 'success' ) {
				document.getElementById( DIV ).innerHTML = writeSuccess;
			} else if ( xmlhttp.responseText == 'duplicity' ) {
				document.getElementById( DIV ).innerHTML += 'Záznam již existuje<br />';
			} else {
				document.getElementById( DIV ).innerHTML += 'Some error -> ' + xmlhttp.responseText + '<br />';
			}
		}
	};
	xmlhttp.open( "POST", "together/scripty/nahratItem.php", true );
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( 'user=' + user + '&name=' + name + '&desc=' + desc + '&pozn=' + pozn + '&type=' + type + '&date=' + date + '&price=' + price + '&course=' + course + '&vyber=' + vyber + '&odepsat=' + odepsat );
}