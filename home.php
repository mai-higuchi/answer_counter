<?php
require_once ('sql.php');

$sql = 'SELECT questionid FROM mdl_question_attempts GROUP BY questionid';
$stmt = $dbh->query ( $sql );
$i=0;
echo "<table border=2>";

while ($result = $stmt->fetch ( PDO::FETCH_ASSOC ) ) {
	$i++;
	echo "<tr>";
	echo "<td>"."テスト".$i."</td>";
	echo '<td><a href="?do=answer&questionid='.$result['questionid'].'">詳細</td>"';
	echo "</tr>";
}
echo "</table>";
