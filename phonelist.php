<?php
/* Solution for kattis phonelist problem: (https://open.kattis.com/problems/phonelist)
 * Current implementation: 0.32s (top1 among other implementations in PHP dated on 14.01.2017)
*/

define("READ_BUFFER", 1024);

$answers = array();
$testCases = stream_get_line(STDIN, READ_BUFFER, PHP_EOL);

while($testCases!==0){
	unset($numArray);
	unset($inconsistenceFlag);
	$numArray = Array();
	for ($lines2read = stream_get_line(STDIN, READ_BUFFER, PHP_EOL); $lines2read>0; $lines2read--){
		$numArray[] = stream_get_line(STDIN, READ_BUFFER, PHP_EOL);
	}
	sort($numArray, SORT_STRING);
	foreach($numArray as $key => &$phone){
		if(isset($numArray[$key+1]) && strncmp($phone, $numArray[$key+1], strlen($phone))===0){
			$inconsistenceFlag = true;
			break;
		}
	}
	if($inconsistenceFlag)$answers[] = "NO";
	else $answers[] = "YES";
	$nextState = "get_phones_count";
	$testCases--;
}

foreach($answers as $valid){
	fprintf(STDOUT, "%s\n", $valid);
}
