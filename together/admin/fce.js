// JavaScript Document

NAME = false;
LOGIN = false;
VAL_TO_CHANGE = '';

function addPerson(  ){
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		var xmlhttpAdd = new XMLHttpRequest();
	} else {
		// code for IE6, IE5
		var xmlhttpAdd = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttpAdd.onreadystatechange = function() {
		if (xmlhttpAdd.readyState == 4 && xmlhttpAdd.status == 200) {
			document.getElementById( WHERE ).innerHTML = xmlhttpAdd.responseText;
			document.getElementById("insName").focus();
		}
	};
	xmlhttpAdd.open( "POST", "together/admin/addPersonForm.php", true );
	xmlhttpAdd.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttpAdd.send(  );
};


function delPerson( query ) {
	if ( query == null ) query = "SELECT * FROM utrata_members";
	
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		var xmlhttpStat = new XMLHttpRequest();
	} else {
		// code for IE6, IE5
		var xmlhttpStat = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttpStat.onreadystatechange = function() {
		if (xmlhttpStat.readyState == 4 && xmlhttpStat.status == 200) {
			document.getElementById( WHERE ).innerHTML = xmlhttpStat.responseText;
		}
	};
	xmlhttpStat.open( "POST", "together/admin/showAllPeople.php", true );
	xmlhttpStat.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttpStat.send( "query="+query );
};

function delConcrPerson( id ) {
	var enter = confirm( "Do you really want to delete "+id+"?" );
	if ( !enter ) return;
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		var xmlhttpStat = new XMLHttpRequest();
	} else {
		// code for IE6, IE5
		var xmlhttpStat = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttpStat.onreadystatechange = function() {
		if (xmlhttpStat.readyState == 4 && xmlhttpStat.status == 200) {
			delPerson(  );
		}
	};
	xmlhttpStat.open( "POST", "together/admin/delConcrPerson.php", true );
	xmlhttpStat.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttpStat.send( "id="+id );
};


function repairStr( val, id ) {
	var change = false;
	var newVal = val;
	var ascii = val[val.length-1].charCodeAt(0);
	if ( ascii < 48 || (ascii > 57 && ascii < 97) || ascii > 122 ) {
		newVal = val.substring( 0, val.length-1 );
	}
	document.getElementById( id ).value = newVal;
	return change;
}
function writeFeedBackUser( val, state, where ) {
	var mess = "";
	if ( val.length > 0 && state == "true" ) {
		mess = ' <b class="ared">User with this name already exists</b>';
		NAME = false;
	} else if ( val.length > 0 && state == "false" ) {
		mess = ' <b class="agreen">Name is ok</b>';
		NAME = true;
	}
	
	document.getElementById( where ).innerHTML = mess;
}
function checkUserExistence( id, where ) {
	var val = document.getElementById( id ).value;
	var repair = repairStr( val, id );
	if ( repair ) return;
	var mess;
	
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		var xmlhttpStat = new XMLHttpRequest();
	} else {
		// code for IE6, IE5
		var xmlhttpStat = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttpStat.onreadystatechange = function() {
		if (xmlhttpStat.readyState == 4 && xmlhttpStat.status == 200) {
			mess = xmlhttpStat.responseText;
			writeFeedBackUser( val, mess, where );
		}
	};
	xmlhttpStat.open( "POST", "together/admin/testUserExistence.php", true );
	xmlhttpStat.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttpStat.send( "name="+val );
}





function writeFeedBackLogin( val, state, where ) {
	var mess = "";
	if ( val.length > 0 && state == "true" ) {
		mess = ' <b class="ared">User with this login already exists</b>';
		LOGIN = false;
	} else if ( val.length > 0 && state == "false" ) {
		mess = ' <b class="agreen">Login is ok</b>';
		LOGIN = true;
	}
	
	document.getElementById( where ).innerHTML = mess;
}
function checkLoginExistence ( id, where ) {
	var val = document.getElementById( id ).value;
	var mess;
	
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		var xmlhttpStat = new XMLHttpRequest();
	} else {
		// code for IE6, IE5
		var xmlhttpStat = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttpStat.onreadystatechange = function() {
		if (xmlhttpStat.readyState == 4 && xmlhttpStat.status == 200) {
			mess = xmlhttpStat.responseText;
			writeFeedBackLogin( val, mess, where );
		}
	};
	xmlhttpStat.open( "POST", "together/admin/testLoginExistence.php", true );
	xmlhttpStat.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttpStat.send( "login="+val );
}





