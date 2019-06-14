<?php

$game = isset($_POST["game"]) ? trim($_POST["game"]) : "";
$state = isset($_POST["state"]) ? json_decode($_POST["state"]) : [];

$theState = [];

// make sure passed in state is clean
for($i=0;$i<25;$i++) {
	if (isset($state[$i])) {
		$theState[$i] = ($state[$i] == 1) ? 1 : 0;
	} else {
		$theState[$i] = 0;
	}
}

if (strlen($game) == 7) {
	$tmp = explode("-",$game);
	$filename = "states/states-" . $tmp[0] . ".json";
	$gameID = $tmp[1];

	if (file_exists($filename)) {
		$json = file_get_contents($filename);
		$states = json_decode($json,true);
		for($i=0; $i<count($states); ++$i) {
			if ($states[$i]["game"] == $gameID) {
				$states[$i]["state"] = $theState;
			}
		}
		$json = json_encode($states);
		file_put_contents($filename,$json);
	}
}

?>