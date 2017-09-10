<?php
$month = $_REQUEST["month"];
$year = $_REQUEST["year"];
$mother = $_REQUEST["mother"];
$subject = $_REQUEST["subject"];
$message = str_replace( '<b>', '
', $_REQUEST["message"] );
$headers = $_REQUEST["headers"];

$promenne = '../../../promenne.php';
if ( file_exists($promenne) && require($promenne) )
{
	if ( ($spojeni = mysqli_connect( $db_host, $db_username, $db_password, $db_name )) && $spojeni->query( "SET CHARACTER SET UTF8" ) )
	{
		$mail = "../mail.php";
		if ( file_exists($mail) && require($mail) )
		{
			echo '<p>'.translateByCode($spojeni, 'mother', $mother, 'SendToParent.Sent.ToDate').' <strong>'.$month.' '.$year.'</strong> '.translateByCode($spojeni, 'mother', $mother, 'SendToParent.Sent.ToMail').' '.$mother.'</p>';
			/*my_*/mail( $mother, $subject, $message, $headers );
		}
		/*?>
		<select name="mesic_send" id="mesic_send">
				<option value=""><?=translateByCode($spojeni, 'mother', $mother, 'Uvod.Filtering.Month.Default');?></option>
				<?php
				$mesice = array(
					translateByCode($spojeni, 'mother', $mother, 'Month.January'),
					translateByCode($spojeni, 'mother', $mother, 'Month.February'),
					translateByCode($spojeni, 'mother', $mother, 'Month.March'),
					translateByCode($spojeni, 'mother', $mother, 'Month.April'),
					translateByCode($spojeni, 'mother', $mother, 'Month.May'),
					translateByCode($spojeni, 'mother', $mother, 'Month.June'),
					translateByCode($spojeni, 'mother', $mother, 'Month.July'),
					translateByCode($spojeni, 'mother', $mother, 'Month.August'),
					translateByCode($spojeni, 'mother', $mother, 'Month.September'),
					translateByCode($spojeni, 'mother', $mother, 'Month.October'),
					translateByCode($spojeni, 'mother', $mother, 'Month.November'),
					translateByCode($spojeni, 'mother', $mother, 'Month.December')
				);
				for ( $i = 0; $i < count($mesice); $i++ )
				{
						echo '<option value="'.str_pad( $i+1, 2, '0', STR_PAD_LEFT ).'">'.$mesice[$i].'</option>';
				}
				?>
		</select>
		<input style="max-width:50px;" type="text" name="rok_send" id="rok_send" value="<?=translateByCode($spojeni, 'mother', $mother, 'SendToParent.Year');?>" />
		<button type="submit" onClick="send_ucty( 'send_to_mother' )" class="menu"><?=translateByCode($spojeni, 'mother', $mother, 'SendToParent.Button');?></button>
		<?php*/
	} else echo "<p>Connection with database had failed.</p>";
} else echo "<p>File $promenne doesn't exists.</p>";
