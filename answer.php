<?php
require_once ('sql.php');

$sql = 'SELECT questionid,rightanswer,responsesummary,questionsummary FROM mdl_question_attempts ORDER BY questionid';

$stmt = $dbh->query ( $sql );
$right_answer_count = 0;
$wrong_answer_count = 0;
$null_answer_count = 0;
//$answer_count=array();

//echo '<tr><th>テスト番号</th><th>正答</th><th>解答</th></tr>';

while ($result = $stmt->fetch ( PDO::FETCH_ASSOC ) ) {
	echo $result['questionsummary'];
	echo '<table border=2>';
	$right_answer = explode ( ';', $result ['rightanswer'] );
	$all_answer = explode ( ';', $result ['responsesummary'] );

	foreach ($right_answer as $key => $value_right_answer ) {
		echo"<tr>";
		echo "<td>".$value_right_answer."</td>";
		echo "</tr>";
	}
	$all_answer = explode ( ';', $result ['responsesummary'] );
	$answer_count = array_count_values($result = $stmt->fetch ( PDO::FETCH_ASSOC ));

	foreach ( $all_answer as $key => $value_all_answer ) {

		echo"<tr>";
		echo "<td>".$value_all_answer."</td>";
		echo "<td>".$wrong_answer_count."</td>";
		echo "</tr>";
	}
	echo '</table>';
	var_dump($right_answer);
	echo "<br>";
	var_dump($all_answer);
	echo "<br>";
	foreach ($right_answer as $key => $value_right_answer ) {
		foreach ( $all_answer as $key => $value_all_answer ) {
			if($value_right_answer===$value_all_answer){
				$right_answer_count++;
			}
		}
	}

	var_dump($right_answer_count);
	echo "<br>";

}

