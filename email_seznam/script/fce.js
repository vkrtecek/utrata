// JavaScript Document
$( document ).ready(function(){
	$( "#underFooter" ).hide();
	
	var radioButtons = document.getElementsByName( 'color' );
	for ( i = 0; i < radioButtons.length; i++ ){
		//alert( 'a' );
		/*radioButtons[i].style.opacity=0;*/
	};
});


function selectColorDiv( color ){
	$( ".color" ).css( "border", 'solid 2px transparent' );
	$( "#" + color ).css( "border", 'solid black 1px' );
};
