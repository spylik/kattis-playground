<?php
define("READ_BUFFER", 1024);

fscanf(STDIN, "%d\n", $testCases);
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
			$length=strlen($line);
//			if(array_key_exists($line."\0", $numArray)){
//				$inconsistenceFlag = true;
//			}else{
				$numArray[$line."\0"] = $length;
//			}
			$current_line_in_case++;
			if($current_line_in_case===$lines2read){
				if(!$inconsistenceFlag){
					foreach($numArray as $key=>$ln){
						for ($i=0; $i<$ln-1; $i++) {
							$part=$part.$key[$i];
							if(array_key_exists($part."\0", $numArray)){
								$inconsistenceFlag = true;
								break;
							}
						}unset($part);
						if(isset($inconsistenceFlag))break;
					}
				}
				if($inconsistenceFlag)print_valid("NO");
				else print_valid("YES");
				$nextState = "get_phones_count";
			}
			break;
	}
}

function print_valid($valid){
	fprintf(STDOUT, "%s\n", $valid);
}
