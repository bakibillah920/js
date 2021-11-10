<?php
$link = mysql_connect('localhost', 'root', '');
if (!$link) {
    die('Not connected : ' . mysql_error());
}else{
	//echo 'Successfully Connected'.'<br />';
}
// make foo the current db
$db_selected = mysql_select_db('form', $link);
if (!$db_selected) {
    die ('Can\'t use foo : ' . mysql_error());
}else{
	//echo 'Successfully Selected DB'.'<br />';
}
?>