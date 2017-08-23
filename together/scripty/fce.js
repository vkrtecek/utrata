// JavaScript Document

function otherCurrency( div ) {
	var val = document.getElementById('otherCurrency').checked;
	if ( val == true ) {
		document.getElementById(div).innerHTML = '';
	} else {
		document.getElementById(div).innerHTML = 'dsfsdf';
	}
}