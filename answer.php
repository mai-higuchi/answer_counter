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
	$answer[]=$all_answer;
	echo "all_answer:";
	var_dump($all_answer);
	echo "<br>";

	echo "count";
	var_dump(count($all_answer));
	echo "<br>";


	echo "part_answer:";
	var_dump($part_answer);
	echo "<br>";

//	for($i=0;$i<count($all_answer);$i++){
	$counter = count($all_answer);

	for($i=0;$i<$counter;$i++){
		echo "i:".$i.":<br>";
		if(! isset($part_answer[$i])) {
			$part_answer[$i] = array();
		}
		array_push($part_answer[$i],array_shift($all_answer));

	}
	echo "<br>";
	print_r($part_answer);
	echo"<br>";


/*
	foreach($all_answer as $key => $all_answer_value){

		//$first_answer = array_column($all_answer,$key);
		//$part_answer[] = $first_answer;
		//var_dump($part_answer);
		//echo "<br>";

	}
		//var_dump($all_answer);
		//echo "<br>";
		///$first_ansewer = allay_column($all_answer,$key);
		//$part_answer = $first_answer;
		//
		//$i++;
/*
		$first_answer = array_shift($all_answer);
		var_dump($first_answer);
		echo "<br>";
		$part_answer[]= $first_answer;
		var_dump($part_answer);
		echo "<br>";
*/



	//

/*
	$part_answer[] =array_shift($all_answer);
	var_dump($all_answer);
	echo "<br>";
	var_dump($part_answer);
	echo "<br>";
	$part_answer2[]=array_shift($all_answer);
	var_dump($all_answer);
	echo "<br>";
	var_dump($part_answer2);
	echo "<br>";
	$part_answer3[]=array_shift($all_answer);
	var_dump($all_answer);
	echo "<br>";
	var_dump($part_answer3);
	echo "<br>";
*/


}



$answer = array_flatten($answer);
var_dump($answer);
//解答数集計表作成
/*
echo "<br>";
//var_dump($first_answer);
echo "<br>";
//var_dump($answer);
//$counter = array_count_values($first_answer);
//$counter2 = array_count_values($first_answer4);
echo "<br>";
//print_r($counter);
echo "<br>";
//print_r($counter2);

echo "<table border=2>";
foreach($counter as $key4 => $value_all_answer2){
	//var_dump($key4);
	echo "<tr>";
	echo "<td>".$key4."</td>";
	echo "<td>".$value_all_answer2."</td>";

	echo "</tr>";
}

echo "</table>";
*/