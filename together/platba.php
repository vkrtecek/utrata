<?php
$warning1 = false;
$warning2 = false;
$warning_len = false;
$warning_fill = false;
$platba_nahrana = false;
$MAX_STRLEN_DUVOD = 60;
$duvod = str_replace( '{%d}', $MAX_STRLEN_DUVOD, translateByCode($spojeni, 'login', $login, 'AddTransaction.Form.Reason.Default') );

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

if (isset($_REQUEST['nahrat']) && $_REQUEST['cena'] == '') $warning1 = true;
if (isset($_REQUEST['nahrat']) && !$warning1 && !is_numeric($_REQUEST['cena'])) $warning2 = true;
if (isset($_REQUEST['nahrat']) && strlen($_REQUEST['duvod']) > $MAX_STRLEN_DUVOD ) $warning_len = true;
if (isset($_REQUEST['nahrat']) && ( strlen(trim($_REQUEST['duvod'])) == 0 || $_REQUEST['duvod'] == $duvod ) ) $warning_fill = true;
if (isset($_REQUEST['nahrat']) && !$warning1 && !$warning2 && !$warning_len && !$warning_fill ) $platba_nahrana = true;
?>

<h1><?=translateByCode($spojeni, 'login', $login, 'AddTransaction.Heading1');?></h1>
<div id="right">
	<form method="post" action="">
		<input name="jmeno" value="<?php echo $login;?>" type="hidden" />
		<input name="heslo" value="<?php echo $passwd;?>" type="hidden" />
		<button type="submit" name="back" class="menu" id="back" title="<?=translateByCode($spojeni, 'login', $login, 'Menu.Back')?>"><img width="40" height="40" src="together/img/back.jpg" alt="<?=translateByCode($spojeni, 'login', $login, 'Menu.Back');?>" /></button>
	</form>
