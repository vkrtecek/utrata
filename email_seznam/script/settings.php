<?php
//echo $_POST['name'];
//echo '@'.$_POST['domain'];
$nickMinStrlen = 3;

if ( file_exists( "../promenne.php" ) && require( "../promenne.php" ) )
{
	if ( ($conn = mysqli_connect( $db_host, $db_user, $db_passwd, $db_name )) && $conn->query( "SET CHARACTER SET UTF8" ) )
	{
		$curPerson = mysqli_fetch_array( $conn->query( "SELECT * FROM ".$db_users." WHERE user = '".$_POST['name']."' AND domain = '".$_POST['domain']."'" ) );
		
		$allRight = false;
		$badNick = false;
		if ( isset($_POST['color']) && $_POST['color'] != 'undefined' && strlen(trim($_POST['nick'])) >= $nickMinStrlen && $_POST['nick'] != 'unfedined' )
		{
			$conn->query( "UPDATE ".$db_users." SET nick = '".$_POST['nick']."', styleColor = '".$_POST['color']."' WHERE user = '".$_POST['name']."' AND domain = '".$_POST['domain']."'" );
			$allRight = true;
		}
		else if ( isset($_POST['nick']) && strlen(trim($_POST['nick'])) < $nickMinStrlen )
		{
			$badNick = true;
		}
		
		
		
		if ( !$allRight )
		{
			echo '<form method="post" id="setForm" action="?type=settings">';
				echo '<table rules="none" id="setTable">';
					echo '<tr>';
						echo '<td colspan="2"><p>Jméno, které se bude zobrazovat u Vámi odeslaných e-mailů:</p></td>';
					echo '</tr><tr>';
						echo '<td colspan="2"><input type="text" name="nick" value="'.( $_POST['nick'] != 'undefined' ? $_POST['nick'] : $curPerson['nick'] ).'" id="setNick" /></td>';
					echo '</tr><tr>';
						echo '<td colspan="2"><p>Motiv:</p></td>';
					echo '</tr><tr class="colors">';
						echo '<td colspan="2">';
							echo '<table rules="none">';
								echo '<tr>';
									echo '<td>';
										echo '<label for="setColorBlack"><div id="black" '.($curPerson['styleColor'] == 'black' ? 'style="border:solid 1px black;"' : '').' class="color" title="black" onclick="selectColorDiv( \'black\' )"></div></label>';
									echo '</td>';
									echo '<td>';
										echo '<label for="setColorRed"><div id="red" '.($curPerson['styleColor'] == 'red' ? 'style="border:solid 1px black;"' : '').' class="color" title="red" onclick="selectColorDiv( \'red\' )"></div></label>';
									echo '</td>';
									echo '<td>';
										echo '<label for="setColorGreen"><div id="green" '.($curPerson['styleColor'] == 'green' ? 'style="border:solid 1px black;"' : '').' class="color" title="green" onclick="selectColorDiv( \'green\' )"></div></label>';
									echo '</td>';
								echo '</tr><tr>';
									echo '<td>';
										echo '<label for="setColorBlue"><div id="blue" '.($curPerson['styleColor'] == 'blue' ? 'style="border:solid 1px black;"' : '').' class="color" title="blue" onclick="selectColorDiv( \'blue\' )"></div></label>';
									echo '</td>';
									echo '<td>';
										echo '<label for="setColorPink"><div id="pink" '.($curPerson['styleColor'] == 'pink' ? 'style="border:solid 1px black;"' : '').' class="color" title="pink" onclick="selectColorDiv( \'pink\' )"></div></label>';
									echo '</td>';
									echo '<td>';
										echo '<label for="setColorYellow"><div id="yellow" '.($curPerson['styleColor'] == 'yellow' ? 'style="border:solid 1px black;"' : '').' class="color" title="yellow" onclick="selectColorDiv( \'yellow\' )"></div></label>';
									echo '</td>';
								echo '</tr>';
							echo '</table>';
						echo '</td>';
					echo '</tr>';
				echo '</table>';
				echo '<input type="radio" id="setColorBlack" name="color" value="black" class="radioToHide" '.( $curPerson['styleColor'] == 'black' ? 'checked=""' : '').' />';
				echo '<input type="radio" id="setColorRed" name="color" value="red" class="radioToHide" '.( $curPerson['styleColor'] == 'red' ? 'checked=""' : '').' />';
				echo '<input type="radio" id="setColorGreen" name="color" value="green" class="radioToHide" '.( $curPerson['styleColor'] == 'green' ? 'checked=""' : '').' />';
				echo '<input type="radio" id="setColorBlue" name="color" value="blue" class="radioToHide" '.( $curPerson['styleColor'] == 'blue' ? 'checked=""' : '').' />';
				echo '<input type="radio" id="setColorPink" name="color" value="pink" class="radioToHide" '.( $curPerson['styleColor'] == 'pink' ? 'checked=""' : '').' />';
				echo '<input type="radio" id="setColorYellow" name="color" value="yellow" class="radioToHide" '.( $curPerson['styleColor'] == 'yellow' ? 'checked=""' : '').' />';
				
				echo '<br />';
				echo '<input type="hidden" name="name" value="'.$_POST['name'].'" />';
				echo '<input type="hidden" name="domain" value="'.$_POST['domain'].'" />';
				echo '<input type="hidden" name="passwd" value="'.$_POST['passwd'].'" />';
				
				echo '<input type="submit" name="submit" value="Uložit" id="setSubmit" />';
			echo '</form>';
			if ( $badNick ) echo '<p class="red">Minimální délka jména jsou '.$nickMinStrlen.' znaky.</p>';
			
			echo '<script type="text/javascript">';
			echo 'selectColorDiv( \''.$curPerson['styleColor'].'\' );';
			echo '</script>';
		}
		else echo '<p>Vše proběhlo v pořádku.<br />Nastavení bylo změněno</p>';
	}
	else echo '<p>Connection failed.</p>';
}
else echo "<p>File ../promenne.php doesn't exists.</p>";
?>