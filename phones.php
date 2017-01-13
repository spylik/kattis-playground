<?php
// Even we going implement it with php - we will keep things simple without any 
// layer of interfaces and classes - we will just build simplest state machine.
define("MIN_TEST_CASES", 1);
define("MAX_TEST_CASES", 40);

define("MIN_PHONES_PER_CASE", 1);
define("MAX_PHONES_PER_CASE", 10000);

define("MAX_NUMBER_LENGTH", 10);

define("READ_BUFFER", 1024);

while ($line = stream_get_line(STDIN, READ_BUFFER, PHP_EOL)){
	$int = line_to_int($line);
	switch($nextState){
		// read how many test cases do we have
		case NULL :
			if($int<MIN_TEST_CASES || $int>MAX_TEST_CASES)exit(2);
			$testCases = $int;
			$nextState = "get_phones_count";
			break;
		
		// read how many phones in the current test case
		case "get_phones_count":
			if($testCases===0)exit(4);
			if($int<MIN_PHONES_PER_CASE || $int>MAX_PHONES_PER_CASE)exit(3);
			$lines2read = $int; 
			$testCases--;
			$current_line_in_case = 0;
			$nextState = "read_phones";
			unset($numArray);
			$numArray = array();
			break;

		// read and validate phones
		case "read_phones":
			$length=strlen($line);
			if($length>MAX_NUMBER_LENGTH)exit(6);
			$current_line_in_case++;
			$numArray[$length][] = $line;
			if($current_line_in_case===$lines2read){
				check_consistent($numArray);
				$nextState = "get_phones_count";
			}
			break;
	}
}
if($testCases != 0)exit(5);

function line_to_int($string){
	$int = (int) $string;
	if(strlen($string) === strlen((string) $int))
		return $int;
	else
		exit(1);
}

function check_consistent($numArray) {
	$lenIndex = array_keys($numArray);
	sort($lenIndex,SORT_NUMERIC);
	$merged = array();
	foreach($lenIndex as &$value) {
		if(have_dupes($numArray[$value]) === true || is_prefixed($numArray[$value], $merged) === true){
			$inconsistenceFlag = true; break;
		}
		$merged = array_merge($merged, $numArray[$value]);
	}; unset ($value); unset ($merged);
	if(isset($inconsistenceFlag)) print_valid("NO");
	else print_valid("YES");
}

function is_prefixed($array, $prefixArray){
	if(count($prefixArray)==0){return false;}
	else{
		foreach ($array as &$value) {
			foreach($prefixArray as &$prefix){
				$compare = strpos($value, $prefix);
				if($compare===0){
					$inconsistenceFlag = true; break;
				}
			}unset($prefix);
			if($inconsistenceFlag) break;
		}unset($value);
	}
	if($inconsistenceFlag)return true;
	else return false;
}

function have_dupes($array) {
	if(count(array_unique($array))!=count($array))return true;
	else return false;
}

function print_valid($valid){
	fprintf(STDOUT, "%s\n", $valid);
}
