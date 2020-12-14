<?php

include('config.php');

$ip = $_GET['ip'];
$port = $_GET['port'];
$community = $_GET['community'];
$version = $_GET['version'];

if(empty($ip) || empty($port) || empty($community) || empty($version)) {
    echo "Give a right input" ;
}

else {

    $db->exec("INSERT INTO information (ip,port,community,version) VALUES ('$ip','$port','$community','$version')");
        echo "\n";
        echo "OKAYY";

    }
$db->close();

?>
