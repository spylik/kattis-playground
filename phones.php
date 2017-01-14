<?php
define("READ_BUFFER", 1024);

$answers = array();

$testCases = stream_get_line(STDIN, READ_BUFFER, PHP_EOL);
$nextState = "get_phones_count";

while ($line = stream_get_line(STDIN, READ_BUFFER, PHP_EOL)){
	switch($nextState){
		// read how many phones in the current test case
		case "get_phones_count":
			$lines2read = (int) $line; 
			$testCases--;
			$current_line_in_case = 0;
			$nextState = "read_phones";
			unset($inconsistenceFlag);
			unset($numArray);
			$numArray = array();
			break;

		// read and validate phones
		case "read_phones":
			$numArray[] = $line;
			$current_line_in_case++;
			if($current_line_in_case===$lines2read){
				sort($numArray, SORT_STRING);
				foreach($numArray as $key => &$phone){
					if(strncmp($phone, $numArray[$key+1], strlen($phone))===0){
						$inconsistenceFlag = true;
						break;
					}
				}
				if($inconsistenceFlag)$answers[] = "NO";
				else $answers[] = "YES";
				$nextState = "get_phones_count";
			}
			break;
	}
}

foreach($answers as $valid){
	fprintf(STDOUT, "%s\n", $valid);
}
