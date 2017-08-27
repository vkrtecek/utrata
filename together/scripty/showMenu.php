<form method="post" action="">
    <input type="hidden" name="jmeno" value="<?php echo $_REQUEST['j'];?>" />
    <input type="hidden" name="heslo" value="<?php echo $_REQUEST['h'];?>" />
    <input type="hidden" name="sekce" value="pridat" />
    <button type="submit" name="pridat" class="menu">Přidat položku</button>
</form>
<form method="post" action="">
    <input type="hidden" name="jmeno" value="<?php echo $_REQUEST['j'];?>" />
    <input type="hidden" name="heslo" value="<?php echo $_REQUEST['h'];?>" />
    <input type="hidden" name="sekce" value="platba" />
    <button type="submit" name="platba" class="menu">Nová transakce</button>
</form>
<form method="post" action="">
    <input type="hidden" name="jmeno" value="<?php echo $_REQUEST['j'];?>" />
    <input type="hidden" name="heslo" value="<?php echo $_REQUEST['h'];?>" />
    <input type="hidden" name="sekce" value="stare_ucty" />
    <button type="submit" name="stare_ucty" class="menu">Staré účty</button>
</form>
<form method="post" action="">
    <input type="hidden" name="jmeno" value="<?php echo $_REQUEST['j'];?>" />
    <input type="hidden" name="heslo" value="<?php echo $_REQUEST['h'];?>" />
    <input type="hidden" name="sekce" value="settings" />
    <button type="submit" name="settings" class="menu">Nastavení</button>
</form>
<?php if ( $_REQUEST['sendMonthly'] )
{
	echo '<button style="margin-top:5px;" onClick="motherToggle()">Poslat mamce</button><br />';
}?>
<button class="menu" onclick="downloadBackUp( '<?php echo $_REQUEST['name']; ?>' )">Stáhnout zálohu</button>
<form method="post" action="">
    <button name="logOut" type="submit" class="menu odhlasit">Odhlásit</button>
</form>

<div id="scrollUp"></div>