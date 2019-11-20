<?php
require_once ('sql.php');
//$questionid = $_GET['questionid'];

$sql = 'SELECT DISTINCT questionid,parent,name FROM mdl_question,mdl_question_attempts
WHERE questionid = parent';

$stmt = $dbh->query ( $sql );

echo "<th>テスト集計</th>";

echo "<table border=2>";

while ($result = $stmt->fetch ( PDO::FETCH_ASSOC ) ) {

	echo '<tr>';
	echo '<td>'.$result['name'].'</td>';
	echo '<td><a href="answer.php?questionid='.$result['questionid'].'">詳細</td>';
	echo "</tr>";
}
echo "</table>";
