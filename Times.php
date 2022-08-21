<?php
	/*
	Welcome to "Times"

	*** THIS FILE IS PENDING IMPLEMENTATION ***

	This is simply a collection of time and date utilities which I have found useful.  I am wrote this class in the form
	of a set of stand-alone static functions and in class form which make use of the static functions and provides for
	changing.

	I would appreciate any feedback you may have.
	*/
















	// Definitions
	//=============
	
	class Times
	{
		const ONE_SECOND  = 1;
		const ONE_MINUTE  = 60;         //         1 *  60 =         60
		const ONE_HOUR    = 3600;       //        60 *  60 =       3600
		const ONE_DAY     = 86400;      //      3600 *  24 =      86400
		const ONE_WEEK    = 604800;     //     86400 *   7 =     604800
		const ONE_MONTH   = 2592000;    //     86400 *  30 =    2592000
		const ONE_YEAR    = 31536000;   //     86400 * 365 =   31536000
		const ONE_DECADE  = 315360000;  //  31536000 *  10 =  315360000
		const ONE_CENTURY = 3153600000; // 315360000 *  10 = 3153600000
	}
	
	const DATE_BEGINNING_OF_TIME = -9999999999;
    const DATE_1900_01_01        = -2208970800;
    const DATE_1930_01_01        = -1262304000;
    const DATE_1970_01_21        =     1728000;
    const DATE_1970_01_22        =     1814400;
    const DATE_1970_01_23        =     1900800;
    const DATE_1970_01_24        =     1987200;
    const DATE_1970_04_21        =     9504000;
    const DATE_1970_04_22        =     9590400;
    const DATE_1970_04_23        =     9676800;
    const DATE_1970_04_24        =     9763200;
	const DATE_1982_01_01        =   378709200;
	const DATE_2004_10_12        =  1097539200;
	const DATE_2006_04_23        =  1145750400;
    const DATE_2006_04_30        =  1146355200;
    const DATE_2006_05_07        =  1146960000;
    const DATE_2006_05_14        =  1147564800;
    const DATE_2006_06_16        =  1150441200;
    const DATE_2006_10_10        =  1160438400;
    const DATE_2006_10_16        =  1160956800;
    const DATE_2006_10_23        =  1161561600;
    const DATE_2006_10_30        =  1162166400;
    const DATE_2006_11_06        =  1162771200;
    const DATE_2006_11_10        =  1163116800;
	const DATE_2006_11_20        =  1163980800;
	const DATE_2007_03_12        =  1173682800;
    const DATE_2007_03_19        =  1174287600;
    const DATE_2009_06_22        =  1245628800;
    const DATE_2009_07_06        =  1246838400;
    const DATE_2009_10_05        =  1254700800;
    const DATE_2009_10_12        =  1255305600;
    const DATE_2009_10_13        =  1255392000;
	const DATE_2009_10_19        =  1255910400;
	const DATE_2011_02_14        =  1297670400;
    const DATE_2011_02_22        =  1298361600;
    const DATE_2011_06_27        =  1307862000;
    const DATE_2011_07_05        =  1309849200;
    const DATE_2011_12_27        =  1324944000;
    const DATE_2012_05_07        =  1336374000;
    const DATE_2012_05_21        =  1337583600;
    const DATE_2012_05_29        =  1338274800;
    const DATE_2012_10_29        =  1351494000;
    const DATE_2012_11_05        =  1352102400;
    const DATE_2015_11_16        =  1447632000;
    const DATE_2015_11_23        =  1448236800;

	const DATE_INFINITY          =  9999999999;
	global $TIME_NOW; $TIME_NOW = time();

	function today() {
        return Dates::dayStartInt(time());
    }
	global $TIME_TODAY; $TIME_TODAY = today();
	
	
	
	// Digital Time Functions
	//========================
	
	// Function:  Convert an integer representing seconds into a string presenting hours and minutes
	function timeIsValidHoursMinutes($refString)
	{
		// Check for invalid format
		if( strrpos($refString, ":") === FALSE )
		{
			return FALSE;
		}
		
		// Get the components
		$bits = explode(":", $refString);
		
		// Check for invalid format
		if( count($bits) != 2 )
		{
			return FALSE;
		}
		
		// Check the minutes
		if( str_isValidInt($bits[0]) )
		{
			return FALSE;
		}
		
		// Check the seconds
		if( str_isValidInt($bits[1]) )
		{
			return FALSE;
		}
		if( strlen($bits[1]) > 2 )
		{
			return FALSE;
		}
		
		// If you are here, the result is good
		return TRUE;
	}
	
	
	
	// Function:  Convert an integer representing seconds into a string presenting hours and minutes
	function timeIntToHoursMinutes($refSecs, $switchAMPM=FALSE)
	{
		// Get the minutes
		$minutes = $refSecs / 60;
		
		// Get the hours
		$hours = (int)($minutes / 60);
		if( $hours > 24 )
		{
			$overMultiple = (int)($hours / 24);
			$hours = $hours - ($overMultiple * 24);
		}
		
		// Revise the minutes
		$minutes = (int)($minutes % 60);
		
		// Check for AM/PM designation requested
		$amPM = "";
		if( $switchAMPM )
		{
			if( $hours >= 12 )
			{
				$amPM = "PM";
				$hours = $hours - 12;
			}
			else
			{
				$amPM = "AM";
			}
			
			// Check for between 12 midnight and 1 AM or 12 noon and 1 PM
			if( $hours == 0 )
			{
				$hours = 12;
			}
		}
		
		// Compile the return value
		$returnValue = "";
		if( $switchAMPM )
		{
			$returnValue .= $hours;
		}
		else
		{
			$returnValue .= str_pad($hours,2,"0",STR_PAD_LEFT);
		}
		$returnValue .= ":" . str_pad($minutes,2,"0",STR_PAD_LEFT);
		if( $switchAMPM )
		{
			$returnValue .= " " . $amPM;
		}
		
		// Send back the result
		return $returnValue;
	}
	
	
	
	// Function:  Convert an integer representing seconds into a string presenting hours and minutes
	function timeHoursMinutesToInt($refString)
	{
		// Check for invalid format
		if( strpos($refString, ":") === FALSE )
		{
			return FALSE;
		}
		
		// Get the components
		$bits = explode(":", $refString);
		
		// Check for invalid format
		if( count($bits) != 2 )
		{
			return FALSE;
		}
		
		// Do the math
		return (((int)$bits[0])*3600) + (((int)$bits[1])*60);
	}
	
	
	
	// Date Functions
	//================
	
	class Dates
	{
		public $m_int;
		public $m_str;
		public $m_desig;
		public $m_type;
		
		
		
		public function __construct($dateInt = Constants::DEFAULT_INT, $dateDesig = Constants::DEFAULT_STR, $dateType = Constants::DEFAULT_STR, $dateStr = Constants::DEFAULT_STR)
		{
			$this->reset($dateInt, $dateDesig, $dateType, $dateStr);
		}
		
		private function nullify()
		{
			unset($this->m_int);
			unset($this->m_desig);
			unset($this->m_type);
			unset($this->m_str);
			unset($this->m_saveFlag);

			$this->m_int      = Constants::DEFAULT_INT;
			$this->m_desig    = Constants::DEFAULT_STR;
			$this->m_type     = Constants::DEFAULT_STR;
			$this->m_str      = Constants::DEFAULT_STR;
			$this->m_saveFlag = FALSE;
		}
		
		public function __destruct()
		{
			$this->nullify();
		}
		
		public function sanitize()
		{
			$temp =       (int)trim($this->m_int);   if( $this->m_int   != $temp ) { $this->m_int   = $temp; $this->m_SaveFlag = TRUE; }
			$temp = str_stringClean($this->m_desig); if( $this->m_desig != $temp ) { $this->m_desig = $temp; $this->m_SaveFlag = TRUE; }
			$temp = str_stringClean($this->m_type);  if( $this->m_type  != $temp ) { $this->m_type  = $temp; $this->m_SaveFlag = TRUE; }
			$temp = str_stringClean($this->m_str);   if( $this->m_str   != $temp ) { $this->m_str   = $temp; $this->m_SaveFlag = TRUE; }
		}
		
		public function condition()
		{
			// Standard clean-up
			$this->sanitize();
			
			// If you have the integer and the desig then set the string
			if( $this->m_int != Constants::DEFAULT_INT && $this->m_desig != Constants::DEFAULT_STR )
			{
				$convertedStr = Dates::convertIntToStr($this->m_int, $this->m_desig);
				$this->m_saveFlag = $convertedStr != Constants::DEFAULT_STR && $this->m_str != $convertedStr;
				$this->m_str      = $convertedStr;
			}

			// Move the integer to the start of the time block
            if( $this->m_int != Constants::DEFAULT_INT && $this->m_desig != Constants::DEFAULT_STR )
            {
                $beforeInt = $this->m_int;
                $beforeStr = Dates::convertIntToStr($this->m_int, $this->m_desig);
                $afterInt  = Constants::DEFAULT_INT;
                $afterStr  = Constants::DEFAULT_STR;
                switch($this->m_desig)
                {
                    case "YMD":
                        list($afterInt, $afterStr) = Dates::convertIntToStartOfDay($beforeInt);
                        break;
                    case "YM":
                        list($afterInt, $afterStr) = Dates::convertIntToStartOfMonth($beforeInt);
                        break;
                    case "Y":
                        list($afterInt, $afterStr) = Dates::convertIntToStartOfYear($beforeInt);
                        break;
                }
                $this->m_saveFlag = $afterInt != Constants::DEFAULT_INT &&
                                    $afterStr != Constants::DEFAULT_STR &&
                                    $beforeInt != $afterInt             &&
                                    $beforeStr == $afterStr;
                if( $this->m_saveFlag )
                {
                    $this->m_int = $afterInt;
                    $this->m_str = $afterStr;
//echo("beforeInt=" . $beforeInt . ", beforeStr=" . $beforeStr . ", afterInt=" . $afterInt . ", afterStr=" . $afterStr . "<br>\n");
                }


            }

			
			
			
			
			
			
			
			
			
		}

		public static function dayStartInt(int $date) {
		    return Dates::convertStrToInt(Dates::convertIntToStr($date));
        }
		
		public static function errorCheckCollection(&$dateInt = Constants::DEFAULT_INT, &$dateDesig = Constants::DEFAULT_STR, &$dateType = Constants::DEFAULT_STR, &$dateStr = Constants::DEFAULT_STR)
		{
			// Condition & Error Check:  Desig
			$dateDesig = trim($dateDesig);
			if( !Dates::isValidDesig($dateDesig) && $dateDesig != "" )
			{
				logError("Date::errorCheckCollection - Invalid paramter - dateDesig(" . $dateDesig . ") - Trace:  " . getBackTraceStr());
				return FALSE;
			}
			
			// Condition & Error Check:  Type
			$dateType = trim($dateType);
			if( !Dates::isValidType($dateType) && $dateType != "" )
			{
				logError("Date::errorCheckCollection - Invalid paramter - dateType(" . $dateType . ") - Trace:  " . getBackTraceStr());
				return FALSE;
			}
			
			// Error Check:  Missing parameters
			if( ($dateDesig != Constants::DEFAULT_STR && $dateInt == Constants::DEFAULT_INT)                                          ||
			    ($dateType != Constants::DEFAULT_STR && $dateType != "U" && ($dateInt == Constants::DEFAULT_INT || $dateDesig == Constants::DEFAULT_STR)) )
			{
				logError("Date::errorCheckCollection - Missing paramter - dateInt(" . $dateInt . "), dateDesig(" . $dateDesig . "), dateType(" . $dateType . ") - Trace:  " . getBackTraceStr());
				return FALSE;
			}
			
			// Error Check and Condition:  Integer
			$dateInt = (int)$dateInt;
			if( gettype($dateInt) == "integer" || str_isValidInt($dateInt) )
			{
				// Do nothing
			}
			else
			{
				logError("Date::errorCheckCollection - Invalid parameter - dateInt(" . $dateInt . ") - Trace:  " . getBackTraceStr());
				return FALSE;
			}
			
			// If here it is all good
			return TRUE;
		}
		
		public function reset($dateInt = Constants::DEFAULT_INT, $dateDesig = Constants::DEFAULT_STR, $dateType = Constants::DEFAULT_STR, $dateStr = Constants::DEFAULT_STR)
		{
			// Wipe out the currrent members
			$this->nullify();
			
			// If there is no date integer, but there is a date string, populate the integer and desig based on the string
			if( $dateInt == Constants::DEFAULT_INT && $dateStr != Constants::DEFAULT_STR )
			{
				$standardizedStr = Dates::standardizeStr($dateStr);
				if( $standardizedStr == "" )
				{
					logError("Date::reset - Unable to handle parameter - dateStr(" . $dateStr . ") - Trace:  " . getBackTraceStr());
				}
				$dateInt   = Dates::convertStrToInt($standardizedStr);
				$dateDesig = Dates::convertStrToDesig($standardizedStr);
			}
			
			// Look for errors in the parameters
			if( Dates::errorCheckCollection($dateInt, $dateDesig, $dateType, $dateStr) )
			{
				$this->m_int   = $dateInt;
				$this->m_desig = $dateDesig;
				$this->m_type  = $dateType;
				$this->m_str   = $dateStr;
			}
			else
			{
				return FALSE;
			}
			
			// Conditioning
			$this->condition();
			
			// If here all is well, so get out!
			return TRUE;
		}
		
		public function resetStr($dateStr = Constants::DEFAULT_STR)
		{
			return $this->resetStr(Constants::DEFAULT_INT, Constants::DEFAULT_STR, Constants::DEFAULT_STR, $dateStr);
		}
		
		public function getArr()
		{
			return array($this->m_int, $this->m_desig, $this->m_type, $this->m_str);
		}
		
		public function getComponents(&$theInt, &$theDesig, &$thisType, &$theStr)
		{
			list($theInt, $theDesig, $thisType, $theStr) = $this->getArr();
		}
		


		
		// Integer to string conversions
		
		public static function isValidDesig($refDesig)
		{
			return 	$refDesig == "YMD" || $refDesig == "YM" || $refDesig == "Y";
		}
		
		public static function convertIntToStr($refDateInt, $refDateDesig="YMD")
		{
			if( $refDateInt   ==  0 ||
			    $refDateDesig == "" )
			{
				return "";
			}
			
			switch($refDateDesig)
			{
				case "YMD" :
				{
					return date('Y-m-d', $refDateInt);
				}
				case "YM" :
				{
					return date('Y-m', $refDateInt);
				}
				case "Y" :
				{
					return date('Y', $refDateInt);
				}
				default :
				{
					logError("Dates::convertIntToStr - ERROR - Invalid date designation format [" . $refDateDesig . "]");
					return "";
				}
			}
		}
		
		public static function guessIntToStr($refDateInt)
		{
			// Try just the year first
			$yearStr = date('Y', $refDateInt);
			$yearInt = strtotime($yearStr . "-01-01");
			if( $refDateInt == $yearInt ) return $yearStr;
			
			// Determine the month
			$monthStr = "";
			for( $monthIndex = 12; $monthIndex >= 1; $monthIndex-- )
			{
				$monthStr   = "-" . str_safePad($monthIndex, 2, "0", STR_PAD_LEFT);
				$theDateStr = $yearStr . $monthStr;
				$theDateInt = strtotime($theDateStr);
				if( $refDateInt == $theDateInt ) return $yearStr . $monthStr;
				else if( $refDateInt  > $theDateInt ) break;
			}
			
			// Determine in which month
			for( $dayIndex = 31; $dayIndex >= 1; $dayIndex-- )
			{
				$dayStr = "-" . str_safePad($dayIndex, 2, "0", STR_PAD_LEFT);
				$theDateStr = $yearStr . $monthStr . $dayStr;
				$theDateInt = strtotime($theDateStr);
				if( $refDateInt >= $theDateInt ) return $theDateStr;
			}
			
			// Should not execute here, but if it does
			// just go with the year and month
			return $yearStr . $monthStr;
		}
		
		
		
		// String to integer conversions
		
		public static function isValidYearStr($refStr)
		{
			if( preg_match("/^(\d\d\d\d)$/", $refStr) == 0 ) return FALSE;
			$refInt = (int)$refStr;
			if( $refInt < 1900 ) return FALSE;
			$currentYear = (int)date("Y");
			return $refInt <= $currentYear;
		}
		
		public static function convertStrToInt($refDateString)
		{
//logError("convertStrToInt - refDateString 1:" . str_displayOrds($refDateString));
            $refDateString = trim($refDateString);
//logError("convertStrToInt - refDateString 2:" . str_displayOrds($refDateString));
			if( $refDateString == "" )
			{
//logError("convertStrToInt - refDateString 2a:" . str_displayOrds($refDateString));
				return 0;
			}
//logError("convertStrToInt - refDateString 3:" . str_displayOrds($refDateString));
			$theDate = str_replace("/", "-", $refDateString);
			
			if( preg_match("/(\d\d\d\d)-(\d\d)-(\d\d)/", $theDate) ||
			    preg_match("/(\d\d\d\d)-(\d)-(\d)/",     $theDate) ||
			    preg_match("/(\d\d\d\d)-(\d\d)-(\d)/",   $theDate) ||
			    preg_match("/(\d\d\d\d)-(\d)-(\d\d)/",   $theDate) )
			{
				// Do nothing
			}
			else  if( preg_match("/(\d\d\d\d)-(\d\d)/", $theDate) ||
				    preg_match("/(\d\d\d\d)-(\d)/",   $theDate) )
			{
				$theDate .= "-01";
			}
			else  if( preg_match("/(\d\d\d\d)/", $theDate) )
			{
				$theDate .= "-01-01";
			}
			
			// Handle the epoch special case since the AV is to recognize 0 as no date rather than the first of January 1970
			if( $theDate == "1970"       ||
			    $theDate == "1970-01"    ||
			    $theDate == "1970-01-01" )
			{
				return 1;
			}
			
			return strtotime($theDate);
		}
		
		
		
		// Designation utilities
		
		public static function convertStrToDesig($refDateString)
		{
			if( $refDateString == "" )
			{
				return "";
			}
			$theDate = str_replace("/", "-", $refDateString);
			
			if( preg_match("/(\d\d\d\d)-(\d\d)-(\d\d)/", $theDate) ||
			    preg_match("/(\d\d\d\d)-(\d)-(\d)/",     $theDate) ||
			    preg_match("/(\d\d\d\d)-(\d\d)-(\d)/",   $theDate) ||
			    preg_match("/(\d\d\d\d)-(\d)-(\d\d)/",   $theDate) )
			{
				return "YMD";
			}
			else  if( preg_match("/(\d\d\d\d)-(\d\d)/", $theDate) ||
				      preg_match("/(\d\d\d\d)-(\d)/",   $theDate) )
			{
				return "YM";
			}
			else  if( preg_match("/(\d\d\d\d)/", $theDate) )
			{
				return "Y";
			}
			
			return "";
		}
		
		
		
		// Type utilities
		
		public static function conditionType($refType)
		{
			$aType = strtolower($refType);
			switch($aType)
			{
				case "o"            :
				case "on"           : $aType="O"; break;
				case "b"            :
				case "by"           : $aType="B"; break;
				case "c"            :
				case "circa"        : $aType="C"; break;
				case "a"            :
				case "after"        : $aType="A"; break;
				case "u"            :
				case "unknown"      : $aType="U"; break;
				case "f"            :
				case "fs"           :
				case "first"        :
				case "firstspotted" : $aType="F"; break;
				case "l"            :
				case "ls"           :
				case "last"         :
				case "lastspotted"  : $aType="L"; break;
				default             : $aType="";
			}
			return $aType;
		}
		
		public static function isValidType($refType)
		{
			return $refType == "O" || $refType == "B" || $refType == "C" || $refType == "A" || $refType == "U" || $refType == "F" || $refType == "L";
		}
		
		
		
		// Other utilities
		
		public static function isValidStr($refDateString)
		{
			if( preg_match("/(\d\d\d\d)-(\d\d)-(\d\d)/", $refDateString) ||
			    preg_match("/(\d\d\d\d)-(\d)-(\d)/",     $refDateString) ||
			    preg_match("/(\d\d\d\d)-(\d\d)-(\d)/",   $refDateString) ||
			    preg_match("/(\d\d\d\d)-(\d)-(\d\d)/",   $refDateString) ||
			    preg_match("/(\d\d\d\d)-(\d\d)/",        $refDateString) ||
			    preg_match("/(\d\d\d\d)-(\d)/",          $refDateString) )
			{
				return TRUE;
			}
			if( preg_match("/(\d\d\d\d)/", $refDateString) &&
			    strlen($refDateString) == 4 )
			{
				return TRUE;
			}
			return FALSE;
		}

        public static function convertToExtendedStr($theTime=0)
		{
			$theTime = (int)$theTime;
			$theTime = $theTime == 0 ? time() : $theTime;
			return date("Y-m-d H:i:s", $theTime);
		}
		
		
		
		public static function convertToDescriptiveStr($refDateInt, $refDateDesig, $refDateType)
		{
			if( !($refDateDesig == "YMD" || $refDateDesig == "YM" || $refDateDesig == "Y") ||
			    !($refDateType  == "O"   || $refDateType  == "B"  || $refDateType  == "C"  || $refDateType  == "A" || $refDateType  == "U" || $refDateType  == "F" || $refDateType  == "L") )
			{
				return "";
			}
			
			$prefix = "";
			switch($refDateType)
			{
				case "U" :
				{
					return "Unknown";
				}
				case "B" :
				{
					$prefix = "By ";
					break;
				}
				case "O" :
				{
					if( $refDateDesig == "YMD" ) $prefix = "On ";
					else $prefix = "In ";
					break;
				}
				case "C" :
				{
					$prefix = "Circa ";
					break;
				}
				case "A" :
				{
					$prefix = "After ";
					break;
				}
				case "F" :
				{
					$prefix = "First spotted ";
					break;
				}
				case "L" :
				{
					$prefix = "Last spotted ";
					break;
				}
			}
			
			$dateString = "";
			switch($refDateDesig)
			{
				case "YMD" :
				{
					$dateString = date('j F Y', $refDateInt);
					break;
				}
				case "YM" :
				{
					$dateString = date('F Y', $refDateInt);
					break;
				}
				case "Y" :
				{
					$dateString = date('Y', $refDateInt);
					break;
				}
			}
			
			return ($prefix . $dateString);
		}
		
		public static function convertIntToStartOfDay($inputDateInt)
		{
	        $dateStr    = Dates::convertIntToStr($inputDateInt);
        	$newDateInt = Dates::convertStrToInt($dateStr);
        	$newDateStr = Dates::convertIntToStr($newDateInt);
        	
        	return array($newDateInt, $newDateStr);
		}
		
		public static function convertIntToStartOfWeek($inputDateInt)
		{
			$dayOfWeek  = date("w", $inputDateInt); // 0 - 6
			$resultDateInt = $inputDateInt - ($dayOfWeek * Times::ONE_DAY);
			$resultDateStr = Dates::convertIntToStr($resultDateInt);
			return array($resultDateInt, $resultDateStr);
		}
		
		public static function convertIntToStartOfMonth($inputDateInt)
		{
			$resultDateStr = date("Y-m", $inputDateInt); // YYYY-MM
			$resultDateInt = Dates::convertStrToInt($resultDateStr);
			return array($resultDateInt, $resultDateStr);
		}
		
		public static function convertIntToStartOfYear($inputDateInt)
		{
			$resultDateStr = date("Y", $inputDateInt); // YYYY
			$resultDateInt = Dates::convertStrToInt($resultDateStr);
			return array($resultDateInt, $resultDateStr);
		}
		
		private static function yearPad($refYearInt)
		{
			static $thisYearTwoDigit = NULL;
            $thisYearTwoDigit = ($thisYearTwoDigit === NULL) ? (int)date('y') : $thisYearTwoDigit;
			if( $refYearInt <= $thisYearTwoDigit )
			{
				$refYearInt = 2000 + $refYearInt;
			}
			else if( $refYearInt < 100 )
			{
				$refYearInt = 1900 + $refYearInt;
			}
			return $refYearInt;
		}
		
		private static function monthStrToInt($refMonthStr)
		{
			switch($refMonthStr)
			{
				case "jan" : return 1;
				case "feb" : return 2;
				case "mar" : return 3;
				case "apr" : return 4;
				case "may" : return 5;
				case "jun" : return 6;
				case "jul" : return 7;
				case "aug" : return 8;
				case "sep" : return 9;
				case "oct" : return 10;
				case "nov" : return 11;
				case "dec" : return 12;
				return 0;
			}
		}
		
		private static function isValidDayMonthPair($refDayInt, $refMonthInt)
		{
			if( $refMonthInt == 2 &&
			    $refDayInt   >= 1 &&
			    $refDayInt   <= 29 )
			{
				return TRUE;
			}
			if( ($refMonthInt == 1 || $refMonthInt == 3 || $refMonthInt == 5 || $refMonthInt == 7 || $refMonthInt == 8 || $refMonthInt == 10 || $refMonthInt == 12) &&
			    $refDayInt >= 1 &&
			    $refDayInt <= 31 )
			{
				return TRUE;
			}
			if( ($refMonthInt == 4 || $refMonthInt == 6 || $refMonthInt == 9 || $refMonthInt == 11) &&
			    $refDayInt >= 1 &&
			    $refDayInt <= 30 )
			{
				return TRUE;
			}
			return FALSE;
		}
		
		public static function standardizeStr($refDateString)
		{
			// Conditioning, Part 1
			$refDateString = trim($refDateString);
			$refDateString = str_replace("/",   "-", $refDateString);
			$refDateString = str_replace(".",   " ", $refDateString);
			
			// Check for empty parameter
			if( $refDateString === ""   ||
			    $refDateString === 0    ||
			    $refDateString === NULL )
			{
				return "";
			}
			
			// Send back standard format:  1946-09-23
			if( Dates::isValidStr($refDateString) )
			{
				return $refDateString;
			}
			
			// Conditioning, Part 2 - Remove days of the week
			$refDateString = strtolower($refDateString);
			$refDateString = str_replace("sunday",    "", $refDateString);
			$refDateString = str_replace("monday",    "", $refDateString);
			$refDateString = str_replace("tuesday",   "", $refDateString);
			$refDateString = str_replace("wednesday", "", $refDateString);
			$refDateString = str_replace("thursday",  "", $refDateString);
			$refDateString = str_replace("friday",    "", $refDateString);
			$refDateString = str_replace("saturday",  "", $refDateString);
			
			
			// Conditioning, Part 3 - Standardize month designations
			$refDateString = str_replace("january",   "jan", $refDateString);
			$refDateString = str_replace("february",  "feb", $refDateString);
			$refDateString = str_replace("febr",      "feb", $refDateString);
			$refDateString = str_replace("march",     "mar", $refDateString);
			$refDateString = str_replace("april",     "apr", $refDateString);
			$refDateString = str_replace("mai",       "may", $refDateString);
			$refDateString = str_replace("june",      "jun", $refDateString);
			$refDateString = str_replace("july",      "jul", $refDateString);
			$refDateString = str_replace("august",    "aug", $refDateString);
			$refDateString = str_replace("september", "sep", $refDateString);
			$refDateString = str_replace("sept",      "sep", $refDateString);
			$refDateString = str_replace("october",   "oct", $refDateString);
			$refDateString = str_replace("november",  "nov", $refDateString);
			$refDateString = str_replace("december",  "dec", $refDateString);
			
			// Conditioning, Part 4 - Ensure one delimiter type
			$refDateString = str_replace("jan",  "-jan-", $refDateString);
			$refDateString = str_replace("feb",  "-feb-", $refDateString);
			$refDateString = str_replace("mar",  "-mar-", $refDateString);
			$refDateString = str_replace("apr",  "-apr-", $refDateString);
			$refDateString = str_replace("may",  "-may-", $refDateString);
			$refDateString = str_replace("jun",  "-jun-", $refDateString);
			$refDateString = str_replace("jul",  "-jul-", $refDateString);
			$refDateString = str_replace("aug",  "-aug-", $refDateString);
			$refDateString = str_replace("sept", "-sep-", $refDateString);
			$refDateString = str_replace("sep",  "-sep-", $refDateString);
			$refDateString = str_replace("oct",  "-oct-", $refDateString);
			$refDateString = str_replace("nov",  "-nov-", $refDateString);
			$refDateString = str_replace("dec",  "-dec-", $refDateString);
			$refDateString = str_replace(" ",    "-",     $refDateString);
			$refDateString = str_replace(",",    "-",     $refDateString);
			
			// Conditioning, Part 5 - Remove modifiers
			$refDateString = str_replace("1st", "1", $refDateString);
			$refDateString = str_replace("2nd", "2", $refDateString);
			$refDateString = str_replace("3rd", "3", $refDateString);
			$refDateString = preg_replace("/(\d+)th/", "$1", $refDateString);
			
			// Remove duplicate delimiters
			$before = "";
			$after = $refDateString;
			while( $before != $after )
			{
				$before = $after;
				$after = str_replace("--",  "-", $before);
			}
			$refDateString = trim($after, "-");
			
			// Break date into components
			$dateArray = explode("-", $refDateString);
			$countDelimitted = count($dateArray);
			
			// Check for obviously invalid format
			if( $countDelimitted > 3 ) return "";
			
			// Account for the format 19460923 and condition as if it were 1946-09-23
			if( str_isValidInt($refDateString) && $countDelimitted == 1 )
			{
				$len = strlen($refDateString);
				
				// Handle 19460923 as if it were 1946-09-23
				if( $len == 8 )
				{
					// Break into components
					$theDate = substr($refDateString,0,4) . "-" .
						      substr($refDateString,4,2) . "-" .
						      substr($refDateString,6,2);
					
					// Check for the standard format
					if( Dates::isValidStr($theDate) )
					{
						return $theDate;
					}
				}
				
				// Handle 072669 as if it were 1969-07-26
				else if( ($len == 5)  || ($len == 6) )
				{
					$day   = "";
					$month = "";
					$year  = "";
					
					if( $len == 5 )
					{
						$month = substr($refDateString,0,1);
						$day   = substr($refDateString,1,2);
						$year  = substr($refDateString,3,2);
					}
					else if( $len == 6 )
					{
						$month = substr($refDateString,0,2);
						$day   = substr($refDateString,2,2);
						$year  = substr($refDateString,4,2);
					}
					
					$day   = str_pad($day, 2, "0", STR_PAD_LEFT);
					$month = str_pad($month, 2, "0", STR_PAD_LEFT);
					$year  = Dates::yearPad($year);
					
					if( !Dates::isValidDayMonthPair($day, $month) )
					{
						$temp  = $day;
						$day   = $month;
						$month = $temp;
					}
					
					if( Dates::isValidDayMonthPair($day, $month) )
					{
						$theDate = $year . "-" . $month . "-" . $day;
						
						if( Dates::isValidStr($theDate) )
						{
							return $theDate;
						}
					}
				}
				
				// If here assume it is seconds since 1970
				else if( !(($len == 2) || ($len == 4)) )
				{
					return Dates::convertIntToStr((int)$refDateString);
				}
			}
			
			// Convert formats:  46, 1946
			if( $countDelimitted == 1 &&
				str_isValidInt($refDateString) )
			{
				$yearInt = (int)($refDateString);
				return Dates::yearPad($yearInt);
			}
			
			// Check for existance of the month in text format
			if( preg_match("/[a-z]{3}/", $refDateString) )
			{
				// Check for only two components
				if( $countDelimitted == 2 )
				{
					// Convert formats:  sep-46
					$monthInt = Dates::monthStrToInt($dateArray[0]);
					if( $monthInt != 0 )
					{
						// Get the year number
						$yearString = trim($dateArray[1]);
						$yearInt = (int)$yearString;
						
						// Ensure it is an integer representation of the year
						if( $yearString == (string)$yearInt )
						{
							// Condition the year value to four digits
							$yearInt = Dates::yearPad($yearInt);
							
							// Compile the string and send it back
							$date = (string)$yearInt .
									"-" .
									str_pad($monthInt, 2, "0", STR_PAD_LEFT);
							return $date;
						}
					}
					
					// Convert formats:  46-sep
					$monthInt = Dates::monthStrToInt($dateArray[1]);
					if( $monthInt != 0 )
					{
						// Get the year number
						$yearString = trim($dateArray[0]);
						$yearInt = (int)$yearString;
						
						// Ensure it is an integer representation of the year
						if( $yearString == (string)$yearInt )
						{
							// Condition the year value to four digits
							$yearInt = Dates::yearPad($yearInt);
							
							// Compile the string and send it back
							$date = (string)$yearInt . "-" .
									str_pad($monthInt, 2, "0", STR_PAD_LEFT);
							return $date;
						}
					}
				}
				
				// Convert formats:  sep-23-46, 23-sep-46
				if( $countDelimitted == 3 )
				{
					// Declare the containers
					$yearInt  = 0;
					$monthInt = 0;
					$dayInt   = 0;
					
					// Case:  Month in first position (sep-23-46)
					$monthInt = Dates::monthStrToInt($dateArray[0]);
					if( $monthInt != 0 &&
						str_isValidInt($dateArray[1]) &&
						str_isValidInt($dateArray[2]) )
					{
						// Assume day-year at first
						$dayInt  = (int)$dateArray[1];
						$yearInt = (int)$dateArray[2];
							
						// Check for not day-year
						if( !Dates::isValidDayMonthPair($dayInt, $monthInt) )
						{
							$dayInt  = (int)$dateArray[2];
							$yearInt = (int)$dateArray[1];
						}
					}
					
					// Case:  Month in second position (23-sep-46)
					else
					{
						$monthInt = Dates::monthStrToInt($dateArray[1]);
						if( $monthInt != 0 &&
							str_isValidInt($dateArray[0]) &&
							str_isValidInt($dateArray[2]) )
						{
							// Assume day-year at first
							$dayInt  = (int)$dateArray[0];
							$yearInt = (int)$dateArray[2];
							
							// Check for not day-year
							if( !Dates::isValidDayMonthPair($dayInt, $monthInt) )
							{
								$dayInt  = (int)$dateArray[2];
								$yearInt = (int)$dateArray[0];
							}
						}
					}
					
					// Check for successful extraction
					if( $yearInt  != 0 &&
						$monthInt != 0 &&
						$dayInt   != 0 )
					{
						$yearInt = Dates::yearPad($yearInt);
						return ( $yearInt . "-" . 
								 str_pad($monthInt, 2, "0", STR_PAD_LEFT) . "-" .
								 str_pad($dayInt, 2, "0", STR_PAD_LEFT) );
					}
					else
					{
						return "";
					}
				}
			}
			
			// Convert formats:  8-77, 77-8
			if( $countDelimitted == 2          &&
			    str_isValidReal($dateArray[0]) &&
			    str_isValidReal($dateArray[1]) )
			{
				// Declare containers
				$yearInt  = 0;
				$monthInt = 0;
				
				// Figure out which part is the year
				$part1 = (int)$dateArray[0];
				$part2 = (int)$dateArray[1];
				if( $part1 > 12 )
				{
					$yearInt = $part1;
					$monthInt = $part2;
				}
				else if( $part2 > 12 )
				{
					$yearInt = $part2;
					$monthInt = $part1;
				}
				else if( $part1 == $part2 )
				{
					$yearInt = $part1;
					$monthInt = $part2;
				}
				else
				{
					// If here then there is no sure way to convert the string
					return "";
				}
				
				$yearInt = Dates::yearPad($yearInt);
				$date = $yearInt . "-" . str_pad($monthInt, 2, "0", STR_PAD_LEFT);
				return $date;
			}
			
			// Convert formats:  23-09-1946, 23-9-46, 09-23-1946, 9-23-1946, 1946-23-09
			if( $countDelimitted == 3          &&
			    str_isValidReal($dateArray[0]) &&
			    str_isValidReal($dateArray[1]) &&
			    str_isValidReal($dateArray[2]) )
			{
				// Declare containers
				$yearInt  = 0;
				$monthInt = 0;
				$dayInt   = 0;
				
				// Look for an obvious year value
				$aVal = (int)$dateArray[0]; 
				if( $aVal > 31 )
				{
					$yearInt  = $aVal;
					$dayInt   = (int)$dateArray[1];
					$monthInt = (int)$dateArray[2];
					// Note:  year-month-day would have been caught by Dates::isValidStr
				}
				else
				{
					// Note:  We assume year will not appear in the center position, only on the ends
					$aVal = (int)$dateArray[2];
					if( $aVal > 31 )
					{
						$dayInt   = (int)$dateArray[0];
						$monthInt = (int)$dateArray[1];
						$yearInt  = $aVal;
						// Note:  year-month-day would have been caught by Dates::isValidStr
					}
					
					// Note:  This previous if branch could be removed and just defaulted to the follow else branch, 
					//        but in the interest of logic clarity it was thought better to leave as is.
					
					// If at this point we don't know what the year is we assume the oder is: day, month, year
					else
					{
						$dayInt   = (int)$dateArray[0];
						$monthInt = (int)$dateArray[1];
						$yearInt  = (int)$dateArray[2];
					}
				}
				
				// Check for the case were we can distinguish between the day and the month
				if( $dayInt   <= 12 &&
				    $monthInt <= 12 &&
				    $dayInt   != $monthInt )
				{
					return "";
				}
				
				else if( Dates::isValidDayMonthPair($dayInt, $monthInt) )
				{
					// Condition the year value to four digits
					$yearInt = Dates::yearPad($yearInt);
					
					// Compile the string and send it back
					$date = $yearInt . "-" .
							str_pad($monthInt, 2, "0", STR_PAD_LEFT) . "-" .
							str_pad($dayInt, 2, "0", STR_PAD_LEFT);
					return $date;
				}
				else
				{
					// Try flipping the day and month to see if they are reversed
					$temp = $dayInt;
					$dayInt = $monthInt;
					$monthInt = $temp;
					if( Dates::isValidDayMonthPair($dayInt, $monthInt) )
					{
						// Condition the year value to four digits
						$yearInt = Dates::yearPad($yearInt);
						
						// Compile the string and send it back
						$date = $yearInt . "-" .
								str_pad($monthInt, 2, "0", STR_PAD_LEFT) . "-" .
								str_pad($dayInt, 2, "0", STR_PAD_LEFT);
						return $date;
					}
				}
			}
			
			// If here then there is no firm conversion
			return "";
		}
		
		public static function extractDate($refStr) {
			$remainder = $refStr;
			$raw       = "";
			$converted = "";
			
			$matches = array();
			     if( preg_match ("/^[0123456789]{1,2}\/[0123456789]{1,2}\/[0123456789]{2}/", $refStr, $matches) > 0 ) {}
			else if( preg_match ("/^[0123456789]{1,2}\/[0123456789]{1,2}\/[0123456789]{4}/", $refStr, $matches) > 0 ) {}
			else if( preg_match ("/^[0123456789]{4}\/[0123456789]{1,2}\/[0123456789]{1,2}/", $refStr, $matches) > 0 ) {}
			else if( preg_match ("/^[0123456789]{4}-[0123456789]{1,2}-[0123456789]{1,2}/",   $refStr, $matches) > 0 ) {}
            else if( preg_match ("/^[0123456789]{4}-[0123456789]{1,2}/",                     $refStr, $matches) > 0 ) {}
			else if( preg_match ("/^[0123456789]{4}/",                                       $refStr, $matches) > 0 ) {}
			
			if( count($matches) > 0 )
			{
				$raw       = $matches[0];
				$remainder = trim(str_replace($raw, "", $refStr));
				$converted = Dates::standardizeStr($raw);
			}
			
			return array($remainder, $raw, $converted);
		}

/*
        public static function convertDatesWD6($src, &$start, &$startDesig, &$startType, &$end, &$endDesig, &$endType) {
            $src = trim($src);
            if ($src == "") return true;

            // Sample formats...
            // 30.12.58/60
            // 3.75/79
            // 10/18
            // .67/69
            // 28.7.64
            // 8.66
            // .69
            //
            // 87/94 that ownership or status from (at least) 1987 until 1994 (at least)
            // .87/94 that ownership or status occurred during 1987 and continued until (at least) 1994
            // 5.87/94 that ownership or status occurred in May 1987 and continued until (at least) 1994
            // 22.5.87/94 that ownership or status occurred on 22 May 1987 and continued until (at least) 1994

            if (!str_contains($src, "/")) return Dates::convertDateWD6($src, $start, $startDesig, $startType);

            $bits = explode("/", $src);
            return Dates::convertDateWD6($bits[0], $start, $startDesig, $startType) && Dates::convertDateWD6("." . $bits[1], $end, $endDesig, $endType);
        }

        public static function convertDateWD6($src, &$dateInt, &$dateDesig, &$dateType, $bias=null) {
            $dateType = str_starts($src, ".") ? "O" : "C";
            $src =  str_trim($src, ".");

            if( preg_match("/^([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{1,2})$/", $src) > 0 ) {
                list($day, $month, $year) = explode(".", $src);
				$year    = Dates::buildYearWD6($year, $bias);
                $month   = str_padLeft($month, 2, "0");
                $day     = str_padLeft($day, 2, "0");
                $dateStr = $year . "-" . $month . "-" . $day;

                $dateInt   = Dates::convertStrToInt($dateStr);
                $dateDesig = "YMD";
            } else if( preg_match("/^([0-9]{1,2}\.[0-9]{1,2})$/", $src) > 0 ) {
                list($month, $year) = explode(".", $src);
				$year    = Dates::buildYearWD6($year, $bias);
                $month   = str_padLeft($month, 2, "0");
                $dateStr = $year . "-" . $month;

                $dateInt   = Dates::convertStrToInt($dateStr);
                $dateDesig = "YM";
            } else if( preg_match("/^([0-9]{1,2})$/", $src) > 0 ) {
            	$year = Dates::buildYearWD6($src, $bias);

                $dateInt   = Dates::convertStrToInt($year);
                $dateDesig = "Y";
            }
        }

        public static function buildYearWD6($year, $bias=null) {
            $year = (int)$year;

            if ($bias !== null) {
                return $bias . str_padLeft($year, 2, "0")
            }

            static $thisYear = null;
            if ($thisYear === null) {
                $thisYear = (int)date("y");
            }

            $year = ($year < $thisYear) ?
                "19" . str_padLeft($year, 2, "0") :
                "20" . str_padLeft($year, 2, "0");

            return $year;
        }
*/
    }
?>
