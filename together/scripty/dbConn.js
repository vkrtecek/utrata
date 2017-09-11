// JavaScript Document

function makeSQLStatement( month, pozn, year, pattern ) {

	if ( /^  +/.test(pattern) ) {
		alert( TWO_SPACES_BEGGINING );
		document.getElementsByClassName( 'changeSortBtn' )[1].value = '';
		pattern = '';
	}
	var patternArray = pattern.split( '  ' );
	var ANDY = [];
	var ORY = [];

	var prikaz = '';
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

	
	return prikaz;
}

function showItems( where, user, limit, platnost ){
	
	platnost = platnost == 0 ? 0 : 1;
	var sortBy = document.getElementsByClassName( 'changeSort' )[0].value;
	var desc = document.getElementsByClassName( 'changeSort' )[1].value;
	var month = document.getElementsByClassName( 'changeSort' )[2].value;
	var pozn = document.getElementsByClassName( 'changeSort' )[3].value;
	var year = document.getElementsByClassName( 'changeSortBtn' )[0].value;
	var pattern = document.getElementsByClassName( 'changeSortBtn' )[1].value;

	
	
	var prikaz = 'SELECT * FROM utrata_items USER LEFT JOIN utrata_Purposes P ON USER.pozn=P.PurposeID WHERE USER.UserID="' + user + '" AND platnost = '+platnost+' AND vyber=0';
	prikaz += makeSQLStatement( month, pozn, year, pattern, sortBy, desc, limit );
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
	xmlhttp.send( "prikaz="+prikaz+"&user="+user+"&where="+where+"&platnost="+platnost );
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
	xmlhttpStat.send( "where="+where+"&who="+who );
};


function updateItem( id, user, where, whereStatus ){	
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		var xmlhttp = new XMLHttpRequest();
	} else {
		// code for IE6, IE5
		var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			showItems( where, user, LIMIT );
		}
	};
	xmlhttp.open( "POST", "together/scripty/updateItem.php", true );
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( "id="+id+"&user="+user );
};
function deleteItem( id, user, where, whereStatus, confirmUpdate, platnost ){
	var enter = confirm( confirmUpdate );
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
			showItems( where, user, LIMIT, platnost );
			showStatus( whereStatus, user );
		}
	};
	xmlhttp.open( "POST", "together/scripty/deleteItem.php", true );
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( "id="+id+"&user="+user );
};

function updateAllItems( user, where, confirmUpdateAll ) {
	var enter = confirm( confirmUpdateAll );
	if ( !enter ) return;
	var month = document.getElementsByClassName( 'changeSort' )[2].value;
	var pozn = document.getElementsByClassName( 'changeSort' )[3].value;
	var year = document.getElementsByClassName( 'changeSortBtn' )[0].value;
	var pattern = document.getElementsByClassName( 'changeSortBtn' )[1].value;

	var prikaz = 'UPDATE utrata_items SET platnost=0 WHERE UserID="' + user + '" AND platnost = 1 AND vyber=0';
	prikaz += makeSQLStatement( month, pozn, year, pattern );

	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		var xmlhttp = new XMLHttpRequest();
	} else {
		// code for IE6, IE5
		var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			showItems( where, user, LIMIT, 1 );
		}
	};
	xmlhttp.open( "POST", "together/scripty/updateAllItems.php", true );
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( "prikaz="+prikaz );
}


function updateState( typ, whereAfter, value, user ){
	xmlhttpU = new XMLHttpRequest();
	xmlhttpU.onreadystatechange = function() {
		if (xmlhttpU.readyState == 4 && xmlhttpU.status == 200) {
			showStatus( whereAfter, user );
		}
	};
	xmlhttpU.open( "POST", "together/scripty/updateState.php", true );
	xmlhttpU.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttpU.send( "typ=" + typ + "&value=" + value + "&user=" + user );
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
	
	showItems( 'hereTable', name, LIMIT, x );
}

