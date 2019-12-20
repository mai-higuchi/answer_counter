<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/style.css" />

</head>
<body>

</body>
</html>

<?php
require_once ('sql.php');
if (isset ( $_SESSION ['uid'] )) {
	$uid=$_SESSION ['uid'];
	$sql = "SELECT * FROM mdl_user WHERE username='{$uid}'";
	$stmt = $dbh->prepare ($sql);
	$stmt->execute();
	echo '<header>';
	echo '<h1><div style="text-align:center">解答集計システム</div>';

	while($result=$stmt->fetch(PDO::FETCH_ASSOC)){
	  echo '<span style="font-size:16px"><div style="text-align:right"> '.$result['lastname'].$result['firstname']."さん";
	  $_SESSION['lastname']=$result['lastname'];
	  $_SESSION['firstname']=$result['firstname'];
	}
	echo '<span style="font-size:16px"><a href="?do=logout">ログアウト</a></div></span></h1>';
	echo '</header>';
}
	//var_dump($lastname);
	?>