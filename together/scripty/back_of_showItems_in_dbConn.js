function showItems( where, table, limit, platnost ){
	
	platnost = platnost == 0 ? 0 : 1;
	var sortBy = document.getElementsByClassName( 'changeSort' )[0].value;
	var desc = document.getElementsByClassName( 'changeSort' )[1].value;
	var month = document.getElementsByClassName( 'changeSort' )[2].value;
	var pozn = document.getElementsByClassName( 'changeSort' )[3].value;
	var year = document.getElementsByClassName( 'changeSortBtn' )[0].value;
	var pattern = document.getElementsByClassName( 'changeSortBtn' )[1].value;
	if ( /^  +/.test(pattern) ) {
		alert( 'øetìzec zaèínal dvìma mezarama!' );
		document.getElementsByClassName( 'changeSortBtn' )[1].value = '';
		pattern = '';
	}
	var patternArray = pattern.split( '  ' );
	var ANDY = [];
	var ORY = [];
	
	var prikaz = 'SELECT * FROM '+table+' WHERE platnost = '+platnost+' AND nazev NOT LIKE \'vyber\' AND popis NOT LIKE \'vyber\'';
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
