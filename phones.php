<?php
// Even we going implement it with php - we will keep things simple without any 
// layer of interfaces and classes - we will just build simplest state machine.
define("MIN_TEST_CASES", 1);
define("MAX_TEST_CASES", 40);

define("MIN_PHONES_PER_CASE", 1);
define("MAX_PHONES_PER_CASE", 10000);

define("MAX_NUMBER_LENGTH", 10);

while ($line = fgets(STDIN)){
	$int = line_to_int($line);
	switch($nextState){
		// read how many test cases we have
		case NULL :
			if($int<MIN_TEST_CASES || $int>MAX_TEST_CASES)exit(2);
			$testCases = $int;
			$nextState = "get_phones_count";
			break;
		
		// read how many phones in the current test case
		case "get_phones_count":
//			echo"in get_phones_count current testCases $testCases\n";
			if($testCases===0)exit(4);
			if($int<MIN_PHONES_PER_CASE || $int>MAX_PHONES_PER_CASE)exit(3);
			$lines2read = $int; 
			$testCases--;
			$current_line_in_case = 0;
			$nextState = "read_phones";
			$valid = "NO";
			break;

		// read and validate phones
		case "read_phones":
			if(strlen($string)-1>MAX_NUMBER_LENGTH)exit(6);
			$current_line_in_case++;
//			echo "phone $int, current testCases $testCases, current lines2read $lines2read, current_line_in_case: $current_line_in_case\n";
			if($current_line_in_case===$lines2read){
				print_valid($valid);
				$nextState = "get_phones_count";
			}
			break;
	}
}
if($testCases != 0)exit(5);

function line_to_int($string){
	$int = (int) $string;
	if(strlen($string) === strlen((string) $int)+1)
		return $int;
	else
		exit(1);
}

function print_valid($valid){
	fprintf(STDOUT, "%s\n", $valid);
}
