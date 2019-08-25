<?php
$db_host = "adayuting.com";
$db_username = "adayutin_root";
$db_password = "!ada840104";
$dbname = 'adayutin_property';

$conn = new Mysqli($db_host, $db_username, $db_password, $dbname);
$conn->query('set names utf8');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
// echo "Connected successfully";


// $sql = "INSERT INTO  `member` (`account`, `password`, `nick_name`) VALUES ('123', '123', '123')";
// $res = $conn->query($sql);

?>