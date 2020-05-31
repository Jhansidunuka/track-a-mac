<?php
include_once('config.php');

if (empty($_GET)) {
    echo "False";
    }
else {
    $mysearch = htmlspecialchars($_GET["mac"]);
    $sql = <<<EOF
              SELECT * FROM List WHERE MACS LIKE "%$mysearch%" ORDER BY MACS;
EOF;
    $myoutput = $db->query($sql);
    $data = array(); 
    while($row = $myoutput->Arrayfetch(SQLITE3_ASSOC) ){
         #echo $row[1]. "|" . $row[2] . "|" . $row[3] . "|" . $row[4] . "\n";
         $data[] = $row['IP']. " | " . $row['VLANs'] . " | " . $row['PORT'] . " | " . "$mysearch";
     
    }

$flag = count($data);
if($flag ==0){
    $count = $db->query('SELECT count(*) FROM info');
    while($check = $count->fetchArray(SQLITE3_ASSOC)) {
        $number_of_devices = $check['count(*)'];
        echo "No match of devices"."\n";
     }
}

$myresult = uniquearray($data);
$total = count($myresult);
for($i = 0; $i < $total; $i++){
    echo $myresult[$i]. "\n";
    }
}
$db->close();

?>