function send_ucty( where, who, defYear )
{
	var month = document.getElementById( 'mesic_send' ).value;
	var year = document.getElementById( 'rok_send' ).value;
	if ( month == '' || year == defYear || parseInt(year) != year || year < 2015 )
		return;
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


function otherCurrency( div, curr, login ) {
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
		xmlhttp.send( 'currency=' + curr + "&login=" + login );
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
function nahratItem( DIV, login, passwd, user, successfullyAdded, successfullyAddedButton, alreadyExists, fillName, fillPrice, noPurposeSelected ) {
	
	var writeSuccess = '<p>'+successfullyAdded+'.</p>' +
	'<form method="post" action="">' +
	'		<input name="jmeno" value="' + login + '" type="hidden" />' +
	'		<input name="heslo" value="' + passwd + '" type="hidden" />' +
	'		<input type="hidden" name="sekce" value="pridat" />' +
	'		<button type="submit" name="dalsi" class="menu">'+successfullyAddedButton+'</button>' +
	'</form>';
	
	var name = document.getElementById( 'nahr_name' ).value;
	var desc = document.getElementById( 'nahr_desc' ).value;
	var vyber = document.getElementById( 'nahr_vyber' ).checked == false ? 0 : 1;
	var odepsat = document.getElementById( 'nahr_odepsat' ).checked == false ? 0 : 1; 
	var Select = document.getElementById( 'nahr_pozn' );
	if ( Select.selectedIndex < 0 ) {
		document.getElementById( 'fillName' ).innerHTML = noPurposeSelected;
		return;
	}
	var pozn = Select.options[Select.selectedIndex].value;
	Select = document.getElementById( 'nahr_type' );
	var type = Select.options[Select.selectedIndex].value;
	var date = document.getElementById( 'nahr_date' ).value;
	var price = document.getElementById( 'cena' ).value;	
	var course = 1;
	var otherCurrency = document.getElementById( 'otherCurrency' ).checked;
	
	if ( otherCurrency ) course = document.getElementById( 'courseHere' ).value;
	
	if ( name == '' ) {
		document.getElementById( 'fillName' ).innerHTML = fillName;
		return;
	} else document.getElementById( 'fillName' ).innerHTML = '';
	if ( price == '' ) {
		document.getElementById( 'fillPrice' ).innerHTML = fillPrice;
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
				document.getElementById( DIV ).innerHTML += alreadyExists+'<br />';
			} else {
				document.getElementById( DIV ).innerHTML += 'Some error -> ' + xmlhttp.responseText + '<br />';
			}
		}
	};
	xmlhttp.open( "POST", "together/scripty/nahratItem.php", true );
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( 'user=' + user + '&name=' + name + '&desc=' + desc + '&pozn=' + pozn + '&type=' + type + '&date=' + date + '&price=' + price + '&course=' + course + '&vyber=' + vyber + '&odepsat=' + odepsat );
}


function printSettingsForm( DIV, login ) {
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		var xmlhttp = new XMLHttpRequest();
	} else {
		// code for IE6, IE5
		var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if ( xmlhttp.readyState == 4 && xmlhttp.status == 200 ) {
			document.getElementById( DIV ).innerHTML = xmlhttp.responseText;
		}
	};
	xmlhttp.open( "POST", "together/scripty/printSettingsForm.php", true );
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( "login="+login );
}

function makeLowercase( input ) {
	input.value = input.value.toLowerCase();	
}

function checkMail( input, DIV, wrongFormat ) {
	document.getElementById( DIV ).style.fontFamily = 'monospace';
	var was = input.getAttribute( 'goodValue' );
	var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	
	if ( input.value == was ) {
		document.getElementById( DIV ).innerHTML = '';
	} else if ( re.test(input.value) ) {
		document.getElementById( DIV ).innerHTML = 'OK';
		document.getElementById( DIV ).style.color = 'green';
	} else {
		document.getElementById( DIV ).innerHTML = wrongFormat;
		document.getElementById( DIV ).style.color = 'red';
	}
}

function checkExistenceInCol( input, COL, DIV, loginTooShort, loginAlreadyExists, loginSomeError ) {
	var minChar = 2;
	var puvodni = input.getAttribute( 'goodValue' );
	document.getElementById( DIV ).style.fontFamily = 'monospace';
	
	if ( input.value.length < minChar ) {
		document.getElementById( DIV ).innerHTML = loginTooShort.replace( '{%d}', minChar );
		document.getElementById( DIV ).style.color = 'violet';
	} else if ( input.value == puvodni ) {
		document.getElementById( DIV ).innerHTML =  '';
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
				if ( xmlhttp.responseText == 'success' ) {
					document.getElementById( DIV ).innerHTML = 'OK';
					document.getElementById( DIV ).style.color = 'green';
				} else if ( xmlhttp.responseText == 'duplicity' ) {
					document.getElementById( DIV ).innerHTML = loginAlreadyExists;
					document.getElementById( DIV ).style.color = 'red';
				} else {
					document.getElementById( DIV ).innerHTML = loginSomeError;
					document.getElementById( DIV ).style.color = 'red';
				}
			} else {
				document.getElementById( DIV ).innerHTML = loginSomeError;
				document.getElementById( DIV ).style.color = 'red';
			}
		};
		xmlhttp.open( "POST", "together/scripty/checkExistenceInCol.php", true );
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xmlhttp.send( "col=" + COL + "&value=" + input.value );
	}
}



