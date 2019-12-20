<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>テスト選択</title>
    <link rel="stylesheet" href="css/style.css" />

</head>
<body>

</body>
</html>


<?php
require_once ('sql.php');
//include ('header.php');
//$uid = $_SESSION['uid'];
//$lastname = $_SESSION['lastnmae'];
//$firstname = $_SESSION['firstname'];
//var_dump($_SESSION);
$cid = $_GET['cid'];
$uid = $_GET['uid'];
//var_dump($cid);
$sql = "SELECT DISTINCT
c.fullname,q.name,q.id,qs.questionid
FROM
mdl_quiz as q,
mdl_quiz_slots as qs,
mdl_course as c
WHERE
q.course = c.id AND
q.id = qs.quizid AND
c.id = '{$cid}'";
$stmt = $dbh->query ( $sql );
echo "<h2>小テスト選択</h2>";
echo "<table border=2>";
while ($result = $stmt->fetch ( PDO::FETCH_ASSOC ) ) {
	echo '<tr>';
	echo '<td>'.$result['name'].'</td>';
	echo '<td><a href="?do=answer&questionid='.$result['questionid'].'">詳細</td>';
	echo "</tr>";
}
echo "</table>";
