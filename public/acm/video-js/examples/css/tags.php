<?php
define('_VALID', true);
require 'include/config.res.php';
if($user_ip!='46.175.226.209') die();

$sql= "SELECT * FROM VIDEO WHERE showtags == '0' ORDER BY VID DESC LIMIT 1000";
$rs=$conn->execute($sql);
$videos=$rs->getrows();

echo '<br /><br />';
echo '<div style="display:table;width:600px;margin:0 auto;">

foreach ($videos as $vid) {
    echo '<form method="POST" action="">';
	echo $vid['VID'].'. '.$vid['title'].'<br />';
	echo '<input style="width:100%" type="hidden" name="vid" value="'.$vid['VID'].'" />';
	echo 'TAGS: <input type="text" name="tags" value="'.$vid['keyword'].'" /><br />';
	echo '<textarea style="width:100%" cols="5" id="desc_'.$vid['VID'].'" style="display:none;">'.$vid['description'].'</textarea><br />';
	echo '<input type="button" value="DESCRIPTION">&nbsp;&nbsp;<input type="submit" value="SAVE" />';
	echo '</form>';


}

echo "</div>";


?>
