<?php

class number_word {
    
    function numtotext($num) 
	{
		$tdiv = array("cents ","rupiahs and ","hundred ","thousand ", "hundred ", 
		"million ", "hundred ","billion ");
		$divs = array( 0,0,0,0,0,0,0);
		$pos = 0; // index into tdiv;
		//make num a string, and reverse it, because we run through it backwards
		$num=strval(strrev(number_format($num,2,'.',''))); 
		$answer = ""; // build it up from here
		while (strlen($num)) {
		if ( strlen($num) == 1 || ($pos >2 && $pos % 2 == 1))  {
		$answer = $this->doone(substr($num,0,1)) . $answer;
		    $num= substr($num,1);
		}
		else {
		$answer = $this->dotwo(substr($num,0,2)) . $answer;
		$num= substr($num,2);
		if ($pos < 2)
			$pos++;
		}
		if (substr($num,0,1) == '.') {
		# if (! strlen($answer)) $answer = "zero ";
		# $answer = "dollars and " . $answer . "cents";
		$num= substr($num,1);
		// put in "zero" dollars if there are none
		if (strlen($num) == 1 && $num == '0') {
			$answer = "zero " . $answer;
			$num= substr($num,1);
		}
		}
		// add separator
		if ($pos >= 2 && strlen($num)) {
		if (substr($num,0,1) != 0  || (strlen($num) >1 && substr($num,1,1) != 0
			&& $pos %2 == 1)  ) {
			// check for missed millions and thousands when doing hundreds
			if ( $pos == 4 || $pos == 6 ) {
				if ($divs[$pos -1] == 0)
					$answer = $tdiv[$pos -1 ] . $answer;
			}
			// standard
			$divs[$pos] = 1;
			$answer = $tdiv[$pos++] . $answer;
		}
	 	else {
			$pos++;
		}
		}
		}
		return $answer;
	}

	function doone($onestr) 
	{
		$tsingle = array("","one ","two ","three ","four ","five ",
		"six ","seven ","eight ","nine ");

		return $tsingle[$onestr];
	}	

	function dotwo($twostr) 
	{
		$tdouble = array("","ten ","twenty ","thirty ","fourty ","fifty ",
		"sixty ","seventy ","eighty ","ninety ");
		$teen = array("ten ","eleven ","twelve ","thirteen ","fourteen ","fifteen ",
		"sixteen ","seventeen ","eighteen ","nineteen ");

		if ( substr($twostr,1,1) == '0') {
		$ret = $this->doone(substr($twostr,0,1));
		}
		else if (substr($twostr,1,1) == '1') {
		$ret = $teen[substr($twostr,0,1)];
		}
		else {
		$ret = $tdouble[substr($twostr,1,1)] . $this->doone(substr($twostr,0,1));
		}
		return $ret;
	}

} 

#
