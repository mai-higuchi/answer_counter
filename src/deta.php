<?php
require_once ('sql.php');

//error_reporting(E_ALL & ~E_NOTICE);
//$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = 'SELECT itemid,finalgrade,AVG(finalgrade)as average From mdl_grade_grades WHERE finalgrade IS NOT NULL GROUP BY itemid
		UNION
		SELECT itemid,finalgrade,COUNT(*)AS ModeCount FROM mdl_grade_grades a WHERE finalgrade IS NOT NULL GROUP BY itemid,finalgrade
		HAVING COUNT(*)>=ALL (SELECT COUNT(*) FROM mdl_grade_grades b WHERE b.itemid=a.itemid GROUP BY finalgrade ORDER BY itemid,finalgrade)';
$stmt = $dbh->query($sql);
$stmt2 = $dbh->query($sql2);
//$stmt = $dbh->prepare('SELECT finalgrade From mdl_grade_grades');
echo '<table border=1>';
echo '<tr><th>テスト番号</th><th>平均</th></tr>';

while($result=$stmt->fetch(PDO::FETCH_ASSOC)){
	echo'<tr>';
	echo '<td>'.$result['itemid'].'</td>';
	echo '<td>'.$result['average'].'</td>';
	echo '<td>'.$result['finalgrade'].'</td>';
	echo '</tr>';
}
echo '</table>';

?>