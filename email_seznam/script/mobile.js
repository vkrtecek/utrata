// JavaScript Document
function transformMenu(){
	$( "#underFooter" ).hide();
	menu = document.getElementById( "menu" );
	//document.getElementById( 'underFooter' ).innerHTML = menu.innerHTML;
	document.getElementById( "menu" ).innerHTML = "<p id=\"menuP\">MENU</p>";
	
	$( "#menuP" ).click(function(){
		$( "#underFooter" ).slideToggle();
	});
};