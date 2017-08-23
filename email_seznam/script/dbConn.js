// JavaScript Document

function underline( id ){
	$(id).css( "text-decoration", "underline" );
};
function ununderline( id ){
	$(id).css( "text-decoration", "none" );
};


function selectAll( name, state ){
	
	var cnt = document.getElementsByName( name ).length;
	if ( typeof checked === 'undefined' || !checked ) checked = true;
	else checked = false;
	for ( var i = 0; i < cnt; i++ )
	{
		var k = document.getElementsByName( name )[i];
		if ( checked ){
			k.checked = true;
			//document.getElementById( state ).disabled = false;
		}else{
			k.checked = false;
			//document.getElementById( state ).disabled = true;
		}
	}
};






















function showMails( where, query, info, name, domain ){
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
	xmlhttp.open("POST","script/showMails.php", true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( "query=" + query + "&bolt=" + info['bolt'] + "&type=" + info['type'] + "&where=" + where + "&name=" + name + "&domain=" + domain );
};

function viewMessage( where, id, query, info, name, domain ){
	//alert( info['bolt'] );
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
	xmlhttp.open("POST","script/viewMail.php", true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( "query=" + query + "&bolt=" + info['bolt'] + "&type=" + info['type'] + "&where=" + where + "&id=" + id + "&name=" + name + "&domain=" + domain );
};














function updateMail( query ){
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	} else {
		// code for IE6, IE5
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	
	xmlhttp.open("POST","script/updateMail.php", true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( "query=" + query );
	//alert( query );
};

function mailToBin( id, where, query, info, name, domain ){
	updateMail( "UPDATE mail_box SET eDel = 1, eSpam = 0 WHERE ID = " + id );
	showMails( where, query, info, name, domain );
};

function backToInBox( id, where, query, info, name, domain ){
	updateMail( "UPDATE mail_box SET eDel = 0, eSpam = 0 WHERE ID = " + id );
	showMails( where, query, info, name, domain );
};

function mailToSpam( id, where, query, info, name, domain ){
	updateMail( "UPDATE mail_box SET eDel = 0, eSpam = 1 WHERE ID = " + id );
	showMails( where, query, info, name, domain );
};

function deleteMail( id, where, query, info, inOut, name, domain ){
	var realy = confirm( "Opravdu chcete natrvalo smazat tento e-mail?" );
	if ( realy )
	{
		if ( inOut == 'outBox' ) updateMail( "UPDATE box SET eSendValid = 0 WHERE ID = " + id );
		else updateMail( "UPDATE mail_box SET eRecValid = 0 WHERE ID = " + id );
		
		showMails( where, query, info, name, domain );
	}
};








function mailToBinAll( nameCheck, where, query, info, name, domain ){	
	var checkBoxes = document.getElementsByName( nameCheck );
	for ( var i = 0; i < checkBoxes.length; i++ )
	{
		if ( checkBoxes[i].checked )
		{
			updateMail( "UPDATE mail_box SET eDel = 1, eSpam = 0 WHERE ID = " + checkBoxes[i].value );
		}
	}
	showMails( where, query, info, name, domain );
};
function mailDeleteAll( nameCheck, where, query, info, inOut, name, domain ){
	var checkBoxes = document.getElementsByName( nameCheck );
	var CNT = 0;
	for ( i = 0; i < checkBoxes.length; i++ ){
		if ( checkBoxes[i].checked ) CNT++;
	}
	if ( CNT != 0 ) var realy = confirm( "Opravdu chcete natrvalo smazat tyto e-maily?" );
	if ( realy )
	{
		for ( var i = 0; i < checkBoxes.length; i++ )
		{
			if ( checkBoxes[i].checked )
			{
				if ( inOut == 'outBox' ) updateMail( "UPDATE mail_box SET eSendValid = 0 WHERE ID = " + checkBoxes[i].value );
				else updateMail( "UPDATE mail_box SET eRecValid = 0 WHERE ID = " + checkBoxes[i].value );
			}
		}
		showMails( where, query, info, name, domain );
	}
};
function mailToSpamAll( nameCheck, where, query, info, name, domain ){
	var checkBoxes = document.getElementsByName( nameCheck );
	for ( var i = 0; i < checkBoxes.length; i++ )
	{
		if ( checkBoxes[i].checked )
		{
			updateMail( "UPDATE mail_box SET eSpam = 1, eDel = 0 WHERE ID = " + checkBoxes[i].value );
		}
	}
	showMails( where, query, info, name, domain );
};
function backToInBoxAll( nameCheck, where, query, info, name, domain ){
	var checkBoxes = document.getElementsByName( nameCheck );
	for ( var i = 0; i < checkBoxes.length; i++ )
	{
		if ( checkBoxes[i].checked )
		{
			updateMail( "UPDATE mail_box SET eDel = 0, eSpam = 0 WHERE ID = " + checkBoxes[i].value );
		}
	}
	showMails( where, query, info, name, domain );
};
function mailsToReatAll( nameCheck, where, query, info, name, domain ){
	var checkBoxes = document.getElementsByName( nameCheck );
	for ( var i = 0; i < checkBoxes.length; i++ )
	{
		if ( checkBoxes[i].checked )
		{
			updateMail( "UPDATE mail_box SET eReat = 1 WHERE ID = " + checkBoxes[i].value );
		}
	}
	showMails( where, query, info, name, domain );
};
function mailsToUnreatAll( nameCheck, where, query, info, name, domain ){
	var checkBoxes = document.getElementsByName( nameCheck );
	for ( var i = 0; i < checkBoxes.length; i++ )
	{
		if ( checkBoxes[i].checked )
		{
			updateMail( "UPDATE mail_box SET eReat = 0 WHERE ID = " + checkBoxes[i].value );
		}
	}
	showMails( where, query, info, name, domain );
};

















function showFormToNewMessage( where, name, domain ){
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
	xmlhttp.open("POST","script/universalFormToMail.php", true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( "where=" + where + "&type=newMail" + "&name=" + name + "&domain=" + domain );
};
function showFormToSettings( where, name, domain, passwd, nick, color ){
	//alert( where );
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
	xmlhttp.open("POST","script/settings.php", true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( "where=" + where + "&type=settings" + "&name=" + name + "&domain=" + domain + "&passwd=" + passwd + "&nick=" + nick + "&color=" + color );
};
function mailReply( id, where, query, info, name, domain ){
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
	xmlhttp.open("POST","script/universalFormToMail.php", true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( "id=" + id + "&where=" + where + "&query=" + query + "&bolt=" + info['bolt'] + "&type=" + info['type'] + "&typeOfPage=reply" + "&name=" + name + "&domain=" + domain );
};
function mailResend( id, where, query, info, name, domain ){
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
	xmlhttp.open("POST","script/universalFormToMail.php", true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send(  "id=" + id + "&where=" + where + "&query=" + query + "&bolt=" + info['bolt'] + "&type=" + info['type'] + "&typeOfPage=reSend" + "&name=" + name + "&domain=" + domain );
};










function mailOK( mail ){
	var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	
	return re.test( mail );
};
function sendMail( where, query, info, mailTo, subject, text, from ){
	
	
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	} else {
		// code for IE6, IE5
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	/*xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById( where ).innerHTML = xmlhttp.responseText;
		}
	};*/
	xmlhttp.open("POST","script/sendMail.php", true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( "mail=" + mailTo + "&subject=" + subject + "&text=" + text + "&from=" + from );
	
	if ( query && info )
	{
		document.getElementById( where ).innerHTML = '<div id="navigationCurMail">';
		document.getElementById( where ).innerHTML += '<button style="margin-left:0.6rem;border:none;background-color:transparent;cursor:pointer;margin-bottom:0.5rem;" onclick="showMails( \'' + where + '\', \'' + query.replace( /'/g, '\\\'' ) + '\', { \'bolt\' : \'' + info['bolt'] + '\', \'type\' : \'' + info['type'] + '\' } )"><img src=\"img/back.png\" alt=\"Zpět\" title=\"Zpět\"/></button>'
		document.getElementById( where ).innerHTML += '</div>';
		document.getElementById( where ).innerHTML += '<div id="writeMailForm"><p>Email byl odeslán</p></div>';
	}
	else if ( !query && !info )
	{
		document.getElementById( where ).innerHTML = '<div id="writeMailForm"><p>Email byl odeslán</p></div>';
	}
};

function checkValuesToSendMail( whereErr, where, query, info  ){
	mailTo = document.getElementById( 'input1Form' ).value;
	subject = document.getElementById( 'input2Form' ).value;
	text = document.getElementById( 'textareaForm' ).value;
	from = document.getElementById( 'input0Form' ).value;
	
	if ( !mailOK( mailTo ) )
	{
		document.getElementById( whereErr ).innerHTML = '<p>Špatný formát e-mailu příjemce</p>';
	}
	else
	{
		sendMail( where, query, info, mailTo, subject, text, from );
	}
};