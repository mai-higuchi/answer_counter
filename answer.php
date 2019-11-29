<?php
require_once ('sql.php'); // 接続
$questionid = $_GET ['questionid'];
//$testid = $_GET ['testid']; // id取得

// SQL
$sql0 = "SELECT DISTINCT questionid,a.id,questiontext,parent,name FROM mdl_question a,mdl_question_attempts b
WHERE parent = 0 AND a.id=b.questionid AND questionid=$questionid";
$sql = "SELECT questionid,rightanswer,questionsummary FROM mdl_question_attempts WHERE questionid='$questionid' GROUP BY questionid";
$sql2 = "SELECT questionid,rightanswer,responsesummary,questionsummary FROM mdl_question_attempts WHERE responsesummary IS NOT NULL AND questionid = '$questionid' ORDER BY responsesummary";
$i = 0;
$stmt0 = $dbh->query ( $sql0);
$stmt = $dbh->query ( $sql );
$stmt2 = $dbh->query ( $sql2 );
$part_answer = array ();
$right_part_answer=array();
$syuukei = array ();
$answer = array ();
$n=0;
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

//$moji="パート1:犬;パート2:猫;";
//$replace = preg_replace('/;{0,1}パート\d+:/','aiueo',$moji);
//var_dump($replace);

// 正答表作成
while ( $result = $stmt->fetch ( PDO::FETCH_ASSOC ) ) {
	//echo "問題<br>";
	//echo "<th>" . $result ['questionsummary'] . "</th>";
	$replace = 	preg_replace('/;{0,1} {0,1}パート \d+:/','aiueo',$result['rightanswer']);
	echo '<table border=2>';
	$right_answer = explode ( 'aiueo', $replace );
	$res=array_shift($right_answer);

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
	$replace = 	preg_replace('/;{0,1} {0,1}パート \d+:/','aiueo',$result2['rightanswer']);
	$replace2 = 	preg_replace('/;{0,1} {0,1}パート \d+:/','aiueo',$result2['responsesummary']);
	//$replace = preg_replace('/;{0,1}パート \d+:/','aiueo',"パート1:犬;パート2:猫;");
	//$replace = preg_replace('/;{0,1} {0,1}パート \d+:/','aiueo',"パート 1: ネズミ; パート 2: イヌ; パート 3: ; パート 4: ; パート 5:");
	//print_r($replace);
	//echo "<br>";
	$right_answer = explode ( 'aiueo', $replace );
	$res=array_shift($right_answer);
	$all_answer = explode ('aiueo', $replace2 );
	$res=array_shift($all_answer);
	//echo "<br>解答";
	//print_r($all_answer);
	//echo"<br>正解";
	//print_r($right_answer);

	// $answer[]=$all_answer;

	$counter = count ( $all_answer );

	for($i = 0; $i < $counter; $i ++) {
		//echo "i:" . $i . ":<br>";
		if (! isset ( $part_answer [$i] )) {
			$part_answer [$i] = array ();
		}
		if (! isset ( $right_part_answer [$i] )) {
			$right_part_answer [$i] = array ();
		}
			array_push ( $part_answer [$i], array_shift ( $all_answer ) );
			//echo "<br>part_answer";
			//print_r ( $part_answer );
		//echo "<br>";
	}


	//echo "<br>right_answer";
	//print_r ( $right_part_answer );
}
// 解答数集計表作成

foreach ( $part_answer as $array ) {
	echo "<br>";
	foreach ( $array as $key5 => $value_answer_array ) {
		$people = count($array);
		$syuukei = array_count_values ($array);
		arsort($syuukei);

		//array_flip($syuukei);
		//echo "<br>";
		//print_r ($syuukei);
	}
	while($result2 = $stmt2->fetch ( PDO::FETCH_ASSOC )){
		$replace = 	preg_replace('/;{0,1} {0,1}パート \d+:/','aiueo',$result2['rightanswer']);
		$right_answer = explode ( 'aiueo', $replace );
		$res=array_shift($right_answer);
	}
	print_r($right_answer);
	$res=array_shift($right_answer);
	echo "<br>res";
	print_r($res);
	$n++;
	echo "<table border=2>";
	echo "<br>";
	echo '#'.$n;
	echo '<tr>';
	echo '<th>解答結果</th>';
	echo '<th>解答人数</th>';
	echo '<th>割合</th>';
	echo '</tr>';


	foreach ( $syuukei as $value_answer => $answer_count ) {
		foreach($right_answer as $key => $value_right_answer){
			//if((strcmp($res,$value_answer))==0){
				//echo '<tr bgcolor="yellow">';
			//}
		}
		if((strcmp($res,$value_answer))==0){
			echo '<tr bgcolor="yellow">';
		}
		if($value_answer==" "){
			echo '<tr bgcolor="skyblue">';
		}else if(floor((($answer_count/$people)*100))>=20){
			echo '<tr bgcolor="pink">';
		}
		if((strcmp($res,$value_answer))==0){
			echo '<tr bgcolor="yellow">';
		}



		echo "<td>" . $value_answer . "</td>";
		echo "<td>" . $answer_count. "人</td>";
		echo "<td>".floor((($answer_count/$people)*100))."%</td>";
		echo "</tr>";
	}

	echo "</table>";
}



