<?php
	echo '
	<form method="get">
	   This: <input type="checkbox" name="aaa" value="0" onclick="selectAll( \'kl[]\' )" /><br>';
	   for ( $i = 0; $i < 15; ++$i )
	   		echo '<input type="checkbox" name="kl[]" value="'.$i.'"  /><br>';
		
        echo '<input type="submit"   name="kll" value="check" />
	</form>';
?>