</div>
<?php
require('getMyTime().php');
echo '<div id="allTransactions">';
if ( !$platba_nahrana )
{ ?>
	<form method="post"> 
		<p><label> <?=translateByCode($spojeni, 'login', $login, 'AddTransaction.Form.Price');?>: <input id="cena" name="cena" value="<?php if (isset($_REQUEST['cena'])) echo $_REQUEST['cena'];?>" /> <?php echo $currency; ?></label></p><br />
		<p><label><?=translateByCode($spojeni, 'login', $login, 'AddTransaction.Form.Reason');?>: <input id="duvod" name="duvod" value="<?php if (isset($_REQUEST['duvod'])) echo $_REQUEST['duvod'];?>" /></label></p><br />
		<p><?=translateByCode($spojeni, 'login', $login, 'AddTransaction.Form.Type');?>: <select name="typ" rows="1">
			<option value="karta" <?php if (isset($_REQUEST['typ']) && $_REQUEST['typ'] == 'karta') echo 'selected="selected"';?>><?=translateByCode($spojeni, 'login', $login, 'AddTransaction.Form.Type.Card');?></option>
			<option value="hotovost" <?php if (isset($_REQUEST['typ']) && $_REQUEST['typ'] == 'hotovost') echo 'selected="selected"';?>><?=translateByCode($spojeni, 'login', $login, 'AddTransaction.Form.Type.Cash');?></option>
		</select></p><br />
		<input name="jmeno" value="<?php echo $login;?>" type="hidden" />
		<input name="heslo" value="<?php echo $passwd;?>" type="hidden" />
		<input type="hidden" name="sekce" value="platba" />
		
		<button name="nahrat"><?=translateByCode($spojeni, 'login', $login, 'AddTransaction.Form.Send');?></button></p><br />
	</form>
	<script>
	MAX_STRLEN_DUVOD = <?php echo $MAX_STRLEN_DUVOD; ?>;
	duvod = "<?=$duvod;?>";
	<?php if ( !isset($_REQUEST['nahrat']) || $_REQUEST['duvod'] == $duvod ) {?>
	$("#duvod").val( duvod );
	$("#duvod").css( "color" , "grey" );
	$("#duvod").css( "font-family" , "monospace" );
	<?php }?>
	$("#duvod").css( "max-width" , "150px" );
	$("#duvod").keyup(function(){
		var str = $(this).val();
		if ( str.length > MAX_STRLEN_DUVOD )
		{
			str = str.substring( 0, MAX_STRLEN_DUVOD );
			$(this).val( str );
		}
	});
	
	$("#duvod").focus(function(){
		val = $(this).val();
		if ( val == duvod )
		{
			$(this).val( "" );
			$(this).css( "color", "black" );
			$(this).css( "font-family" , "sans-serif" );
		}
	});
	$("#duvod").focusout(function(){
		val = $(this).val();
		if ( val == "" )
		{
			$(this).val( duvod );
			$(this).css( "color" , "grey" );
			$(this).css( "font-family" , "monospace" );
		}
		
	});
	</script>
	<?php
		if ( $warning1 ) echo ' <strong class="red">'.translateByCode($spojeni, 'login', $login, 'AddTransaction.Form.BadPrice').'.</strong><br />';
		if ( $warning2 ) echo ' <strong class="red">'.translateByCode($spojeni, 'login', $login, 'AddTransaction.Form.PriceNaN').'.</strong><br />';
		if ( $warning_len ) echo ' <strong class="red">'.str_replace( '{%d}', $MAX_STRLEN_DUVOD, translateByCode($spojeni, 'login', $login, 'AddTransaction.Form.ReasonBadLength')).'.</strong><br />';
		if ( $warning_fill ) echo ' <strong class="red">'.translateByCode($spojeni, 'login', $login, 'AddTransaction.Form.BadReason').'.</strong><br />';
		if (isset($_REQUEST['nahrat']) && strpos($_REQUEST['cena'],',') !== false) {?><em class="pozn"><?=translateByCode($spojeni, 'login', $login, 'AddTransaction.Form.UseDelimiter');?></em><br /><?php }
	}
	else //item nahrán
	{
		$spojeni->query("SET CHARACTER SET utf8");
		$spojeni->query("INSERT INTO utrata_akt_hodnota (UserID, datum, hodnota, duvod, typ) VALUES ( '".$name."', '".getMyTime()."', '".$_REQUEST['cena']."', '".$_REQUEST['duvod']."', '".$_REQUEST['typ']."')");
		echo '<p>'.translateByCode($spojeni, 'login', $login, 'AddTransaction.Form.AddedText').'.</p>';?>
		<form method="post" action="">
			<input name="jmeno" value="<?php echo $login;?>" type="hidden" />
			<input name="heslo" value="<?php echo $passwd;?>" type="hidden" />
			<input type="hidden" name="sekce" value="platba" />
			<button type="submit" name="dalsi" class="menu"><?=translateByCode($spojeni, 'login', $login, 'AddTransaction.Form.AddAnotherItem');?></button>
		</form>
		<?php
		$mailphp = 'together/mail.php';
		if ( file_exists($mailphp) && require($mailphp) )
		{
			$to = $me;
			$subject = translateByCode($spojeni, 'login', $login, 'AddTransaction.SuccessMail.Subject').' '.$name.'\'s '.$_REQUEST['typ'];
			$message = translateByCode($spojeni, 'login', $login, 'AddTransaction.SuccessMail.Message1').' '.$_REQUEST['cena'].' '.$currency.'.
			'.translateByCode($spojeni, 'login', $login, 'AddTransaction.SuccessMail.Message2').': '.$_REQUEST['duvod'].'
			('.dateToReadableFormat( getMyTime(), $mesice ).')';
			$headers = 'From: utrata <'.$spravce.'>\n';
			
			my_mail($to, $subject, $message, $headers);
		}
		else echo 'Can\'t find file mail.php';
	}
	?>
	
	
	
	
	<hr />
	<div id="transakce">
	<?php
		$spojeni->query('SET CHARACTER SET UTF8');
		if (isset($_REQUEST['smazat_prispevek'])) {
			$sql = $spojeni->query( "SELECT idToDelete FROM utrata_akt_hodnota WHERE ID = ".$_REQUEST['smazat_prispevek'] );
			$id = mysqli_fetch_array( $sql );
			$spojeni->query('DELETE FROM utrata_akt_hodnota WHERE ID = '.$_REQUEST['smazat_prispevek']);
			if ( $id['idToDelete'] ) {
				$spojeni->query("DELETE FROM utrata_items WHERE ID = ".$id['idToDelete']);
			}
		}
		$sql = $spojeni->query('SELECT * FROM utrata_akt_hodnota WHERE UserID="'.$name.'" ORDER BY ID DESC');
		
		echo '<table rules="all">';
		echo '<tr>
			<th>'.translateByCode($spojeni, 'login', $login, 'AddTransaction.Table.ID').'</th>
			<th>'.translateByCode($spojeni, 'login', $login, 'AddTransaction.Table.Date').'</th>
			<th>'.translateByCode($spojeni, 'login', $login, 'AddTransaction.Table.Value').'</th>
			<th>'.translateByCode($spojeni, 'login', $login, 'AddTransaction.Table.Reason').'</th>
			<th>'.translateByCode($spojeni, 'login', $login, 'AddTransaction.Table.Type').'</th>
			<th>'.translateByCode($spojeni, 'login', $login, 'AddTransaction.Table.Delete').'</th>
		</tr>';
		
		$poradnik = 1;
		while ($polozka = mysqli_fetch_array($sql))
		{
			if ($poradnik % 2) $radek =  '<tr class="suda">';
			else $radek = '<tr class="licha">';
			$radek .= '<td>'.$poradnik.'</td><td>'.dateToReadableFormat($polozka['datum'], $mesice).'</td><td>'.number_format($polozka['hodnota'], 2, ',', ' ').' '.$currency.'</td><td>'.$polozka['duvod'].'</td><td>'.$polozka['typ'].'</td>';
			$radek .= '<td><form method="post" action="" onSubmit="return reallyDel()">
			<input name="jmeno" value="'.$login.'" type="hidden" />
			<input name="heslo" value="'.$passwd.'" type="hidden" />
			<input type="hidden" name="sekce" value="platba" />
			<button type="submit"  name="smazat_prispevek" title="'.translateByCode($spojeni, 'login', $login, 'AddTransaction.Table.Delete.Title').'" class="smazat_prispevek" value="'.$polozka['ID'].'"><b>&times;</b></button></form></td>';
			$radek .= '</tr>';
			
			echo $radek;
			
			$poradnik++;
		}
		echo '</table>';
	?>
	</div>
</div>
<script type="text/javascript">
	function reallyDel() {
		return confirm( "Opravdu smazat?" );
	}
</script>