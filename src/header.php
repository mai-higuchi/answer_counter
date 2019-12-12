<?php
require_once ('sql.php');
if (isset ( $_SESSION ['uid'] )) {
	$uid=$_SESSION ['uid'];
	$sql = "SELECT * FROM mdl_user WHERE username='{$uid}'";
	$stmt = $dbh->prepare ($sql);
	$stmt->execute();
	echo '<h1>解答集計システム</h1>';
	while($result=$stmt->fetch(PDO::FETCH_ASSOC)){
	  echo $result['lastname'].$result['firstname']."さん";
	  $_SESSION['lastname']=$result['lastname'];
	  $_SESSION['firstname']=$result['firstname'];
	}
	echo '<a href="?do=logout">ログアウト</a>';
}
	//var_dump($lastname);
	?>