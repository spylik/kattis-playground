<?php
// Even we going implement it with php - we will keep things simple without any 
// layer of abstractions - we will just build simplest state machine.
define("MIN_TEST_CASES", 1);
define("MAX_TEST_CASES", 40);

define("MIN_PHONES_PER_CASE", 1);
define("MAX_PHONES_PER_CASE", 10000);

define("MAX_NUMBER_LENGTH", 10);

while (fscanf(STDIN, "%d\n", $number)) {
	switch($nextState){
		case NULL : 
			$testcases = $number;
			$nextState = "get_phones_count";
			break;

		case "get_phones_count": 
			$lines2read = $number; 
			$nextState = "read_phones";
			$n=0;
			break;

		case "read_phones":
			$n++;
			echo "phone $number pos $n\n";
			if($n===$lines2read){
				$nextState = "get_phones_count";
			}
			break;
	}
}