function validateEmail(email) {
  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(email);
}
function checkAdding( where ) {
	var MIN_CHARS = 2;
	var inss = [ 'insName', 'insLogin', 'insPasswd', 'insSendMonthly', 'insSendByOne', 'insMother', 'insMe', 'insCurrency' ];
	var ins = [];
	var empty = lengths = false;
	
	for ( var i = 0; i < inss.length; i++ ) {
		ins[inss[i]] = document.getElementById( inss[i] ).value;
		
		if ( ins[inss[i]] == "" ) {
			empty = true;
		} else if ( ins[inss[i]].length < MIN_CHARS ) {
			if ( inss[i] == 'insSendMonthly' || inss[i] == 'insSendByOne' || inss[i] == 'insCurrency' ) continue;
			lengths = true;
		}
	}
	var mails = validateEmail( ins['insMother'] ) && validateEmail( ins['insMe'] );
	
	if ( empty ) warningLog = "Some field(s) is not filled";
	else if ( !NAME ) warningLog = "This name is reserved";
	else if ( !LOGIN ) warningLog = "This login is reserved";
	else if ( lengths ) warningLog = "Some input is shorter than "+MIN_CHARS+" chars";
	else if ( !mails ) warningLog = "Format of some e-mail is incorrect";
	else warningLog = "";
	
	if ( !(warningLog == "") ) document.getElementById( where ).innerHTML = warningLog;
	else {
		if (window.XMLHttpRequest) {
			// code for IE7+, Firefox, Chrome, Opera, Safari
			var xmlhttpStat = new XMLHttpRequest();
		} else {
			// code for IE6, IE5
			var xmlhttpStat = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttpStat.onreadystatechange = function() {
			if (xmlhttpStat.readyState == 4 && xmlhttpStat.status == 200) {
				var ret = xmlhttpStat.responseText;
				document.getElementById( where ).innerHTML = ret;
				if ( ret == "success" ) {
					for ( var i = 0; i < inss.length; i++ ) {
						if ( inss[i] == 'insSendMonthly' || inss[i] == 'insSendByOne' || inss[i] == 'insCurrency' ) continue;
						document.getElementById( inss[i] ).value = "";
					}
					document.getElementById( 'existenceHere' ).value = "";
				}
			}
		};
		xmlhttpStat.open( "POST", "together/admin/addConcrPerson.php", true );
		xmlhttpStat.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xmlhttpStat.send( "name="+ins['insName']+"&login="+ins['insLogin']+"&passwd="+ins['insPasswd']+"&sendMonthly="+ins['insSendMonthly']+"&sendByOne="+ins['insSendByOne']+"&mother="+ins['insMother']+"&me="+ins['insMe']+"&currency="+ins['insCurrency'] );
	}
}











function updatePerson() {
	var query = "SELECT * FROM utrata_members";
	
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		var xmlhttpStat = new XMLHttpRequest();
	} else {
		// code for IE6, IE5
		var xmlhttpStat = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttpStat.onreadystatechange = function() {
		if (xmlhttpStat.readyState == 4 && xmlhttpStat.status == 200) {
			document.getElementById( WHERE ).innerHTML = xmlhttpStat.responseText;
		}
	};
	xmlhttpStat.open( "POST", "together/admin/showAllPeopleToUpdate.php", true );
	xmlhttpStat.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttpStat.send( "query="+query );
}

function updateCell( idOfCell, column, idOfTable ) {
	var val = document.getElementById( idOfCell ).innerHTML;
	VAL_TO_CHANGE = val;
	document.getElementById( idOfCell ).innerHTML = "<input type=\"text\" class=\"updateCellInput\" under=\""+idOfCell+"\" myColumn=\""+column+"\" tableId=\""+idOfTable+"\" value=\""+val+"\" />";
}


$(document).mouseup(function(e){
	var container = $(".updateCellInput");
	if ( container.is(e.target) ) return;
	if ( !(container.length) ) return;
	
	var id = container.attr( 'under' );
	var column = container.attr( 'myColumn' );
	var tableId = container.attr( 'tableId' );
	var val = container.val();
	
	var ERROR = false;
	
	
	document.getElementById( id ).innerHTML = val;
	if ( VAL_TO_CHANGE == val ) return;
	
	switch ( column ) {
		case 'name':
			
			break;
		case 'login':
			
			break;
		case 'passwd':
			
			break;
		case 'sendMonthly':
			if ( val != '1' && val != '0' ) {
				alert( "Only 1 or 0 value are possible" );
				document.getElementById( id ).innerHTML = VAL_TO_CHANGE;
				return;
			}
			break;
		case 'sendByOne':
			if ( val != '1' && val != '0' ) {
				alert( "Only 1 and 0 values are possible" );
				document.getElementById( id ).innerHTML = VAL_TO_CHANGE;
				return;
			}
			break;
		case 'mother':
			if ( !validateEmail(val) ) {
				alert( "Bad format of mail address" );
				document.getElementById( id ).innerHTML = VAL_TO_CHANGE;
				return;
			}
			break;
		case 'me':
			if ( !validateEmail(val) ) {
				alert( "Bad format of mail address" );
				document.getElementById( id ).innerHTML = VAL_TO_CHANGE;
				return;
			}
			break;
		case 'currency':
			
			break;
		case 'admin':
			if ( val != '1' && val != '0' ) {
				alert( "Only 1 and 0 values are possible" );
				document.getElementById( id ).innerHTML = VAL_TO_CHANGE;
				return;
			}
			break;
		case 'logged':
			if ( val != '1' && val != '0' ) {
				alert( "Only 1 and 0 values are possible" );
				document.getElementById( id ).innerHTML = VAL_TO_CHANGE;
				return;
			}
			break;
		case 'IP':
			if ( val != '' && val != VAL_TO_CHANGE ) {
				alert( "Can't change it" );
				document.getElementById( id ).innerHTML = VAL_TO_CHANGE;
				return;
			}
			break;
	}
	
	var queryToUpdate = "UPDATE utrata_members SET "+column+"='"+val+"' WHERE name='"+tableId+"'";
	
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		var xmlhttpStat = new XMLHttpRequest();
	} else {
		// code for IE6, IE5
		var xmlhttpStat = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttpStat.onreadystatechange = function() {
		if (xmlhttpStat.readyState == 4 && xmlhttpStat.status == 200) {
			alert( xmlhttpStat.responseText );
			updatePerson();
		}
	};
	xmlhttpStat.open( "POST", "together/admin/updateConcrPerson.php", true );
	xmlhttpStat.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttpStat.send( "query="+queryToUpdate );
});