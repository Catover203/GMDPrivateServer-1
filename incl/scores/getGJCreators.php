<?php
//Requesting files
chdir(dirname(__FILE__));
include "../lib/connection.php";
require_once "../lib/exploitPatch.php";
$ep = new exploitPatch();
//Getting data
$accountID = $ep->remove($_POST["accountID"]);
$type = $ep->remove($_POST["type"]);
//Checking if banned
$query = $db->prepare("SELECT * FROM users WHERE isCreatorBanned = '0' AND creatorPoints > 0  ORDER BY creatorPoints DESC LIMIT 100");
$query->execute([':stars' => $stars, ':count' => $count]);
$result = $query->fetchAll();
foreach($result as &$user){
	//Checking if is numeric
	if(is_numeric($user["extID"])){
		$extid = $user["extID"];
	}else{
		$extid = 0;
	}
	$xi++;
	$pplstring .= "1:".$user["userName"].":2:".$user["userID"].":13:".$user["coins"].":17:".$user["userCoins"].":6:".$xi.":9:".$user["icon"].":10:".$user["color1"].":11:".$user["color2"].":14:".$user["iconType"].":15:".$user["special"].":16:".$extid.":3:".$user["stars"].":8:".round($user["creatorPoints"],0,PHP_ROUND_HALF_DOWN).":4:".$user["demons"].":7:".$extid.":46:".$user["diamonds"]."|";
}
//Printing top creators
$pplstring = substr($pplstring, 0, -1);
echo $pplstring;
?>