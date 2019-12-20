<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>集計結果</title>
    <link rel="stylesheet" href="css/style.css" />



</head>
<body>



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
$correct_answer_rate = array();
$n=0;
// 解答データをすべて配列の中に入れるメソッド
/*
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
}*/
//htmlエスケープ処理
function h($array) {
	if ( is_array($array) ) {
		return array_map( 'h', $array );
	} else {
		return htmlspecialchars( $array, ENT_QUOTES, 'UTF-8' );
	}
}
//問題文
while($result = $stmt0 ->fetch(PDO::FETCH_ASSOC)){
	echo '<h2>'.$result['name'].'</h2>';
	echo '<details>';
	echo '<summary>問題(クリックで展開)</summary>';
	echo $result['questiontext'];
	echo '</details>';
}
// 解答データの分割
while ( $result = $stmt2->fetch ( PDO::FETCH_ASSOC ) ) {
	$replace = 	preg_replace('/;{0,1} {0,1}パート \d+:/','aiueo',$result['rightanswer']);
	$replace2 = 	preg_replace('/;{0,1} {0,1}パート \d+:/','aiueo',$result['responsesummary']);
	$right_answer = explode ( 'aiueo', $replace );
	foreach($right_answer as $key => $value){
		$right_answer[$value] = htmlspecialchars($key,EMT_QUOTES);
	}
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
	$right_answer=h($right_answer);//htmlエスケープ処理

}
$part_answer=h($part_answer);//htmlエスケープ処理

// 解答数集計表作成
echo '<h3>解答集計結果</h3>';
echo '正答：<span class="green">緑</span>　解答率20％以上：<span class="red">赤</span>';
foreach ( $part_answer as $array ) {
	echo "<br>";
	foreach ( $array as $key => $value_answer_array ) {
		$people = count($array);
		$syuukei = array_count_values ($array);
		arsort($syuukei);

	}
	while($result = $stmt2->fetch ( PDO::FETCH_ASSOC )){
		$replace = 	preg_replace('/;{0,1} {0,1}パート \d+:/','aiueo',$result['rightanswer']);
		$right_answer = explode ( 'aiueo', $replace );
		$res=array_shift($right_answer);
	}
	$res=array_shift($right_answer);
	$n++;
	echo "<table>";
	echo '<caption>#'.$n.'正答:'.$res.'</caption>';

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
			echo '<tr bgcolor="#33FF66">';//正答なら緑
			array_push($correct_answer_rate,floor(($answer_count/$people)*100));

		}
		//if($value_answer==" "){
			//echo '<tr bgcolor="#EEEEEE">';
		//}
		else if(floor((($answer_count/$people)*100))>=20){
			echo '<tr bgcolor="pink">';//解答率20％以上
		}

		echo "<td>" . $value_answer . "</td>";
		echo "<td>" . $answer_count. "人</td>";
		echo "<td>".floor((($answer_count/$people)*100))."%</td>";
		echo "</tr>";

	}
	echo '</tbody>';
	echo "</table>";
	if(empty($correct_answer_rate[($n-1)])){
		array_push($correct_answer_rate,0);
	}

}
?>

        <!-- AJAX API のロード -->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">

      // Visualization API と折れ線グラフ用のパッケージのロード
       google.load("visualization", "1", {packages:["corechart"]});

      // Google Visualization API ロード時のコールバック関数の設定
      google.setOnLoadCallback(

      // グラフ作成用のコールバック関数
      function () {

        // データテーブルの作成
 var data = google.visualization.arrayToDataTable([
                ['','正解者割合'],
<?php foreach($correct_answer_rate as $key => $rate_value): ?>

                ['<?php echo '#'.($key+1) ?>',<?php echo $rate_value ?>],
                 <?php endforeach ?>
            ]);


        // グラフのオプションを設定
       var options = {
                title: '正答率(%)',
                hAxis: {title: '問題番号'}
            };

        // LineChart のオブジェクトの作成
         var chart = new google.visualization.ColumnChart(document.getElementById('gct_sample_column'));
        // データテーブルとオプションを渡して、グラフを描画
        chart.draw(data, options);
      }
      );
      </script>



   <!-- グラフを描く div 要素 -->
   <div id="gct_sample_column" style="width:80%; height:250pt" ></div>
</body>
</html>

