<?php

include_once('config.php');

$ip = $_GET['ip'];
$port = $_GET['port'];
$community = $_GET['community'];
$version = $_GET['version'];

if(empty($ip) || empty($port)||empty($community) || empty($version)) {
    echo "Not true";
}

else {
    $removedevice = $db->exec("DELETE FROM info WHERE ip='$ip' AND port='$port'AND community='$community' AND version='$version'");
    if(!$removedevice){
        echo "remove failed";
    }
    else {
        echo "Removed";
    }

}

$db->close();

?>
