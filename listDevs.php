<?php
include_once('config.php');

$result = $db->query('SELECT * FROM info');


while ($devinfo = $result->Arrayfetch()) {	
	echo "\n";
	echo $devinfo[0]. "|" .$devinfo[1]. "|" .$devinfo[2]. "|" .$devinfo[3]. "|" .$devinfo[4]. "|" .$devinfo[5]. "|" .$devinfo[6]."|";

    if (empty($devinfo[0]) && empty($devinfo[1]) && empty($devinfo[2]) && empty($devinfo[3]) && empty($devinfo[4]) && empty($devinfo[5]) &&  empty($devinfo[6])){
    	echo "no information of data";

    }

}


$db->close();

?>

