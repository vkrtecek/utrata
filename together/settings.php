<div id="right">
	<form method="post" action="">
		<input name="jmeno" value="<?php echo $login;?>" type="hidden" />
		<input name="heslo" value="<?php echo $passwd;?>" type="hidden" />
		<input type="hidden" name="sekce" value="uvod" />
	<button type="submit" name="back" class="menu" id="back" title="<?=translateByCode($spojeni, 'login', $login, 'Menu.Back')?>"><img width="40" height="40" src="together/img/back.jpg" alt="<?=translateByCode($spojeni, 'login', $login, 'Menu.Back')?>" /></button>
	</form>
</div>
<h1><?php echo ucfirst( $name ); ?> - <?=translateByCode($spojeni, 'login', $login, 'Settings.Heading1')?></h1>


<div id="settingsDiv"></div>
<script type="text/javascript">
	printSettingsForm( 'settingsDiv', '<?=$login;?>' );
</script>