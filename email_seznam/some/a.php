<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<script>
function selectAll( name ){
	if ( typeof change === 'undefined' || change == false ){
		change = true;
		
	}else{
		change = false;
	}
	
	var cnt = document.getElementsByName( name ).length;
	for( var i = 0; i < cnt; i++ )
	{
		var k = document.getElementsByName( name )[i];
		if ( change ) k.checked = true;
		else k.checked = false;
	}
	
	var tmp = document.getElementsByName( name );
	for ( var i = 0; i < tmp.length; i++ )
	{
		if ( tmp[i].checked )
			alert( tmp[i].value );
	}
};
//array in javascript
function fce( into ){
	/*var maX = prompt( "Type number", "0" );
	alert( 'asdsads' + maxX );/*
	for( i = 0; i < maxX; i++ )
	{
		window.open( 'https://www.faceboobk.com' );
	}*/
};
function showOptions( where ){
	xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			document.getElementById( where ).innerHTML = xmlhttp.responseText;
		}
	};
	xmlhttp.open("GET","showOptions.php", true);
	xmlhttp.send();
};
var myvar = { "j" : "2", "k" : "3" };
fce( { "j" : "2", "k" : "3" } );
showOptions( 'here' );
</script>
	<div id="here"></div>
    <?php
    if ( isset($_GET['kl']) )
	{
		for ( $i = 0; $i < count($_GET['kl']); ++$i )
			echo 'K: '.$_GET['kl'][ $i ].'<br />';
    }
	?>
</body>
</html>