<?php
require_once "db.php";
// header('Access-Control-Allow-Origin:*');

$sql = "SELECT * FROM `ntd`";
$res = $conn->query($sql);
$product = array();
$row = $res->fetch_all();

// $data = ['123'];
// var_dump($row);
echo json_encode($row);
?>