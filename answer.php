<?php
require_once ('sql.php');
$questionid = $_GET['questionid'];


$sql = "SELECT questionid,rightanswer,questionsummary FROM mdl_question_attempts WHERE questionid='$questionid' GROUP BY questionid";
$sql2= "SELECT questionid,responsesummary,questionsummary FROM mdl_question_attempts WHERE questionid = '$questionid'";

$stmt = $dbh->query ( $sql );
$stmt2 = $dbh->query ( $sql2 );
//$right_answer_count = 0;
//$wrong_answer_count = 0;
//$null_answer_count = 0;
$answer = array();

function array_flatten($array) {
	if (!is_array($array)) {
		return FALSE;
	}
	$result = array();
	foreach ($array as $key3 => $val) {
		if (is_array($val)) {
			$result = array_merge($result, array_flatten($val));
		}
		else {
			$result[$key3] = $val;
		}
	}
	return $result;
}
//echo '<tr><th>テスト番号</th><th>正答</th><th>解答</th></tr>';

while ($result = $stmt->fetch ( PDO::FETCH_ASSOC ) ) {
	echo $result['questionsummary'];
	echo '<table border=2>';
	$right_answer = explode ( ';', $result ['rightanswer'] );
	//$all_answer = explode ( ';', $result ['responsesummary'] );

	foreach ($right_answer as $key => $value_right_answer ) {
		echo "<tr>";
		echo "<td>".$value_right_answer."</td>";
		echo "</tr>";
	}
	echo '</table>';
}

echo '<br>';
echo '解答<br>';
while ($result2 = $stmt2->fetch ( PDO::FETCH_ASSOC ) ) {
	$all_answer = explode ( ';', $result2 ['responsesummary'] );
	$answer[]=$all_answer;
	//var_dump($result2['responsesummary']);
	//echo '<table border=2>';
	//var_dump($all_answer);
	//$answer_count = array_count_values($result = $stmt->fetch ( PDO::FETCH_ASSOC ));
	//foreach($all_answer as $key => $value_all_answer){

		//$counter = array_count_values($all_answer);
		//print_r($counter);
			//echo "<tr>";
			//echo "<td>".$result2['questionid'];
			//echo "<td>".$value_all_answer."</td>";
			//echo "</tr>";

		//}
		//echo '</table>';
}
//var_dump($answer);
//echo"<br>";
$answer = array_flatten($answer);
//var_dump($answer);
$counter = array_count_values($answer);
print_r($counter);
echo "<table border=2>";
foreach($counter as $key4 => $value_all_answer2){
	echo "<tr>";
	echo "<td>".$key4."</td>";
	echo "<td>".$value_all_answer2."</td>";
	echo "</tr>";

}
echo "</table>";


/*
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
*/



