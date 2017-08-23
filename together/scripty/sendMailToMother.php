<?php
$month = $_REQUEST["month"];
$year = $_REQUEST["year"];
$mother = $_REQUEST["mother"];
$subject = $_REQUEST["subject"];
$message = str_replace( '<b>', '
', $_REQUEST["message"] );
$headers = $_REQUEST["headers"];
function ourMonth( $in )
{
	return $in == '01' ? 'leden' : ( $in == '02' ? 'únor' : ( $in == '03' ? 'březen' : ( $in == '04' ? 'duben' : ( $in == '05' ? 'květen' : ( $in == '06' ? 'červen' : ( $in == '07' ? 'červenec' : ( $in == '08' ? 'srpen' : ( $in == '09' ? 'září' : ( $in == '10' ? 'říjen' : ( $in == '11' ? 'listopad' : 'prosinec' ))))))))));
}
$mail = "../mail.php";
if ( file_exists($mail) && require($mail) )
{
	echo '<p>Účetnictví za <strong>'.ourMonth($month).' '.$year.'</strong> odesláno na '.$mother.'</p>';
	my_mail( $mother, $subject, $message, $headers );
}
?>
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
<button type="submit" onClick="send_ucty( 'send_to_mother' )" class="menu">Náhled e-mailu</button>