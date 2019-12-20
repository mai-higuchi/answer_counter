<?php

// ドライバ呼び出しを使用して MySQL データベースに接続します
$dsn = 'mysql:dbname=moodle;host=localhost';
$user = 'root';
$password = 'i=Hj4VLvdb';

try {
    $dbh = new PDO($dsn, $user, $password
);
    //echo "接続成功\n";
} catch (PDOException $e) {
    //echo "接続失敗: " . $e->getMessage() . "\n";
    exit();
}
$conn = mysqli_connect("localhost","root","i=Hj4VLvdb");//MySQLサーバへ接続
mysqli_select_db($conn,"moodle");    // 使用するデータベースを指定
mysqli_query($conn,'set names utf8'); //文字コードをutf8に設定（文字化け対策）