function checkPasswd2( input, DIV, passwordsNotMaching ) {
	var minChar = 2;
	var was = input.getAttribute( 'goodValue' );
	var val = input.value;
	document.getElementById( DIV ).style.fontFamily = 'monospace';
	
	if ( val == document.getElementById('passwd').value ) {
		document.getElementById( DIV ).innerHTML = 'OK';
		document.getElementById( DIV ).style.color = 'green';
	} else {
		document.getElementById( DIV ).innerHTML = passwordsNotMaching;
		document.getElementById( DIV ).style.color = 'red';
	}
}
function checkPasswd( input, DIV, a, passwordTooShort, passwordBadSecurity, passwordsNotMaching ) {
	var minChar = 2;
	var was = input.getAttribute( 'goodValue' );
	var val = input.value;
	document.getElementById( DIV ).style.fontFamily = 'monospace';
	
	if ( val == was ) {
		document.getElementById( DIV ).innerHTML = '';
	} else if ( val.length < minChar ) {
		document.getElementById( DIV ).innerHTML = passwordTooShort.replace( '{%d}', minChar );
		document.getElementById( DIV ).style.color = 'violet';
	} else {
		var degree = 0;
		if ( val != val.toLowerCase() ) degree++;
		if ( val != val.toUpperCase() ) degree++;
		if ( /\d/.test(val) ) degree++; //contain number
		
		if ( degree < 2 ) {
			document.getElementById( DIV ).innerHTML = passwordBadSecurity;
			document.getElementById( DIV ).style.color = 'violet';
		} else {
			document.getElementById( DIV ).innerHTML = 'OK';
			document.getElementById( DIV ).style.color = 'green';
		}
	}
	checkPasswd2( document.getElementById('passwd2'), 'warningPass2', passwordsNotMaching );
}


function changeSettings( AlertName, AlertLogin, AlertPasswd, AlertPasswdAgain, AlertParentMail, AlertMyMail, ResultError, ResultSuccess ) {
	var DIV = 'settingsDiv';
	var sgName = document.getElementById( 'warningName' ).innerHTML;
	var sgLogin = document.getElementById( 'warningLogin' ).innerHTML;
	var sgPass1 = document.getElementById( 'warningPass1' ).innerHTML;
	var sgPass2 = document.getElementById( 'warningPass2' ).innerHTML;
	var sgMother = document.getElementById( 'warningMother' ).innerHTML;
	var sgMe = document.getElementById( 'warningMe' ).innerHTML;
	
	if ( sgName != '' && sgName != 'OK' ) alert ( AlerName );
	else if ( sgLogin != '' && sgLogin != 'OK' ) alert( AlertLogin );
	else if ( sgPass1 != '' && sgPass1 != 'OK' ) alert( AlertPasswd );
	else if ( sgPass2 != '' && sgPass2 != 'OK' ) alert( AlertPasswdAgin );
	else if ( sgMother != '' && sgMother != 'OK' ) alert( AlertParentMail );
	else if ( sgMe != '' && sgMe != 'OK' ) alert( AlertMyMail );
	else
	{ //make changes
		var id = document.getElementById( 'settingsID' ).value;
		var name = document.getElementById( 'name' ).value;
		var login = document.getElementById( 'login' ).value;
		var passwd = document.getElementById( 'passwd' ).value;
		var Select = document.getElementById( 'SendByOne' );
		var sendByOne = Select.options[Select.selectedIndex].value;
		Select = document.getElementById( 'SendMonthly' );
		var sendMonthly = Select.options[Select.selectedIndex].value;
		var mother = document.getElementById( 'motherMail' ).value;
		var me = document.getElementById( 'meMail' ).value;
		Select = document.getElementById( 'currency' );
		var currency = Select.options[Select.selectedIndex].value;
		Select = document.getElementById('language');
		var language = Select.options[Select.selectedIndex].value;
		var purposes = $('#purposes').val();
		
		
		if (window.XMLHttpRequest) {
			// code for IE7+, Firefox, Chrome, Opera, Safari
			var xmlhttp = new XMLHttpRequest();
		} else {
			// code for IE6, IE5
			var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function() {
			if ( xmlhttp.readyState == 4 && xmlhttp.status == 200 ) {
				if ( xmlhttp.responseText == 'success' ) document.getElementById( DIV ).innerHTML = ResultSuccess;
				else document.getElementById( DIV ).innerHTML = xmlhttp.responseText;
			} else document.getElementById( DIV ).innerHTML = ResultError;
		};
		xmlhttp.open( "POST", "together/scripty/changeSettings.php", true );
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xmlhttp.send( "id="+id+"&name="+name+"&login="+login+"&passwd="+passwd+"&sendByOne="+sendByOne+"&sendMonthly="+sendMonthly+"&mother="+mother+"&me="+me+"&currency="+currency+"&language="+language+"&purposes="+purposes );
	}
}

function sendForgottenData( fillMail, successfullySend, somethingWrong ) {
	var mail = document.getElementById('mail').value;
	var DIV = 'footerP';
	if ( mail == '' ) {
		document.getElementById( DIV ).innerHTML = fillMail;
		document.getElementById( DIV ).style.color = 'red';
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
				if ( xmlhttp.responseText == 'success' ) {
					document.getElementById( DIV ).innerHTML = successfullySend + ' ' + mail;
					document.getElementById( DIV ).style.color = 'green';
				}	else {
					document.getElementById( DIV ).innerHTML = xmlhttp.responseText;
					document.getElementById( DIV ).style.color = 'violet';
				}
			} else {
				document.getElementById( DIV ).innerHTML = somethingWrong;
				document.getElementById( DIV ).style.color = 'red';
			}
		};
		xmlhttp.open( "POST", "together/scripty/sendForgottenData.php", true );
		xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xmlhttp.send( "mail=" + mail );
	}
}

