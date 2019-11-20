<?php
require_once ('sql.php'); // 接続
$questionid = $_GET ['questionid'];
$testid = $_GET ['testid']; // id取得

// SQL
$sql0 = "SELECT DISTINCT questionid,a.id,questiontext,parent,name FROM mdl_question a,mdl_question_attempts b
WHERE parent = 0 AND a.id=b.questionid AND questionid=$questionid";
$sql = "SELECT questionid,rightanswer,questionsummary FROM mdl_question_attempts WHERE questionid='$questionid' GROUP BY questionid";
$sql2 = "SELECT questionid,responsesummary,questionsummary FROM mdl_question_attempts WHERE responsesummary IS NOT NULL AND questionid = '$questionid' ORDER BY responsesummary";
$i = 0;
$stmt0 = $dbh->query ( $sql0);
$stmt = $dbh->query ( $sql );
$stmt2 = $dbh->query ( $sql2 );
$part_answer = array ();
$syuukei = array ();
$answer = array ();
// 解答データをすべて配列の中に入れるメソッド
function array_flatten($array) {
	if (! is_array ( $array )) {
		return FALSE;
	}
	$result = array ();
	foreach ( $array as $key3 => $val ) {
		if (is_array ( $val )) {
			$result = array_merge ( $result, array_flatten ( $val ) );
		} else {
			$result [$key3] = $val;
		}
	}
	return $result;
}
//echo "テスト" . $testid . "<br>";
while($result5 = $stmt0 ->fetch(PDO::FETCH_ASSOC)){
	echo $result5['name'];
	echo $result5['questiontext'];
}
echo "正答";


// 正答表作成
while ( $result = $stmt->fetch ( PDO::FETCH_ASSOC ) ) {
	//echo "問題<br>";
	//echo "<th>" . $result ['questionsummary'] . "</th>";

	echo '<table border=2>';
	$right_answer = explode ( ';', $result ['rightanswer'] );

	foreach ( $right_answer as $key => $value_right_answer ) {
		echo "<tr>";
		echo "<td>" . $value_right_answer . "</td>";
		echo "</tr>";
	}
	echo '</table>';
}

// 解答データの分割
echo '<br>';
echo '解答集計結果<br>';
while ( $result2 = $stmt2->fetch ( PDO::FETCH_ASSOC ) ) {
	$all_answer = explode ( ';', $result2 ['responsesummary'] );
	// $answer[]=$all_answer;

	$counter = count ( $all_answer );

	for($i = 0; $i < $counter; $i ++) {
		//echo "i:" . $i . ":<br>";
		if (! isset ( $part_answer [$i] )) {
			$part_answer [$i] = array ();
		}
		array_push ( $part_answer [$i], array_shift ( $all_answer ) );
		//echo "<br>";
	}

	//echo "<br>part_answer";
	//print_r ( $part_answer );
}
// 解答数集計表作成

foreach ( $part_answer as $array ) {
	echo "<br>";
	foreach ( $array as $key5 => $value_answer_array ) {
		$people = count($array);
		$syuukei = array_count_values ($array);
		//array_flip($syuukei);
		//echo "<br>";
		//print_r ($syuukei);
	}
	echo "<table border=2>";
	echo "<br>";
	echo '<tr>';
	echo '<th>解答結果</th>';
	echo '<th>解答人数</th>';
	echo '<th>率</th>';
	echo '</tr>';

	foreach ( $syuukei as $value_answer => $answer_count ) {
		if(floor((($answer_count/$people)*100))>=40){
			echo '<tr bgcolor="red">';
		}else{
			echo "<tr>";
		}
		echo "<td>" . $value_answer . "</td>";
		echo "<td>" . $answer_count. "人</td>";
		echo "<td>".floor((($answer_count/$people)*100))."%</td>";
		echo "</tr>";
	}
	echo "</table>";
}



