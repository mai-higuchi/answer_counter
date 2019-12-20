<?php
session_start ();

include ('src/header.php');
//$uid = $_SESSION['uid'];
$action = 'top'; // トップ画面
//var_dump($uid);
if (isset ( $_GET ['do'] )) {

	$action = $_GET ['do'];
}
include ('src/'.$action.'.php');

?>
