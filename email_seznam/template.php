<?php if ( !file_exists( 'add/templateFuncs.php' ) || !require( 'add/templateFuncs.php' ) ) echo "<p>File add/templateFuncs.php doesn't exists.</p>"; else {?>


<div id="allPage">
	<div id="header">
    	<?php
        	if ( isset($_GET['type']) ) myHeader( $_GET['type'] );
			else myHeader();
		?>
    </div>
    
	<div id="menu">
    	<div id="menuToHide">
    		<?php if ( !$onMobile ) myMenu(); ?>
        </div>
    </div>    

	<div id="content">
    	<div id="hereMails"></div>
    </div>
    
    <div id="footer">
    	<?php myFooter(); ?>
    </div>
    
    <div id="underFooter">
    	<?php if ( $onMobile ) myMenu(); ?>
    </div>
</div>


<script type="text/javascript">
	<?php
		if ( isset($_GET['type']) )
		{
			switch ( $_GET['type'] )
			{
				case "inBox":
					echo 'query = "SELECT ID, eFrom `From`, eSubject `Subject`, eText `Text`, eDate `Date`, eReat FROM '.$db_box.' WHERE eTo = \''.$_POST['name'].'@'.$_POST['domain'].'\' AND eDel = 0 AND eSpam = 0 AND eRecValid = 1 ORDER BY ID DESC";';
					echo "var info = { 'bolt' : 'true', 'type' : 'inBox' };";
					echo "showMails( 'hereMails', query, info, '".$_POST['name']."', '".$_POST['domain']."' );";
					break;
				case "outBox":
					echo 'query = "SELECT ID, eTo `To`, eSubject `Subject`, eText `Text`, eDate `Date` FROM '.$db_box.' WHERE eFrom = \''.$_POST['name'].'@'.$_POST['domain'].'\' AND eSendValid = 1 ORDER BY ID DESC";';
					echo "var info = { 'bolt' : 'false', 'type' : 'outBox' };";
					echo "showMails( 'hereMails', query, info, '".$_POST['name']."', '".$_POST['domain']."' );";
					break;
				case "spamBox":
					echo 'query = "SELECT ID, eFrom `From`, eSubject `Subject`, eText `Text`, eDate `Date` FROM '.$db_box.' WHERE eTo = \''.$_POST['name'].'@'.$_POST['domain'].'\' AND eDel = 0 AND eSpam = 1 AND eRecValid = 1 ORDER BY ID DESC";';
					echo "var info = { 'bolt' : 'false', 'type' : 'spamBox' };";
					echo "showMails( 'hereMails', query, info, '".$_POST['name']."', '".$_POST['domain']."' );";
					break;
				case "binBox":
					echo 'query = "SELECT ID, eFrom `From`, eSubject `Subject`, eText `Text`, eDate `Date` FROM '.$db_box.' WHERE eTo = \''.$_POST['name'].'@'.$_POST['domain'].'\' AND eDel = 1 AND eSpam = 0 AND eRecValid = 1 ORDER BY ID DESC";';
					echo "var info = { 'bolt' : 'false', 'type' : 'binBox' };";
					echo "showMails( 'hereMails', query, info, '".$_POST['name']."', '".$_POST['domain']."' );";
					break;
				case "nonReat":
					echo 'query = "SELECT ID, eFrom `From`, eSubject `Subject`, eText `Text`, eDate `Date`, eReat FROM '.$db_box.' WHERE eTo = \''.$_POST['name'].'@'.$_POST['domain'].'\' AND eDel = 0 AND eSpam = 0 AND eReat = 0 AND eRecValid = 1 ORDER BY ID DESC";';
					echo "var info = { 'bolt' : 'true', 'type' : 'nonReat' };";
					echo "showMails( 'hereMails', query, info, '".$_POST['name']."', '".$_POST['domain']."' );";
					break;
				case "newMessage":
					echo "showFormToNewMessage( 'hereMails', '".$_POST['name']."', '".$_POST['domain']."' );";
					break;
				case "settings":
					echo "showFormToSettings( 'hereMails', '".$_POST['name']."', '".$_POST['domain']."', '".$_POST['passwd']."'";
					if ( isset($_POST['nick']) ) echo ", '".$_POST['nick']."'";
					if ( isset($_POST['color']) ) echo ", '".$_POST['color']."'";
					echo " );";
					break;
			}
		}
		else
		{
			echo 'query = "SELECT ID, eFrom `From`, eSubject `Subject`, eText `Text`, eDate `Date`, eReat FROM '.$db_box.' WHERE eTo = \''.$_POST['name'].'@'.$_POST['domain'].'\' AND eDel = 0 AND eSpam = 0 ORDER BY ID DESC";';
			echo "var info = { 'bolt' : 'true', 'type' : 'inBox' };";
			echo "showMails( 'hereMails', query, info );";
		}
	?>
</script>

<?php }?>