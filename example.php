<?php
	include("twitter.php");
	$mytweet = new tweet("screen_name_here");
	echo $mytweet->ReturnTweet();
?>