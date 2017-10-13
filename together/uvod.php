<div id="right"></div>
<script type="text/javascript">
	TWO_SPACES_BEGGINING = '<?=translateByCode($spojeni, 'login', $login, 'PrintItems.Filtering.Error.TwoSpaces');?>';
	showMenu( 'right', '<?php echo $login; ?>', '<?php echo $passwd; ?>', <?php echo $sendMonthly; ?>, '<?php echo $name; ?>' );
</script>

<h1><?= ucfirst( $name ); ?> - <?=translateByCode($spojeni, 'login', $login, 'Uvod.Heading1');?></h1>

<div id="items">

  <?php
  	$sortForm = 'together/sortForm.php';
  	if ( file_exists($sortForm) && require($sortForm) ) {
		printSortingForm( false, $name, $login, $spojeni );
	}
	else echo "<p>File $sortForm doesn't exists</p>";
  ?>







<div id="hereTable"><img src="together/img/loading.gif" alt="<?=translateByCode($spojeni, 'login', $login, 'Items.Loading.Alt');?>" /></div>
<script>
    LIMIT = 30000;
    WHERE = 'hereTable';
    TABLE = 'utrata_<?php echo $name; ?>';
    MOTHER = '<?php echo $mother; ?>';
    showItems( 'hereTable', '<?php echo $name; ?>', LIMIT );
    
    $( ".changeSort" ).change(function(){
        showItems( 'hereTable', '<?php echo $name; ?>', LIMIT );
    });
    $( ".changeSortBtn" ).keyup(function(){
        showItems( 'hereTable', '<?php echo $name; ?>', LIMIT );
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
            showItems( 'hereTable', '<?php echo $name; ?>', LIMIT );
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
            <option value=""><?=translateByCode($spojeni, 'login', $login, 'Uvod.Filtering.Month.Default');?></option>
            <?php
            $mesice = array(
							translateByCode($spojeni, 'login', $login, 'Month.January'),
							translateByCode($spojeni, 'login', $login, 'Month.February'),
							translateByCode($spojeni, 'login', $login, 'Month.March'),
							translateByCode($spojeni, 'login', $login, 'Month.April'),
							translateByCode($spojeni, 'login', $login, 'Month.May'),
							translateByCode($spojeni, 'login', $login, 'Month.June'),
							translateByCode($spojeni, 'login', $login, 'Month.July'),
							translateByCode($spojeni, 'login', $login, 'Month.August'),
							translateByCode($spojeni, 'login', $login, 'Month.September'),
							translateByCode($spojeni, 'login', $login, 'Month.October'),
							translateByCode($spojeni, 'login', $login, 'Month.November'),
							translateByCode($spojeni, 'login', $login, 'Month.December')
						);
            for ( $i = 0; $i < count($mesice); $i++ )
            {
                echo '<option value="'.str_pad( $i+1, 2, '0', STR_PAD_LEFT ).'">'.$mesice[$i].'</option>';
            }
            ?>
        </select>
        <input style="max-width:50px;" type="text" name="rok_send" id="rok_send" value="<?=translateByCode($spojeni, 'login', $login, 'SendToParent.Year');?>" />
        <button type="submit" onClick="send_ucty( 'send_to_mother', '<?=$name;?>', '<?=translateByCode($spojeni, 'login', $login, 'SendToParent.Year');?>' )" class="menu"><?=translateByCode($spojeni, 'login', $login, 'SendToParent.Button');?></button>
    </div>
    <script>
        $("#rok_send").focus(function(){
            val = $(this).val();
            if ( val == "<?=translateByCode($spojeni, 'login', $login, 'SendToParent.Year');?>" ) $(this).val( "" );
        });
        $("#rok_send").focusout(function(){
            val = $(this).val();
            if ( val == "" ) $(this).val( "<?=translateByCode($spojeni, 'login', $login, 'SendToParent.Year');?>" );
        });
        
        $("#send_to_mother").hide();
        function motherToggle(){
            $("#send_to_mother").slideToggle( 100 );
        }
    </script>
<?php } ?>






<script type="text/javascript">
var element = document.getElementById( 'focus' );
if ( element ) element.focus();
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
			else alert( '<?=translateByCode($spojeni, 'login', $login, 'Uvod.DownloadBackUp.ErrorOcured');?>: ' + xmlhttp.responseText );
		}
	};
	xmlhttp.open( 'POST', 'backUp/createBackUp.php', true );
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send( "name="+name );
}
</script>