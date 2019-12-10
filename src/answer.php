<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>小テスト集計</title>
    <link rel="stylesheet" href="style.css" />

</head>
<body>

</body>
</html>

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
	echo '<h1>'.$result5['name'].'</h1>';
	echo '<h2>問題</h2>';
	echo $result5['questiontext'];
}
// 解答データの分割

while ( $result2 = $stmt2->fetch ( PDO::FETCH_ASSOC ) ) {
	$replace = 	preg_replace('/;{0,1} {0,1}パート \d+:/','aiueo',$result2['rightanswer']);
	$replace2 = 	preg_replace('/;{0,1} {0,1}パート \d+:/','aiueo',$result2['responsesummary']);
	$right_answer = explode ( 'aiueo', $replace );
	$res=array_shift($right_answer);
	$all_answer = explode ('aiueo', $replace2 );
	$res=array_shift($all_answer);

	$counter = count ( $all_answer );

	for($i = 0; $i < $counter; $i ++) {
		if (! isset ( $part_answer [$i] )) {
			$part_answer [$i] = array ();
		}
			array_push ( $part_answer [$i], array_shift ( $all_answer ) );
	}
	print_r($right_answer);
}


// 解答数集計表作成
echo '<h3>解答集計</h3>';
echo '正答：<span class="yellow">黄色</span>　解答率20％以上：<span class="red">赤</span>　解答無し:<span class="blue">青</span>';
foreach ( $part_answer as $array ) {
	echo "<br>";
	foreach ( $array as $key5 => $value_answer_array ) {
		$people = count($array);
		$syuukei = array_count_values ($array);
		arsort($syuukei);

	}
	while($result2 = $stmt2->fetch ( PDO::FETCH_ASSOC )){
		$replace = 	preg_replace('/;{0,1} {0,1}パート \d+:/','aiueo',$result2['rightanswer']);
		$right_answer = explode ( 'aiueo', $replace );
		$res=array_shift($right_answer);
	}

	$res=array_shift($right_answer);
	$n++;
	echo "<table>";
	echo '<caption>#'.$n.'正答:'.$res.'</caption>';
	//echo "<br>";
	echo '<thead>';
	echo '<tr>';
	echo '<th>解答結果</th>';
	echo '<th>解答人数</th>';
	echo '<th>割合</th>';
	echo '</tr>';
	echo '</thead>';

	echo '<tbody>';
	foreach ( $syuukei as $value_answer => $answer_count ) {
		foreach($right_answer as $key => $value_right_answer){
		}
		if((strcmp($res,$value_answer))==0){
			echo '<tr bgcolor="#FFFF99 	">';
		}
		if($value_answer==" "){
			echo '<tr bgcolor="skyblue">';
		}else if(floor((($answer_count/$people)*100))>=20){
			echo '<tr bgcolor="pink">';
		}
		if((strcmp($res,$value_answer))==0){
			echo '<tr bgcolor="#FFFF99 	">';
		}

		echo "<td>" . $value_answer . "</td>";
		echo "<td>" . $answer_count. "人</td>";
		echo "<td>".floor((($answer_count/$people)*100))."%</td>";
		echo "</tr>";
	}
	echo '</tbody>';
	echo "</table>";
}



?>



