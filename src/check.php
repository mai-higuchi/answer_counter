<!DOCTYPE html>
<html><head>
<meta http-equiv="Content-TYPE" content="text/html; charset=UTF-8"></head>
<body>
<?php
//session_start();
require_once ('sql.php');
  $uid = $_POST['uid'] ;  //ログイン画面より送信されたユーザID
  $pass = $_POST['pass'];  //ログイン画面より送信されたパスワード

  //$hash = password_hash($p,PASSWORD_DEFAULT);
  //echo $hash;

  $sql = "SELECT * FROM mdl_user WHERE username='{$uid}'";
  $stmt = $dbh->prepare ($sql);
  $stmt->execute();
  var_dump($stmt);
  $test = array();
  $result = array();
  echo '<br>';
  //$result = $stmt->fetch ( PDO::FETCH_ASSOC );
  //var_dump($result['lastname']);
  while($result=$stmt->fetch(PDO::FETCH_ASSOC)){
  	//print_f($result['username']);
  	$test[]=$result['password'];

  	//echo 'aiueo';
  	if(password_verify($pass,$result['password'])){
  		$_SESSION['uid']=$uid;

  		header('Location:../p_index.php');

  	}else{
  		header('Location:login.html');
  	}
  }

 // var_dump($test);


  //if ($row){ //問合せ結果がある場合、ログイン成功
    //$_SESSION['uid'] = $row['uid'];
    //$_SESSION['uname'] = $row['uname'];
    //$_SESSION['urole'] = $row['urole'];
    //header('Location:wp07index.php');
  //}else{
    //echo '<h2>ログイン失敗！ユーザIDもしくはパスワードが間違いました！</h2>';
    //echo '<a href="wp07login.html">戻る</a>';
  //}
?>
</body></html>