/**
* in form to add item
*/
function printPurposes( SPAN, name, DEFAULT ) {
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		var xmlhttp = new XMLHttpRequest();
	} else {
		// code for IE6, IE5
		var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if ( xmlhttp.readyState == 4 && xmlhttp.status == 200 ) {
			//document.getElementById( SPAN ).innerHTML = xmlhttp.responseText;
			document.getElementById( 'nahr_pozn' ).innerHTML = xmlhttp.responseText;
		}
	};
	xmlhttp.open( "POST", "together/scripty/printPurposes.php", true );
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( "name=" + name + "&defaultOption=" + DEFAULT );
}


function addPurpose( INPUT, SELECT_TO_REFRESH, STATUS, language ) {
	var purpose = document.getElementById( INPUT ).value;
	if ( purpose == '' || purpose == null || purpose == 'undefined' ) {
		document.getElementById( STATUS ).innerHTML = 'empty';
		document.getElementById( STATUS ).style.color = 'violet';
		return;
	}
	
	var name = document.getElementsByName('jmeno')[0].value;
	
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
				//$( '#'+SELECT_TO_REFRESH ).load();
				location.reload();
				document.getElementById( STATUS ).innerHTML = 'OK';
				document.getElementById( STATUS ).style.color = 'green';
			} else {
				document.getElementById( STATUS ).innerHTML = xmlhttp.responseText;
				document.getElementById( STATUS ).style.color = 'red';
			}
		}
	};
	xmlhttp.open( "POST", "together/scripty/addPurpose.php", true );
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( "name=" + name + "&purpose=" + purpose + "&language=" + language );
	
	document.getElementById( STATUS ).innerHTML = 'FAIL';
	document.getElementById( STATUS ).style.color = 'red';
}

function redrawPurposesByLanguage( Select ) {
	var purpSelect = document.getElementById('purposes');
	var language = Select.options[Select.selectedIndex].value;
	purpSelect.innerHTML = '<option>' + language + '</option>';
	
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		var xmlhttp = new XMLHttpRequest();
	} else {
		// code for IE6, IE5
		var xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.onreadystatechange = function() {
		if ( xmlhttp.readyState == 4 && xmlhttp.status == 200 ) {
			purpSelect.innerHTML = xmlhttp.responseText;
		}
	};
	xmlhttp.open( "POST", "together/scripty/redrawPurposesByLanguage.php", true );
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( "language=" + language );
}







$(document).ready(function(){
	$('#cena').focus();
	$("#nahr_name").focus();
});

$(document).keyup(function(e){
	
	if ( e.keyCode == 27 /*|| e.keyCode == 8 */) { //pressed ESC or BackSpace
		if ( document.body.scrollTop > 0 )
			document.body.scrollTop = 0;
		else
			window.history.go(-1);
	}
});

$(document).keydown(function(event){
	if ( event.ctrlKey && event.keyCode == 188 ) { //Shift+,
		$('#addItem').click();
		event.preventDefault(); 
	} else if ( event.ctrlKey && event.keyCode == 77 ) { //Ctrl+M
		$('#addTransaction').click();
		event.preventDefault(); 
	} else if ( event.ctrlKey && event.keyCode == 79 ) { //Ctrl+O
		$('#oldBills').click();
		event.preventDefault(); 
	} else if ( event.ctrlKey && event.keyCode == 83 ) { //Ctrl+S
		$('#settings').click();
		event.preventDefault(); 
	} else if ( event.ctrlKey && event.keyCode == 90 ) { //Ctrl+Z
		window.history.go(-1);
		event.preventDefault(); 
	} else if ( event.ctrlKey && event.keyCode == 89 ) { //Ctrl+Y
		window.history.go(1);
		event.preventDefault(); 
	} else if ( event.ctrlKey && event.keyCode == 66 ) { //Ctrl+B
		document.getElementsByName('back')[0].click();
		event.preventDefault(); 
	} else if ( event.ctrlKey && event.keyCode == 76 ) { //Ctrl+L
		document.getElementsByName('logOut')[0].click();
		event.preventDefault(); 
	}
});
