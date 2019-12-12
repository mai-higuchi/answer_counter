<?php
require_once ('sql.php');
$uid = $_SESSION['uid'];
//var_dump($uid);
$sql = "SELECT * FROM mdl_user WHERE username='{$uid}'";
$stmt = $dbh->prepare ($sql);
$stmt->execute();
$sql2 = "SELECT distinct c.id,
                c.fullname,
                c.shortname,
                u.username,
                u.lastname,
                u.firstname
FROM mdl_course as c,
     mdl_role_assignments AS ra,
     mdl_role AS r,
     mdl_user AS u,
     mdl_context AS ct
WHERE c.id = ct.instanceid AND
      ra.roleid = r.id AND
      ra.userid = u.id AND
      ct.id = ra.contextid AND
u.username='{$uid}'
ORDER BY c.shortname ASC,
         r.shortname ASC,
         u.username ASC";
$stmt2 = $dbh->prepare ($sql2);
$stmt2->execute();
//while($result=$stmt->fetch(PDO::FETCH_ASSOC)){
	//echo "こんにちは".$result['lastname'].$result['firstname']."さん";
//}
//var_dump($stmt2);
echo "<th>科目選択</th>";
echo "<table border=2>";
while($result=$stmt2->fetch(PDO::FETCH_ASSOC)){
	//echo 'oeiua';
	echo '<tr>';
	echo '<td>'.$result['shortname'].'</td>';
	echo '<td><a href="?do=home&cid='.$result['id'].'">詳細</td>';
	echo "</tr>";
}
echo "</table>";
?>