<?php
require_once ('sql.php');  //接続
$questionid = $_GET['questionid'];
$testid = $_GET['testid']; //id取得

//SQL
$sql = "SELECT questionid,rightanswer,questionsummary FROM mdl_question_attempts WHERE questionid='$questionid' GROUP BY questionid";
$sql2= "SELECT questionid,responsesummary,questionsummary FROM mdl_question_attempts WHERE questionid = '$questionid' ORDER BY responsesummary";
$i=0;
$stmt = $dbh->query ( $sql );
$stmt2 = $dbh->query ( $sql2 );
$part_answer=array();
$syuukei = array();
$first_answer=array();
$answer = array();
$answer2 = array();
$first_answer2 = array();
$first_answer3 = array();
$first_answer4 = array();
//解答データをすべて配列の中に入れるメソッド
function array_flatten($array) {
	if (!is_array($array)) {
		return FALSE;
	}
	$result = array();
	foreach ($array as $key3 => $val) {
		if (is_array($val)) {
			$result = array_merge($result, array_flatten($val));
		} else {
			$result[$key3] = $val;
		}
	}
	return $result;
}
echo "テスト".$testid."<br>";

//正答表作成
while ($result = $stmt->fetch ( PDO::FETCH_ASSOC ) ) {
	echo "問題<br>";
	echo "<th>".$result['questionsummary']."</th>";

	echo '<table border=2>';
	$right_answer = explode ( ';', $result ['rightanswer'] );

	foreach ($right_answer as $key => $value_right_answer ) {
		echo "<tr>";
		echo "<td>".$value_right_answer."</td>";
		echo "</tr>";
	}
	echo '</table>';

}
//解答データの分割
echo '<br>';
echo '解答集計結果<br>';
while ($result2 = $stmt2->fetch ( PDO::FETCH_ASSOC ) ) {
	$all_answer = explode ( ';', $result2 ['responsesummary'] );
	//$answer[]=$all_answer;

	$counter = count($all_answer);
	//回答者数の数だけ配列を作成

	for($i=0;$i<$counter;$i++){
		echo "i:".$i.":<br>";
		if(! isset($part_answer[$i])) {
			$part_answer[$i] = array();
		}
		array_push($part_answer[$i],array_shift($all_answer));
		echo"<br>";
		$answer = array_flatten($part_answer[$i]);
		echo "<br>syuukei";
		print_r($answer);
		$syuukei = array_count_values($answer);
		echo "<br>answercount";
		print_r($syuukei);
		echo "<br>part_answer_show";
		print_r($part_answer[$i]);

/*
			$syuukeicounter = count($syuukei);
			echo "<table border=2>";
			foreach($syuukei as $key5 => $count2){
				echo "<tr>";
				echo "<td>".$key5."</td>";
				echo "<td>".$count2."</td>";
				echo "</tr>";

			}
			echo "</table>";
			*/
	}

	echo "<br>part_answer";
	print_r($part_answer);
	//echo "<br>syuukei";
	//print_r($syuukei);

}


/*
echo "<table border=2>";
foreach($syuukei as $key4 => $value_all_answer2){
	var_dump($key4);
	//var_dump($value_all_answer2);
	echo "<tr>";
	echo "<td>".$key4."</td>";
	echo "<td>".$value_all_answer2."</td>";
	echo "</tr>";
}
echo "</table>";


//$answer = array_flatten($part_answer);
//var_dump($answer);
//解答数集計表作成
*/

foreach($part_answer as $array){
	echo "<br>";
	foreach($array as $key5 => $value_answer_array){
		$syuukei = array_count_values($array);
		echo "<br>";
		print_r($syuukei);
	}
		echo "<table border=2>";
		echo "<br>";
		foreach($syuukei as $key6 => $value_answer_array2){
			echo "<tr>";
			echo "<td>".$value_answer_array2."</td>";
			echo "<td>".$key6."</td>";
			echo "</tr>";
		}
		echo "</table>";
	}



