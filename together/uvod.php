<div id="right"></div>
<script type="text/javascript">
    showMenu( 'right', '<?php echo $login; ?>', '<?php echo $passwd; ?>', <?php echo $sendMonthly; ?>, '<?php echo $name; ?>' );
</script>

<h1><?php echo ucfirst( $name ); ?> - útrata :-)</h1>

<div id="items">

  <?php
  	$sortForm = 'together/sortForm.php';
  	if ( file_exists($sortForm) && require($sortForm) ) {
		printSortingForm( false, $name );
	}
	else echo "<p>File $sortForm doesn't exists</p>";
  ?>







<div id="hereTable"><img src="together/img/loading.gif" alt="načítání" /></div>
<script>
    LIMIT = 3000;
    WHERE = 'hereTable';
    TABLE = 'utrata_<?php echo $name; ?>';
    MOTHER = '<?php echo $mother; ?>';
    showItems( 'hereTable', 'utrata_<?php echo $name; ?>', LIMIT );
    
    $( ".changeSort" ).change(function(){
        showItems( 'hereTable', 'utrata_<?php echo $name; ?>', LIMIT );
    });
    $( ".changeSortBtn" ).keyup(function(){
        showItems( 'hereTable', 'utrata_<?php echo $name; ?>', LIMIT );
    });
    
    
    function wait( msec )
    {
        setTimeout( function(){  }, msec );
    }
    window.onscroll = function(){
        var tolerance = 0;
        var windowHeight = $(window).height();
        var maxHeight = $("body").innerHeight();
        var actualHeight = $("body").scrollTop();
        
        if ( actualHeight + tolerance + windowHeight >= maxHeight )
        {
            wait( 300 );
            LIMIT += 300;
            showItems( 'hereTable', 'utrata_<?php echo $name; ?>', LIMIT );
        }
		
		var actualScroll = $("body").scrollTop();
		if ( actualScroll > 0 ) document.getElementById( 'scrollUp' ).innerHTML = '<img onClick="scrollUp()" src="together/img/scrollUp.png" alt="scroll up" id="scrollUpImg" />';
		else document.getElementById( 'scrollUp' ).innerHTML = '';
    };
	function scrollUp()
	{
		$("body").scrollTop( '0' );
	}
    
</script>



<div id="prostred"></div>
<script type="text/javascript">			
    showStatus( 'prostred', '<?php echo $name; ?>' );
</script>










<?php if ( $sendMonthly ) { ?>
    <div id="send_to_mother">
        <select name="mesic_send" id="mesic_send">
            <option value="">--měsíc--</option>
            <?php
            $mesice = array( 'leden', 'únor', 'březen', 'duben', 'květen', 'červen', 'červenec', 'srpen', 'září', 'říjen', 'listopad', 'prosinec' );
            for ( $i = 0; $i < count($mesice); $i++ )
            {
                echo '<option value="'.str_pad( $i+1, 2, '0', STR_PAD_LEFT ).'">'.$mesice[$i].'</option>';
            }
            ?>
        </select>
        <input style="max-width:50px;" type="text" name="rok_send" id="rok_send" value="rok" />
        <button type="submit" onClick="send_ucty( 'send_to_mother', '<?php echo $name; ?>' )" class="menu">Náhled e-mailu</button>
    </div>
    <script>
        $("#rok_send").focus(function(){
            val = $(this).val();
            if ( val == "rok" ) $(this).val( "" );
        });
        $("#rok_send").focusout(function(){
            val = $(this).val();
            if ( val == "" ) $(this).val( "rok" );
        });
        
        $("#send_to_mother").hide();
        function motherToggle(){
            $("#send_to_mother").slideToggle( 100 );
        }
    </script>
<?php } ?>
        

        
        
        
        

<script type="text/javascript">
document.getElementById( 'focus' ).focus();
function downloadBackUp( name )
{
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.onreadystatechange = function(){
		if ( xmlhttp.readyState == 4 && xmlhttp.status == 200 )
		{
			if ( xmlhttp.responseText == 'true' ) {
				var file_path = 'backUp/'+name+'.txt';
				var a = document.createElement('A');
				a.href = file_path;
				a.download = file_path.substr(file_path.lastIndexOf('/') + 1);
				document.body.appendChild(a);
				a.click();
				document.body.removeChild(a);
				
				//window.open( 'backUp/'+name+'.txt' );
			}
			else alert( 'vyskytla se chyba: ' + xmlhttp.responseText );
		}
	};
	xmlhttp.open( 'POST', 'backUp/createBackUp.php', true );
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( "name="+name );
}
</script>