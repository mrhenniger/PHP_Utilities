<?php
    /*
    Welcome to "Strings"

    *** THIS FILE IS UNDER CONSTRUCTION ***

    This is simply a collection of string utilities which I have found useful.  I am wrote this class in the form
	of a set of stand-alone static functions and in class form which make use of the static functions and provides for
	changing.

    I would appreciate any feedback you may have.
    */

    // Class
    class Strings
    {
        private $__core = "";

        function __construct($input) {
            if (gettype($input) === "string") {
                $this->__core = $input;
            } else {
                $this->__core = $input->getCore();
            }
        }

        public function getCore() {
            return $this->__core;
        }

        public function equals(string $rightSide) {
            return $this->__core === $rightSide;
        }


        // Function:  Replace all occurrences of a string within a string, not just the first
        public static function _replaceAll($haystack, $from, $to) {
            $ret = $haystack;
            $before = "";
            while( $before != $ret ) {
                $before = $ret;
                $ret = str_replace($from, $to, $ret);
            }
            return $ret;
        }

        public function replaceAll($from, $to) { // chainable
            return new Strings(Strings::_replaceAll($this->__core, $from, $to));
        }


        // Function: Explode
        public static function _explode(string $delimit, string $refStr) {
            if( gettype($refStr) != "string" ) $refStr = (string)$refStr;
            if( $refStr == "" )                       return array();
            if( strpos($refStr, $delimit) === FALSE ) return array($refStr);
            $refStr = trim($refStr);
            $refStr = Strings::_replaceAll($refStr, $delimit . " ", $delimit);
            $refStr = Strings::_replaceAll($refStr, " " . $delimit, $delimit);
            return explode($delimit, $refStr);
        }

        public function explode($delimit) {
            return Strings::_explode($delimit, $this->__core);
        }


        // Function:  Lower
        public static function _lower($refStr) {
            return strtolower(trim($refStr));
        }

        public function lower() { // chainable
            return new Strings(Strings::_lower($this->__core));
        }


        // Function:  Upper
        public static function _upper($refStr) {
            return strtoupper(trim($refStr));
        }

        public function upper() { // chainable
            return new Strings(Strings::_upper($this->__core));
        }





    };

/*
THIS FOLLOWING HAVE PRIORITY TO PORT INTO THIS FILE


function str_capWords($refStr)
{
    return ucwords(str_lower(trim($refStr)));
}

function str_capSentence($refStr)
{
    if( $refStr == "" ) return "";
    $words = explode(" ", $refStr);
    $words[0] = ucwords($words[0]);
    return implode(" ", $words);
}

function str_isLower($refStr)
{
    if( $refStr == "" ) return false;

    $matches = array();
    $lowCount = (int)preg_match_all("([a-z]{1})", $refStr, $matches);
    $uprCount = (int)preg_match_all("([A-Z]{1})", $refStr, $matches);

    if( ($lowCount + $uprCount) == 0 ) return false;
    return ($uprCount / ($lowCount + $uprCount)) >= 0.5;
}

function str_isUpper($refStr)
{
    if( $refStr == "" ) return false;

    $matches = array();
    $lowCount = (int)preg_match_all("([a-z]{1})", $refStr, $matches);
    $uprCount = (int)preg_match_all("([A-Z]{1})", $refStr, $matches);

    if( ($lowCount + $uprCount) == 0 ) return false;
    return ($uprCount / ($lowCount + $uprCount)) >= 0.5;
}



function str_convertRealToString($refReal)
{
    if( gettype($refReal) == "integer" )
    {
        if( $refReal < 0 ) return (string)$refReal;
    }
    else if( !str_isValidReal($refReal) )
    {
        return (string)$refReal;
    }

    switch($refReal)
    {
        case 0: return "zero";
        case 1: return "one";
        case 2: return "two";
        case 3: return "three";
        case 4: return "four";
        case 5: return "five";
        case 6: return "six";
        case 7: return "seven";
        case 8: return "eight";
        case 9: return "nine";
    }

    return (string)$refReal;
}

// Function:  Check for all digits in a string
function str_isValidReal($input)
{
    if( $input == "" ) return FALSE;
    if( preg_match("/^([0-9]{1,})$/", $input) > 0 ) return TRUE;
    return FALSE;
}



// Check validity of the string as an integer
function str_isValidInt($input)
{
    if( $input == "" ) return FALSE;
    if( preg_match("/^([\+-]{0,1}[0-9]{0,})$/", $input) > 0 ) return TRUE;
    return FALSE;
}



// Check validity of the string as an integer
function str_isValidFloat($input)
{
    if( $input == "" ) return FALSE;
    if( preg_match("/^([\+-]{0,1}[0-9]{0,}[\.]{1}[0-9]{1,})$/", $input) > 0 ) return TRUE;
    return FALSE;
}



// Check validity of the string as an integer
function str_contains($haystack, $needle)
{
    if     ( $haystack == "" && $needle == "" ) return TRUE;
    else if( $haystack == "" || $needle == "" ) return FALSE;
    else if( $haystack == $needle )             return TRUE;
    $pos = strpos($haystack, $needle);
    return $pos !== FALSE;
}



// Check validity of the string as an integer
function str_containsWord($haystack, $needle)
{
    if( $haystack == "" || $needle == "" )    return FALSE;

    return (preg_match("/\b" . $needle . "\b/", $haystack) > 0);
}



// Check for a string at the start of another
function str_starts($haystack, $needle, $inspectLen = NULL)
{
    if     ( $haystack == "" && $needle   == "" ) return TRUE;
    else if( $haystack == "" || $needle   == "" ) return FALSE;
    if( $inspectLen !== NULL ) $inspectLen = abs((int)$inspectLen);

    $haystackLen = strlen($haystack);

    $needleLen   = strlen($needle);
    if( ($inspectLen !== NULL) && ($inspectLen < $needleLen) )
    {
        $needleLen = $inspectLen;
        $needle = substr($needle, 0, $needleLen);
    }

    if( $needleLen > $haystackLen )
    {
        return FALSE;
    }

    return strpos($haystack, $needle) === 0;
}



// Check for a stirng at the end of another
function str_ends($haystack, $needle, $inspectLen = NULL)
{
    if     ( $haystack == "" && $needle   == "" ) return TRUE;
    else if( $haystack == "" || $needle   == "" ) return FALSE;
    if( $inspectLen !== NULL ) $inspectLen = abs((int)$inspectLen);

    $haystackLen = strlen($haystack);

    $needleLen   = strlen($needle);
    if( ($inspectLen !== NULL) && ($inspectLen < $needleLen) )
    {
        $needleLen = $inspectLen;
        $needle = substr($needle, 0 - $needleLen);
    }

    if( $needleLen > $haystackLen )
    {
        return FALSE;
    }

    $pos = $haystackLen - $needleLen;
    $endString = substr($haystack, $pos, $needleLen);
    return ($needle == $endString);
}




function str_preg_replace($needlePattern, $replacementPattern, $haystack)
{
    // If there is nothing to search then just get out without error
    if( trim($haystack) == "" ) return "";

    // Error Check - Missing patterns
    if( $needlePattern == "" && $replacementPattern == "" )
    {
        logWarning("str_preg_replace - Missing needle and replacement patterns");
        return $haystack;
    }
    if( $needlePattern == "" )
    {
        logWarning("str_preg_replace - Missing needle pattern to go with replacement pattern (" . $replacementPattern . ")");
        return $haystack;
    }
    if( $replacementPattern == "" )
    {
        logWarning("str_preg_replace - Missing replacement pattern to go with needle pattern (" . $needlePattern . ")");
        return $haystack;
    }

    // Carry out the replacement
    $result = trim(preg_replace($needlePattern, $replacementPattern, $haystack));

    // Note:  This function assumes something will be left over and we do not replace EVERYTHING with an empty string
    return ($result == "") ? $haystack : $result;
}




// Function:  Alternate L-Trim
function str_lTrim($haystack, $needle = "")
{
    // Check for no more haystack
    if( $haystack == "" )
    {
        return $haystack;
    }

    // Check for no needle
    if( $needle == "" )
    {
        return trim($haystack);
    }

    // If the needle is at the start of the string then extract the remainder of the string
    $needleLength   = strlen($needle);
    $haystackLength = strlen($haystack);
    while( $haystackLength >= $needleLength &&
        strpos($haystack, $needle) === 0 )
    {
        $haystack       = substr($haystack, $needleLength);
        $haystackLength = strlen($haystack);
    }

    // Send back the results
    return $haystack;
}



// Function:  Alternate R-Trim
function str_rTrim($haystack, $needle = "")
{
    // Check for no more haystack
    if( $haystack == "" )
    {
        return $haystack;
    }

    // Check for no needle
    if( $needle == "" )
    {
        return trim($haystack);
    }

    // If the needle is at the start of the string then extract the remainder of the string
    $needleLength   = strlen($needle);
    $haystackLength = strlen($haystack);
    $offset         = $haystackLength - $needleLength;
    if( $offset >= 0 )
    {
        $pos = strpos($haystack, $needle, $offset);
        while( $haystack        != ""            &&
            $haystackLength  >= $needleLength &&
            $pos            === $offset       )
        {
            $haystack       = substr($haystack, 0, $offset);
            $haystackLength = strlen($haystack);
            $offset         = $haystackLength - $needleLength;
            if( $offset >= 0               &&
                $offset <  $haystackLength )
            {
                $pos = strpos($haystack, $needle, $offset);
            }
        }
    }

    // When unable to do anything return the start value
    return $haystack;
}



// Function:  Alternate Trim
function str_trim($haystack, $needle = "")
{
    $returnValue = str_lTrim($haystack, $needle);
    $returnValue = str_rTrim($returnValue, $needle);
    return $returnValue;
}



// Function:  Alternate pad
function str_safePad($input, $length, $padding = " ", $padSide = STR_PAD_RIGHT)
{
    // Check for no more haystack
    if( $padding == "" )
    {
        return $input;
    }

    // If whitespace left trim normally
    $inputLength = strlen($input);
    if( $length < $inputLength )
    {
        return $input;
    }

    // Do the padding
    return str_pad($input, $length, $padding, $padSide);
}

function str_padLeft($input, $length, $padding = " ")
{
    return str_safePad($input, $length, $padding, STR_PAD_LEFT);
}

function str_padRight($input, $length, $padding = " ")
{
    return str_safePad($input, $length, $padding, STR_PAD_RIGHT);
}



// Support Function - Extract tag
function str_extractTag($tag, &$haystack)
{
    // Check for bad params
    if( $tag      == "" ||
        $haystack == "" )
    {
        return "";
    }

    // Check for existing tag start
    $payload = "";
    $tagStart = $tag . "[";
    if( strpos($haystack, $tagStart) !== FALSE )
    {
        // Get the playload
        $payload = str_returnBetweenTags($tagStart, "]", $haystack);

        // Check for bad payload formatting
        if( strpos($payload, "[") !== FALSE )
        {
            $payload = "";
        }
    }

    // Clean the haystack
    if( $payload != "" )
    {
        $fullTag = $tagStart . $payload . "]";
        $haystack = str_replace($fullTag, "", $haystack);
        $haystack = trim($haystack);
    }

    // Send back the results
    return trim($payload);
}



// Support Function - Extract tag
function str_stripBeforeTag($tag, $haystack)
{
    if( $tag == ""                       ||
        $haystack == ""                  ||
        strpos($haystack, $tag) === FALSE )
    {
        return $haystack;
    }

    $pos = strpos($haystack, $tag) + strlen($tag);
    $haystack = trim(substr($haystack, $pos));

    return $haystack;
}



// Support Function - Extract tag
function str_stripAfterTag($tag, $haystack)
{
    if( $tag == ""                       ||
        $haystack == ""                  ||
        strpos($haystack, $tag) === FALSE )
    {
        return $haystack;
    }

    $pos = strpos($haystack, $tag);
    $haystack = trim(substr($haystack, 0, $pos));
    return $haystack;
}



function str_stripBetweenTags($tagLead, $tagTrail, $haystack)
{
    if( $tagLead == "" || $tagTrail == "" || $haystack == "" ) return $haystack;

    $posLead = strpos($haystack, $tagLead);
    if( $posLead === FALSE ) return $haystack;

    $posTrail = strpos($haystack, $tagTrail, $posLead + strlen($tagLead));
    if( $posTrail === FALSE ) return $haystack;

    if( $posTrail <= $posLead) return $haystack;

    $endPos = $posTrail + strlen($tagTrail) - 1;
    $toRemove = substr($haystack, $posLead, ($endPos - $posLead + 1));
    return str_replace($toRemove, "", $haystack);
}



function str_replaceBetweenTags($tagLead, $tagTrail, $haystack, $replacement = "", $scope = "EXCL")
{
//if( $replacement == "T H E M O S T C O M P L E T E" ) echo("MADE IT TO HERE - A - " . htmlspecialchars(substr($haystack,0,100)) . "<br>\n");
    if( $tagLead == "" || $tagTrail == "" || $haystack == "" ) return $haystack;
//if( $replacement == "T H E M O S T C O M P L E T E" ) echo("MADE IT TO HERE - B<br>\n");

    $posLead = strpos($haystack, $tagLead);
    if( $posLead === FALSE ) return $haystack;
//if( $replacement == "T H E M O S T C O M P L E T E" ) echo("MADE IT TO HERE - C<br>\n");

    $posTrail = strpos($haystack, $tagTrail, $posLead + strlen($tagLead));
    if( $posTrail === FALSE ) return $haystack;
    $posTrail += strlen($tagTrail);
//if( $replacement == "T H E M O S T C O M P L E T E" ) echo("MADE IT TO HERE - D<br>\n");

    if( $posTrail <= $posLead) return $haystack;
//if( $replacement == "T H E M O S T C O M P L E T E" ) echo("MADE IT TO HERE - E<br>\n");

    $before = substr($haystack, 0, $posLead);
    if( $scope == "INCL" ) $before .= $tagLead;
//if( $replacement == "T H E M O S T C O M P L E T E" ) echo("MADE IT TO HERE - F<br>\n");

    $after = substr($haystack, $posTrail);
    if( $scope == "INCL" ) $after = $tagTrail . $after;
//if( $replacement == "T H E M O S T C O M P L E T E" ) echo("MADE IT TO HERE - G<br>\n");

    return $before . $replacement . $after;
}



function str_returnBetweenTags($tagLead, $tagTrail, $haystack, $scope = "EXCL")
{
    if( $tagLead == "" || $tagTrail == "" || $haystack == "" ) return "";

    $posLead = strpos($haystack, $tagLead);
    if( $posLead === FALSE ) return "";
    $posLead += strlen($tagLead);

    $posTrail = strpos($haystack, $tagTrail, $posLead);
    if( $posTrail === FALSE ) return "";

    if( $posTrail <= $posLead) return "";

    $toReturn = substr($haystack, $posLead, ($posTrail - $posLead));
    if( $scope == "INCL" ) $toReturn = $tagLead . $toReturn . $tagTrail;
    return trim($toReturn);
}
*/



/*
THE STUFF BELOW WILL TAKE LONGER TO PORT INTO THIS NEW FILE







	include_once "UtilitiesInclude.php";

	includeOnce("UtilitiesMaps.php");
	includeOnce("Cache_Air_AirframeMilitaryServiceLookUp.php");
	
	
	

	
	
	
	// Function:  Add to the user error messages
	function str_replaceQuotes($haystack, $replacement = "")
	{
		$result = $haystack;
		
		$result = str_replace("aren" . chr(39) . "t",    "are not",    $result);
		$result = str_replace("can" . chr(39) . "t",     "can not",    $result);
		$result = str_replace("couldn" . chr(39) . "t",  "could not",  $result);
		$result = str_replace("didn" . chr(39) . "t",    "did not",    $result);
		$result = str_replace("doesn" . chr(39) . "t",   "does not",   $result);
		$result = str_replace("don" . chr(39) . "t",     "do not",     $result);
		$result = str_replace("hadn" . chr(39) . "t",    "had not",    $result);
		$result = str_replace("hasn" . chr(39) . "t",    "has not",    $result);
		$result = str_replace("haven" . chr(39) . "t",   "have not",   $result);
		$result = str_replace("he" . chr(39) . "d",      "he had",     $result);
		$result = str_replace("he" . chr(39) . "ll",     "he will",    $result);
		$result = str_replace("he" . chr(39) . "s",      "he is",      $result);
		$result = str_replace("I" . chr(39) . "d",       "I had",      $result);
		$result = str_replace("I" . chr(39) . "ll",      "I will",     $result);
		$result = str_replace("I" . chr(39) . "m",       "I am",       $result);
		$result = str_replace("I" . chr(39) . "ve",      "I have",     $result);
		$result = str_replace("isn" . chr(39) . "t",     "is not",     $result);
		$result = str_replace("it" . chr(39) . "s",      "it is",      $result);
		$result = str_replace("let" . chr(39) . "s",     "let us",     $result);
		$result = str_replace("mightn" . chr(39) . "t",  "might not",  $result);
		$result = str_replace("mustn" . chr(39) . "t",   "must not",   $result);
		$result = str_replace("shan" . chr(39) . "t",    "shall not",  $result);
		$result = str_replace("she" . chr(39) . "d",     "she had",    $result);
		$result = str_replace("she" . chr(39) . "ll",    "she will",   $result);
		$result = str_replace("she" . chr(39) . "s",     "she is",     $result);
		$result = str_replace("shouldn" . chr(39) . "t", "should not", $result);
		$result = str_replace("that" . chr(39) . "s",    "that is",    $result);
		$result = str_replace("there" . chr(39) . "s",   "there is",   $result);
		$result = str_replace("they" . chr(39) . "d",    "they had",   $result);
		$result = str_replace("they" . chr(39) . "ll",   "they will",  $result);
		$result = str_replace("they" . chr(39) . "re",   "they are",   $result);
		$result = str_replace("they" . chr(39) . "ve",   "they have",  $result);
		$result = str_replace("we" . chr(39) . "d",      "we had",     $result);
		$result = str_replace("we" . chr(39) . "re",     "we are",     $result);
		$result = str_replace("we" . chr(39) . "ve",     "we have",    $result);
		$result = str_replace("weren" . chr(39) . "t",   "were not",   $result);
		$result = str_replace("what" . chr(39) . "ll",   "what will",  $result);
		$result = str_replace("what" . chr(39) . "re",   "what are",   $result);
		$result = str_replace("what" . chr(39) . "s",    "what is",    $result);
		$result = str_replace("what" . chr(39) . "ve",   "what have",  $result);
		$result = str_replace("where" . chr(39) . "s",   "where is",   $result);
		$result = str_replace("who" . chr(39) . "d",     "who had",    $result);
		$result = str_replace("who" . chr(39) . "ll",    "who will",   $result);
		$result = str_replace("who" . chr(39) . "re",    "who are",    $result);
		$result = str_replace("who" . chr(39) . "s",     "who is",     $result);
		$result = str_replace("who" . chr(39) . "ve",    "who have",   $result);
		$result = str_replace("won" . chr(39) . "t",     "will not",   $result);
		$result = str_replace("wouldn" . chr(39) . "t",  "would not",  $result);
		$result = str_replace("you" . chr(39) . "d",     "you had",    $result);
		$result = str_replace("you" . chr(39) . "ll",    "you will",   $result);
		$result = str_replace("you" . chr(39) . "re",    "you are",    $result);
		$result = str_replace("you" . chr(39) . "ve",    "you have",   $result);

        $result = str_replace("'",     $replacement, $result);
		$result = str_replace("’",     $replacement, $result);
		$result = str_replace("\"",    $replacement, $result);
        $result = str_replace("`",     $replacement, $result);
        $result = str_replace("“",     $replacement, $result);
        $result = str_replace("”",     $replacement, $result);
		$result = str_replace("c\") ", $replacement, $result);
		$result = str_replace("�",    $replacement, $result);
		$result = str_replace("�",    $replacement, $result);
		$result = str_replace("�",    $replacement, $result);
		
		$result = str_replace(chr( 34), $replacement, $result); // "
		$result = str_replace(chr( 39), $replacement, $result); // '
		$result = str_replace(chr( 92), $replacement, $result); // \
        $result = str_replace(chr( 96), $replacement, $result); // `
        $result = str_replace(chr(147), $replacement, $result); // "
		$result = str_replace(chr(148), $replacement, $result); // "

        $result = str_replace(chr(226) . chr(128) . chr(153), $replacement, $result);
        $result = str_replace(chr(226) . chr(128) . chr(156), $replacement, $result); // “
        $result = str_replace(chr(226) . chr(128) . chr(157), $replacement, $result); // ”

		return $result;
	}
	
	
	
	// Function:  Determine is a standard ordinate
	function str_isStandardOrd($refOrd)
	{
		return
		(
//			$refOrd == 9                      || // tab
			($refOrd >= 48 && $refOrd <=  57) || // 0 to 9
			($refOrd >= 65 && $refOrd <=  60) || // A to Z
			($refOrd >= 97 && $refOrd <= 122) || // 0 to 9
			$refOrd == 32                     || // space
			$refOrd == 33                     || // !
			($refOrd >= 35 && $refOrd <=  36) || // # $
			($refOrd >= 40 && $refOrd <=  43) || // ( ) * +
			($refOrd >= 44 && $refOrd <=  91) || // , - . / 0-9 : ; < = > ? @ A-Z [
			($refOrd >= 93 && $refOrd <=  95) || // ] ^ _
			($refOrd >= 97 && $refOrd <= 126)    // a-z { | } ~
		);
	}
	
	
	
	// Function:  Replace ASCII characters
	function str_altASCII($haystack, $replacement = "")
	{
		$result = $haystack;
		
		// Combinations

		$result = str_replace(chr(195) . chr(169), "e", $result);
		$result = str_replace(chr(197) . chr(161), "s", $result); // �

		
		// A

		$result = str_replace(chr(131), "a", $result);
		$result = str_replace(chr(132), "a", $result);
		$result = str_replace(chr(133), "a", $result);
		$result = str_replace(chr(134), "a", $result);
		$result = str_replace(chr(160), "a", $result);
		$result = str_replace(chr(224), "a", $result);
		$result = str_replace(chr(225), "a", $result);
		$result = str_replace(chr(227), "a", $result);
		$result = str_replace(chr(228), "a", $result);
		$result = str_replace(chr(229), "a", $result);
		$result = str_replace(chr(229), "a", $result);
		$result = str_replace(chr(142), "A", $result);
		$result = str_replace(chr(143), "A", $result);
		$result = str_replace(chr(192), "A", $result);
		$result = str_replace(chr(193), "A", $result);
		$result = str_replace(chr(194), "A", $result);
		$result = str_replace(chr(195), "A", $result);
		$result = str_replace(chr(196), "A", $result);
		$result = str_replace(chr(197), "A", $result);

		
		// AE
		$result = str_replace(chr(230), "ae", $result);
		$result = str_replace(chr(198), "AE", $result);
		
		// C
		$result = str_replace(chr(135), "c", $result);
		$result = str_replace(chr(231), "c", $result);
		$result = str_replace(chr(199), "C", $result);
		
		// E
		$result = str_replace(chr(130), "e", $result);
		$result = str_replace(chr(136), "e", $result);
		$result = str_replace(chr(137), "e", $result);
		$result = str_replace(chr(138), "e", $result);
		$result = str_replace(chr(232), "e", $result);
		$result = str_replace(chr(233), "e", $result);
		$result = str_replace(chr(234), "e", $result);
		$result = str_replace(chr(235), "e", $result);
		$result = str_replace(chr(144), "E", $result);
		$result = str_replace(chr(200), "E", $result);
		$result = str_replace(chr(201), "E", $result);
		$result = str_replace(chr(202), "E", $result);
		$result = str_replace(chr(203), "E", $result);
		
		// ETH
		$result = str_replace(chr(240), "eth", $result);
		$result = str_replace(chr(208), "ETH", $result);
		
		// I
		$result = str_replace(chr(139), "i", $result);
		$result = str_replace(chr(140), "i", $result);
		$result = str_replace(chr(141), "i", $result);
		$result = str_replace(chr(161), "i", $result);
		$result = str_replace(chr(236), "i", $result);
		$result = str_replace(chr(237), "i", $result);
		$result = str_replace(chr(238), "i", $result);
		$result = str_replace(chr(239), "i", $result);
		$result = str_replace(chr(204), "I", $result);
		$result = str_replace(chr(205), "I", $result);
		$result = str_replace(chr(206), "I", $result);
		$result = str_replace(chr(207), "I", $result);
		
		// N
		$result = str_replace(chr(164), "n", $result);
		$result = str_replace(chr(241), "n", $result);
		$result = str_replace(chr(165), "N", $result);
		$result = str_replace(chr(209), "N", $result);
		
		// O
		$result = str_replace(chr(149), "o", $result);
		$result = str_replace(chr(162), "o", $result);
		$result = str_replace(chr(242), "o", $result);
		$result = str_replace(chr(243), "o", $result);
		$result = str_replace(chr(244), "o", $result);
		$result = str_replace(chr(245), "o", $result);
		$result = str_replace(chr(246), "o", $result);
		$result = str_replace(chr(248), "o", $result);
		$result = str_replace(chr(153), "O", $result);
		$result = str_replace(chr(210), "O", $result);
		$result = str_replace(chr(211), "O", $result);
		$result = str_replace(chr(212), "O", $result);
		$result = str_replace(chr(213), "O", $result);
		$result = str_replace(chr(214), "O", $result);
		$result = str_replace(chr(216), "O", $result);
		
		// S
		$result = str_replace(chr(197), "s", $result);
		$result = str_replace(chr(223), "s", $result);
		
		// T
		$result = str_replace(chr(254), "thorn", $result);
		$result = str_replace(chr(222), "THORN", $result);
		
		// U
		$result = str_replace(chr(129), "u", $result);
		$result = str_replace(chr(150), "u", $result);
		$result = str_replace(chr(151), "u", $result);
        // $result = str_replace(chr(156), "u", $result); // putting this one in will foul up removal of some quotes
		$result = str_replace(chr(163), "u", $result);
		$result = str_replace(chr(249), "u", $result);
		$result = str_replace(chr(250), "u", $result);
		$result = str_replace(chr(251), "u", $result);
		$result = str_replace(chr(252), "u", $result);
		$result = str_replace(chr(154), "U", $result);
		$result = str_replace(chr(217), "U", $result);
		$result = str_replace(chr(218), "U", $result);
		$result = str_replace(chr(219), "U", $result);
		$result = str_replace(chr(220), "U", $result);
		
		// Y
		$result = str_replace(chr(152), "y", $result);
		$result = str_replace(chr(253), "y", $result);
		$result = str_replace(chr(255), "y", $result);
		$result = str_replace(chr(221), "Y", $result);
		
		// Others
		//Dec  Char                           Dec  Char     Dec  Char     Dec  Char
        //---------                           ---------     ---------     ----------
        //  0  NUL (null)                      32  SPACE     64  @         96  `
        //  1  SOH (start of heading)          33  !         65  A         97  a
        //  2  STX (start of text)             34  "         66  B         98  b
        //  3  ETX (end of text)               35  #         67  C         99  c
        //  4  EOT (end of transmission)       36  $         68  D        100  d
        //  5  ENQ (enquiry)                   37  %         69  E        101  e
        //  6  ACK (acknowledge)               38  &         70  F        102  f
        //  7  BEL (bell)                      39  '         71  G        103  g
        //  8  BS  (backspace)                 40  (         72  H        104  h
        //  9  TAB (horizontal tab)            41  )         73  I        105  i
        // 10  LF  (NL line feed, new line)    42  *         74  J        106  j
        // 11  VT  (vertical tab)              43  +         75  K        107  k
        // 12  FF  (NP form feed, new page)    44  ,         76  L        108  l
        // 13  CR  (carriage return)           45  -         77  M        109  m
        // 14  SO  (shift out)                 46  .         78  N        110  n
        // 15  SI  (shift in)                  47  /         79  O        111  o
        // 16  DLE (data link escape)          48  0         80  P        112  p
        // 17  DC1 (device control 1)          49  1         81  Q        113  q
        // 18  DC2 (device control 2)          50  2         82  R        114  r
        // 19  DC3 (device control 3)          51  3         83  S        115  s
        // 20  DC4 (device control 4)          52  4         84  T        116  t
        // 21  NAK (negative acknowledge)      53  5         85  U        117  u
        // 22  SYN (synchronous idle)          54  6         86  V        118  v
        // 23  ETB (end of trans. block)       55  7         87  W        119  w
        // 24  CAN (cancel)                    56  8         88  X        120  x
        // 25  EM  (end of medium)             57  9         89  Y        121  y
        // 26  SUB (substitute)                58  :         90  Z        122  z
        // 27  ESC (escape)                    59  ;         91  [        123  {
        // 28  FS  (file separator)            60  <         92  \        124  |
        // 29  GS  (group separator)           61  =         93  ]        125  }
        // 30  RS  (record separator)          62  >         94  ^        126  ~
        // 31  US  (unit separator)            63  ?         95  _        127  DEL

        $result = str_replace(chr(0),   $replacement, $result);
        $result = str_replace(chr(1),   $replacement, $result);
        $result = str_replace(chr(2),   $replacement, $result);
        $result = str_replace(chr(3),   $replacement, $result);
        $result = str_replace(chr(4),   $replacement, $result);
        $result = str_replace(chr(5),   $replacement, $result);
        $result = str_replace(chr(6),   $replacement, $result);
        $result = str_replace(chr(8),   $replacement, $result);
        $result = str_replace(chr(9),   $replacement, $result);
        $result = str_replace(chr(11),  $replacement, $result);
        $result = str_replace(chr(12),  $replacement, $result);
        $result = str_replace(chr(14),  $replacement, $result);
        $result = str_replace(chr(15),  $replacement, $result);
        $result = str_replace(chr(16),  $replacement, $result);
        $result = str_replace(chr(17),  $replacement, $result);
        $result = str_replace(chr(18),  $replacement, $result);
        $result = str_replace(chr(19),  $replacement, $result);
        $result = str_replace(chr(20),  $replacement, $result);
        $result = str_replace(chr(21),  $replacement, $result);
        $result = str_replace(chr(22),  $replacement, $result);
        $result = str_replace(chr(23),  $replacement, $result);
        $result = str_replace(chr(24),  $replacement, $result);
        $result = str_replace(chr(25),  $replacement, $result);
        $result = str_replace(chr(26),  $replacement, $result);
        $result = str_replace(chr(27),  $replacement, $result);
        $result = str_replace(chr(28),  $replacement, $result);
        $result = str_replace(chr(29),  $replacement, $result);
        $result = str_replace(chr(30),  $replacement, $result);
        $result = str_replace(chr(127), $replacement, $result);

		$result = str_replace("^",    $replacement, $result);
		$result = str_replace(chr(215),  "*", $result);
		$result = str_replace(chr(247),  "/", $result);
		$result = str_replace(chr(168), $replacement, $result);
		$result = str_replace(chr(187), $replacement, $result);
		$result = str_replace(chr(191), $replacement, $result);

        $result = str_replace(chr(194) . chr(189), '1/2', $result);
        $result = str_replace(chr(226) . chr(128) . chr(148), ' - ', $result);

        $result = str_replace(chr(189), $replacement, $result);

        return $result;
	}
	
	
	
	// Function:  Replace ASCII characters
	function str_normalizeOrds($haystack, $replacement = "", $setAlternates = TRUE)
	{
		$result = $haystack;
		if( $setAlternates )
		{
			$result = str_altASCII($haystack, $replacement = "");
		}
		
		$goAgain = TRUE;
		while( $goAgain )
		{
			$goAgain = FALSE;
			$size = strlen($result);
			for( $index = 0; $index < $size; $index++ )
			{
				$theOrd = ord($result[$index]);
				if( str_isStandardOrd($theOrd) )
				{
					// This list of ordinate values is considered acceptable
				}
				else
				{
					$result = str_replace(chr($theOrd), $replacement, $result);
					$goAgain = TRUE;
					break;
				}
			}	
		}
		
		return $result;
	}
	
	
	
	// Function:  Replace New Lines
	function str_removeNewlines($haystack, $replacement = "")
	{
		$result = str_replace("\n", $replacement, $haystack);
		$result = str_replace("\r", $replacement, $result);
        $result = str_replace("&nbsp;", $replacement, $result);
		
		return $result;
	}

	function str_shrinkHtml($contents) {

        $contents = str_removeNewlines($contents);

        $contents = str_replace("< ", "<", $contents);
        $contents = str_replace(" <", "<", $contents);
        $contents = str_replace("> ", ">", $contents);
        $contents = str_replace(" >", ">", $contents);

	    return $contents;
    }



    // Function:  Add to the user error messages
    function str_replaceWildcards($haystack)
    {
        $result = $haystack;

        $before = "";
        while( $result != $before )
        {
            $before = $result;

            $result = str_replace("amp;amp;", "amp;",      $result);
            $result = str_replace(" &amp; ", " and ",      $result);
            $result = str_replace(" &amp;",  " and",       $result);
            $result = str_replace("&amp; ",  "and ",       $result);
            $result = str_replace("&amp;",   " and ",      $result);
            $result = str_replace("&",       " and ",      $result);

            $result = str_replace("%",       " percent ",  $result);

            $result = str_replace("  ",      " ",            $result);

            // Note:  Leave % and _ to str_normalizeOrds to remove
        }

        return $result;
    }

	
	
	// Function:  A wider scope line clean
	function str_stringClean($haystack, $replacement = "")
	{
        $elipses = str_ends($haystack, "...");

        $result = $haystack;
//echo("injectionScreen - 1 - result=" . $result . "<br>\n");
        $result = str_replaceWildcards($result);
//echo("injectionScreen - 2 - result=" . $result . "<br>\n");
        $result = str_replaceQuotes($result, $replacement);
//echo("injectionScreen - 3 - result=" . $result . "<br>\n");
        $result = str_altASCII($result, $replacement);
//echo("injectionScreen - 4 - result=" . $result . "<br>\n");
        $result = str_cleanPunctuation($result);
//echo("injectionScreen - 5 - result=" . $result . "<br>\n");

        $result = htmlspecialchars($result); // Converts: & to &amp;
//echo("injectionScreen - 6 - result=" . $result . "<br>\n");

        $result = trim($result);
        if( $elipses )
        {
            $result = trim($result, ".");
            $result .= "...";
        }

        return $result;
	}
	
	
	
	// Function:  Replace ASCII characters
	function str_displayOrds($haystack, $length = NULL)
	{
		if( strlen($haystack) == 0 ) return "";
		
		$size = $length;
		if( $size === NULL ) $size = strlen($haystack);
        $result = "strlen(" . $size . ") - str[" . htmlspecialchars($haystack) . "] - ords:  ";
//		$result = "strlen(" . $size . ") - ords:  ";
		for( $index = 0; $index < $size; $index++ )
		{
            $result .= $haystack[$index] . "(" . ord($haystack[$index]) . "), ";
//			$result .= ord($haystack[$index]) . ", ";
		}
		$result = trim($result, ", ");
		
		return $result;
	}
	
	
	
	// Function:  Find a parttern
	function str_pregPos($pattern, $haystack)
	{
		$tag  = "XXYYZZYYXX_AerialVisuals_XXYYZZYYXX";
		$copy = preg_replace($pattern, $tag, $haystack, 1);
		return strpos($copy, $tag);
	}
	
	
	
	// Function:  Process the next line
	function str_parseLine($theLine, $numberOfElements = 20, $rescan = 2)
	{
		// Break the line into bits
		$bits = explode("\t", $theLine);
		
		// Clean-up - Remove leading and trailing double quotes
		for( $count = 0; $count < $rescan; $count++ )
		{
			for( $index = 0; $index < $numberOfElements; $index++ )
				$bits[$index] = str_stringClean($bits[$index]);
		}
		
		// Send badk the array
		return $bits;
	}
	
	
	
	// Function:  Convert an integer into a uppercase letter
	function str_convertIntToAlpha($referenceInteger)
	{
		if( !is_int($referenceInteger) ) return "";
		
		switch($referenceInteger)
		{
			case 0   : return "A";
			case 1   : return "B";
			case 2   : return "C";
			case 3   : return "D";
			case 4   : return "E";
			case 5   : return "F";
			case 6   : return "G";
			case 7   : return "H";
			case 8   : return "I";
			case 9   : return "J";
			case 10  : return "K";
			case 11  : return "L";
			case 12  : return "M";
			case 13  : return "N";
			case 14  : return "O";
			case 15  : return "P";
			case 16  : return "Q";
			case 17  : return "R";
			case 18  : return "S";
			case 19  : return "T";
			case 20  : return "U";
			case 21  : return "V";
			case 22  : return "W";
			case 23  : return "X";
			case 24  : return "Y";
			case 25  : return "Z";
			
			case 26  : return "AA";
			case 27  : return "AB";
			case 28  : return "AC";
			case 29  : return "AD";
			case 30  : return "AE";
			case 31  : return "AF";
			case 32  : return "AG";
			case 33  : return "AH";
			case 34  : return "AI";
			case 35  : return "AJ";
			case 36  : return "AK";
			case 37  : return "AL";
			case 38  : return "AM";
			case 39  : return "AN";
			case 40  : return "AO";
			case 41  : return "AP";
			case 42  : return "AQ";
			case 43  : return "AR";
			case 44  : return "AS";
			case 45  : return "AT";
			case 46  : return "AU";
			case 47  : return "AV";
			case 48  : return "AW";
			case 49  : return "AX";
			case 50  : return "AY";
			case 51  : return "AZ";
			
			case 52  : return "BA";
			case 53  : return "BB";
			case 54  : return "BC";
			case 55  : return "BD";
			case 56  : return "BE";
			case 57  : return "BF";
			case 58  : return "BG";
			case 59  : return "BH";
			case 60  : return "BI";
			case 61  : return "BJ";
			case 62  : return "BK";
			case 63  : return "BL";
			case 64  : return "BM";
			case 65  : return "BN";
			case 66  : return "BO";
			case 67  : return "BP";
			case 68  : return "BQ";
			case 69  : return "BR";
			case 70  : return "BS";
			case 71  : return "BT";
			case 72  : return "BU";
			case 73  : return "BV";
			case 74  : return "BW";
			case 75  : return "BX";
			case 76  : return "BY";
			case 77  : return "BZ";
			
			case 78  : return "CA";
			case 79  : return "CB";
			case 80  : return "CC";
			case 81  : return "CD";
			case 82  : return "CE";
			case 83  : return "CF";
			case 84  : return "CG";
			case 85  : return "CH";
			case 86  : return "CI";
			case 87  : return "CJ";
			case 88  : return "CK";
			case 89  : return "CL";
			case 90  : return "CM";
			case 91  : return "CN";
			case 92  : return "CO";
			case 93  : return "CP";
			case 94  : return "CQ";
			case 95  : return "CR";
			case 96  : return "CS";
			case 97  : return "CT";
			case 98  : return "CU";
			case 99  : return "CV";
			case 100 : return "CW";
			case 101 : return "CX";
			case 102 : return "CY";
			case 103 : return "CZ";
			
			case 104 : return "DA";
			case 105 : return "DB";
			case 106 : return "DC";
			case 107 : return "DD";
			case 108 : return "DE";
			case 109 : return "DF";
			case 110 : return "DG";
			case 111 : return "DH";
			case 112 : return "DI";
			case 113 : return "DJ";
			case 114 : return "DK";
			case 115 : return "DL";
			case 116 : return "DM";
			case 117 : return "DN";
			case 118 : return "DO";
			case 119 : return "DP";
			case 120 : return "DQ";
			case 121 : return "DR";
			case 122 : return "DS";
			case 123 : return "DT";
			case 124 : return "DU";
			case 125 : return "DV";
			case 126 : return "DW";
			case 127 : return "DX";
			case 128 : return "DY";
			case 129 : return "DZ";
			
			case 130 : return "EA";
			case 131 : return "EB";
			case 132 : return "EC";
			case 133 : return "ED";
			case 134 : return "EE";
			case 135 : return "EF";
			case 136 : return "EG";
			case 137 : return "EH";
			case 138 : return "EI";
			case 139 : return "EJ";
			case 140 : return "EK";
			case 141 : return "EL";
			case 142 : return "EM";
			case 143 : return "EN";
			case 144 : return "EO";
			case 145 : return "EP";
			case 146 : return "EQ";
			case 147 : return "ER";
			case 148 : return "ES";
			case 149 : return "ET";
			case 150 : return "EU";
			case 151 : return "EV";
			case 152 : return "EW";
			case 153 : return "EX";
			case 154 : return "EY";
			case 155 : return "EZ";
			
			case 156 : return "FA";
			case 157 : return "FB";
			case 158 : return "FC";
			case 159 : return "FD";
			case 160 : return "FE";
			case 161 : return "FF";
			case 162 : return "FG";
			case 163 : return "FH";
			case 164 : return "FI";
			case 165 : return "FJ";
			case 166 : return "FK";
			case 167 : return "FL";
			case 168 : return "FM";
			case 169 : return "FN";
			case 170 : return "FO";
			case 171 : return "FP";
			case 172 : return "FQ";
			case 173 : return "FR";
			case 174 : return "FS";
			case 175 : return "FT";
			case 176 : return "FU";
			case 177 : return "FV";
			case 178 : return "FW";
			case 179 : return "FX";
			case 180 : return "FY";
			case 181 : return "FZ";
			
			case 182 : return "GA";
			case 183 : return "GB";
			case 184 : return "GC";
			case 185 : return "GD";
			case 186 : return "GE";
			case 187 : return "GF";
			case 188 : return "GG";
			case 189 : return "GH";
			case 190 : return "GI";
			case 191 : return "GJ";
			case 192 : return "GK";
			case 193 : return "GL";
			case 194 : return "GM";
			case 195 : return "GN";
			case 196 : return "GO";
			case 197 : return "GP";
			case 198 : return "GQ";
			case 199 : return "GR";
			case 200 : return "GS";
			case 201 : return "GT";
			case 202 : return "GU";
			case 203 : return "GV";
			case 204 : return "GW";
			case 205 : return "GX";
			case 206 : return "GY";
			case 207 : return "GZ";
			
			default  : return "";
		}
	}
	
	
	
	// Function:  Convert an uppercase letter to an integer
	function str_convertAphaToInt($refAlpha)
	{
		if( $refAlpha == "" ) return -1;
		
		switch($refAlpha)
		{
			case  "A": return   0;
			case  "B": return   1;
			case  "C": return   2;
			case  "D": return   3;
			case  "E": return   4;
			case  "F": return   5;
			case  "G": return   6;
			case  "H": return   7;
			case  "I": return   8;
			case  "J": return   9;
			case  "K": return  10;
			case  "L": return  11;
			case  "M": return  12;
			case  "N": return  13;
			case  "O": return  14;
			case  "P": return  15;
			case  "Q": return  16;
			case  "R": return  17;
			case  "S": return  18;
			case  "T": return  19;
			case  "U": return  20;
			case  "V": return  21;
			case  "W": return  22;
			case  "X": return  23;
			case  "Y": return  24;
			case  "Z": return  25;
			
			case "AA": return  26;
			case "AB": return  27;
			case "AC": return  28;
			case "AD": return  29;
			case "AE": return  30;
			case "AF": return  31;
			case "AG": return  32;
			case "AH": return  33;
			case "AI": return  34;
			case "AJ": return  35;
			case "AK": return  36;
			case "AL": return  37;
			case "AM": return  38;
			case "AN": return  39;
			case "AO": return  40;
			case "AP": return  41;
			case "AQ": return  42;
			case "AR": return  43;
			case "AS": return  44;
			case "AT": return  45;
			case "AU": return  46;
			case "AV": return  47;
			case "AW": return  48;
			case "AX": return  49;
			case "AY": return  50;
			case "AZ": return  51;
			
			case "BA": return  52;
			case "BB": return  53;
			case "BC": return  54;
			case "BD": return  55;
			case "BE": return  56;
			case "BF": return  57;
			case "BG": return  58;
			case "BH": return  59;
			case "BI": return  60;
			case "BJ": return  61;
			case "BK": return  62;
			case "BL": return  63;
			case "BM": return  64;
			case "BN": return  65;
			case "BO": return  66;
			case "BP": return  67;
			case "BQ": return  68;
			case "BR": return  69;
			case "BS": return  70;
			case "BT": return  71;
			case "BU": return  72;
			case "BV": return  73;
			case "BW": return  74;
			case "BX": return  75;
			case "BY": return  76;
			case "BZ": return  77;
			
			case "CA": return  78;
			case "CB": return  79;
			case "CC": return  80;
			case "CD": return  81;
			case "CE": return  82;
			case "CF": return  83;
			case "CG": return  84;
			case "CH": return  85;
			case "CI": return  86;
			case "CJ": return  87;
			case "CK": return  88;
			case "CL": return  89;
			case "CM": return  90;
			case "CN": return  91;
			case "CO": return  92;
			case "CP": return  93;
			case "CQ": return  94;
			case "CR": return  95;
			case "CS": return  96;
			case "CT": return  97;
			case "CU": return  98;
			case "CV": return  99;
			case "CW": return 100;
			case "CX": return 101;
			case "CY": return 102;
			case "CZ": return 103;
			
			case "DA": return 104;
			case "DB": return 105;
			case "DC": return 106;
			case "DD": return 107;
			case "DE": return 108;
			case "DF": return 109;
			case "DG": return 110;
			case "DH": return 111;
			case "DI": return 112;
			case "DJ": return 113;
			case "DK": return 114;
			case "DL": return 115;
			case "DM": return 116;
			case "DN": return 117;
			case "DO": return 118;
			case "DP": return 119;
			case "DQ": return 120;
			case "DR": return 121;
			case "DS": return 122;
			case "DT": return 123;
			case "DU": return 124;
			case "DV": return 125;
			case "DW": return 126;
			case "DX": return 127;
			case "DY": return 128;
			case "DZ": return 129;
			
			case "EA": return 130;
			case "EB": return 131;
			case "EC": return 132;
			case "ED": return 133;
			case "EE": return 134;
			case "EF": return 135;
			case "EG": return 136;
			case "EH": return 137;
			case "EI": return 138;
			case "EJ": return 139;
			case "EK": return 140;
			case "EL": return 141;
			case "EM": return 142;
			case "EN": return 143;
			case "EO": return 144;
			case "EP": return 145;
			case "EQ": return 146;
			case "ER": return 147;
			case "ES": return 148;
			case "ET": return 149;
			case "EU": return 150;
			case "EV": return 151;
			case "EW": return 152;
			case "EX": return 153;
			case "EY": return 154;
			case "EZ": return 155;
			
			case "FA": return 156;
			case "FB": return 157;
			case "FC": return 158;
			case "FD": return 159;
			case "FE": return 160;
			case "FF": return 161;
			case "FG": return 162;
			case "FH": return 163;
			case "FI": return 164;
			case "FJ": return 165;
			case "FK": return 166;
			case "FL": return 167;
			case "FM": return 168;
			case "FN": return 169;
			case "FO": return 170;
			case "FP": return 171;
			case "FQ": return 172;
			case "FR": return 173;
			case "FS": return 174;
			case "FT": return 175;
			case "FU": return 176;
			case "FV": return 177;
			case "FW": return 178;
			case "FX": return 179;
			case "FY": return 180;
			case "FZ": return 181;
			
			case "GA": return 182;
			case "GB": return 183;
			case "GC": return 184;
			case "GD": return 185;
			case "GE": return 186;
			case "GF": return 187;
			case "GG": return 188;
			case "GH": return 189;
			case "GI": return 190;
			case "GJ": return 191;
			case "GK": return 192;
			case "GL": return 193;
			case "GM": return 194;
			case "GN": return 195;
			case "GO": return 196;
			case "GP": return 197;
			case "GQ": return 198;
			case "GR": return 199;
			case "GS": return 200;
			case "GT": return 201;
			case "GU": return 202;
			case "GV": return 203;
			case "GW": return 204;
			case "GX": return 205;
			case "GY": return 206;
			case "GZ": return 207;
			
			default  : return   0;
		}
	}
	
	
	
	// Function:  Generate a random number between 0 and 9 inclusive
	function str_randomDigit()
	{
		return rand(0, 9);
	}
	
	
	
	// Function:  Generate a random lower case letter
	function str_randomLowerCase()
	{
		switch(rand(0, 25))
		{
			case  0: return "a";
			case  1: return "b";
			case  2: return "c";
			case  3: return "d";
			case  4: return "e";
			case  5: return "f";
			case  6: return "g";
			case  7: return "h";
			case  8: return "i";
			case  9: return "j";
			case 10: return "k";
			case 11: return "l";
			case 12: return "m";
			case 13: return "n";
			case 14: return "o";
			case 15: return "p";
			case 16: return "q";
			case 17: return "r";
			case 18: return "s";
			case 19: return "t";
			case 20: return "u";
			case 21: return "v";
			case 22: return "w";
			case 23: return "x";
			case 24: return "y";
			case 25: return "z";
		}
	}
	
	

	
	
	
	function str_getInputEleValValueByName($contents, $refID)
	{
		$pos = strpos($contents, "name=\"" . $refID . "\"");
		if( $pos === FALSE ) return "";
		
		$copy = substr($contents, 0, $pos);
		$start = strrpos($copy, "<input");
		if( $start === FALSE ) return "";
		
		$endTag = ">";
		$end = strpos($contents, ">", $pos);
		if( $end === FALSE ) return "";
		
		$searchStr = subStr($contents, $start, $end - $start + 1);
		$ret = str_returnBetweenTags("value=\"", "\"", $searchStr);
		return $ret;
	}
	
	function str_getEleValValueByName($contents, $refID, $type = "input")
	{
		if( $contents == "" ||
		    $refID    == "" )
		{
			return "";
		}
		
		switch($type)
		{
			case "input":  return str_getInputEleValValueByName($contents, $refID);
			default:       return "";
		}
	}
	
	

	
	
	
	function str_similar($first, $second, $threshold = 50.0)
	{
		$first     = (string)$first;
		$second    = (string)$second;
		$threshold = (float)$threshold;
		
		if( $first == "" && $second == "" ) return TRUE;
		else if( $first == "" )             return FALSE;
		else if( $second == "" )            return FALSE;
		
		$percent = 0.0;
		if( strlen($first) >= strlen($second) )
		{
			similar_text($first, $second, $percent);
		}
		else
		{
			similar_text($second, $first, $percent);
		}
		return ((float)$percent) > $threshold;
	}
	
	

	
	// Function:  A wider scope line clean
	function str_cleanPunctuation($refStr)
	{
		$result = $refStr;
		$elipses = str_ends($result, "...");
		
		$before = "";
		while( $before != $result )
		{
			$before = $result;
			$result = trim($result);
			$result = str_replaceAll($result, " .",   ".");
			$result = str_replaceAll($result, " ,",   ",");
			$result = str_replaceAll($result, ",.",   ".");
			$result = str_replaceAll($result, "..",   ".");
			$result = str_replaceAll($result, ",,",   ",");
			$result = str_replaceAll($result, ":.",   ":");
			$result = str_replace("  ", " ", $result);
			$result = trim($result);
		}
		
		if( $elipses )
		{
			$result = trim($result, ".");
			$result .= "...";
		}
		
		return $result;
	}
	
	function str_punctuationExpand($refStr)
	{
		$temp = " " . trim($refStr) . " ";
		$temp = str_replace(".", " . ", $temp);
		$temp = str_replace(",", " , ", $temp);
		$temp = str_replace(";", " ; ", $temp);
		$temp = str_replace(":", " : ", $temp);
		$temp = str_replace("(", " ( ", $temp);
		$temp = str_replace(")", " ) ", $temp);
		$temp = str_replace(".)", ").", $temp);
		$temp = str_replace("/", " / ", $temp);
		// - intentionally skipped
		$temp = str_replace("  ", " ",  $temp);
		return $temp;
	}
	
	function str_punctuationShrink($refStr)
	{
		$temp = trim($refStr);
		$temp = str_replace(" .", ".", $temp);
		$temp = str_replace(" ,", ",", $temp);
		$temp = str_replace(" ;", ";", $temp);
		$temp = str_replace(" :", ":", $temp);
		$temp = str_replace("( ", "(", $temp);
		$temp = str_replace(" )", ")", $temp);
		$temp = str_replace("/ ", "/", $temp);
		$temp = str_replace(" /", "/", $temp);
		$temp = str_replace("- ", "-", $temp);
		$temp = str_replace(" -", "-", $temp);
//		$temp = str_replace("..", ".", $temp);
		$temp = str_replace("  ", " ", $temp);
		return $temp;
	}
	
	function str_punctuationRemove($refStr)
	{
		$temp = trim($refStr);
		$temp = str_replace(".",  " ", $temp);
		$temp = str_replace(",",  " ", $temp);
		$temp = str_replace(";",  " ", $temp);
		$temp = str_replace(":",  " ", $temp);
		$temp = str_replace("(",  " ", $temp);
		$temp = str_replace(")",  " ", $temp);
		$temp = str_replace("!",  " ", $temp);
		$temp = str_replace("?",  " ", $temp);
		$temp = str_replace("  ", " ", $temp);
		return $temp;
	}
	
	function str_condenseWhitespace($refStr)
	{
		if( gettype($refStr) != "string" ) return $refStr;
		$temp = trim($refStr);
		$temp = str_replaceAll($temp, "\t",   " ");
		$temp = str_replaceAll($temp, "\r\n", "\n");
		$temp = str_replaceAll($temp, "\n\r", "\n");
		$temp = str_replaceAll($temp, " \n",  "\n");
		$temp = str_replaceAll($temp, "\n ",  "\n");
		$temp = str_replaceAll($temp, "\n\n", "\n");
		$temp = str_replaceAll($temp, "  ",   " ");
		$temp = str_replaceAll($temp, " <",   "<");
		$temp = str_replaceAll($temp, "< ",   "<");
		$temp = str_replaceAll($temp, " >",   ">");
		$temp = str_replaceAll($temp, "> ",   ">");
		return $temp;
	}
	
	function str_truncate($refStr, $refLen)
	{
		$refLen = (int)$refLen;
		if( $refLen < 1 )
		{
			logError("str_truncate - Invalid length (" . $refLen . ") - Trace:  " . getBackTraceStr());
			return $refStr;
		}
		if( strlen($refStr) < $refLen ) return $refStr;
		
		return trim(substr($refStr, 0, $refLen)) . "...";
	}
	
	function str_processOwnership($refOwner)
	{
		global $cache_AirframeMilitaryServiceLookUp_Designation;

		if( $refOwner == ""                          ||
		    $refOwner == "Part 91: General Aviation" )
		{
			return "";
		}

		$ownCopy = $refOwner;
		$ownCopy = str_replaceQuotes($ownCopy);
		$ownCopy = str_normalizeOrds($ownCopy);
		if( strpos($ownCopy, "to ") === 0 ) $ownCopy = substr($ownCopy, 3);
		$ownCopy = trim($ownCopy, ".");
		$ownCopy = trim($ownCopy);

		if( str_starts($ownCopy, "Operator - ") )
		{
			$ownCopy = str_lTrim($ownCopy, "Operator - ");
		}
		$ownCopy = " " . $ownCopy . " ";

		$ownCopy = str_replaceAll($ownCopy, ", S. A ",                " S.A. ");
		$ownCopy = str_replaceAll($ownCopy, " and based at ",         ", ");
		$ownCopy = str_replaceAll($ownCopy, " at ",                   ", ");
		$ownCopy = str_replaceAll($ownCopy, " based at ",             ", ");
		$ownCopy = str_replaceAll($ownCopy, " Dept ",                 " Department ");
		$ownCopy = str_replaceAll($ownCopy, " Department Of ",        " Department of ");
		$ownCopy = str_replaceAll($ownCopy, " Ft. ",                  " Fort ");
		$ownCopy = str_replaceAll($ownCopy, " Inc.",                  " Inc");
		$ownCopy = str_replaceAll($ownCopy, " INC.",                  " Inc");
		$ownCopy = str_replaceAll($ownCopy, " LLC.",                  " Llc");
		$ownCopy = str_replaceAll($ownCopy, " Llc.",                  " Llc");
		$ownCopy = str_replaceAll($ownCopy, " LTD.",                  " Ltd");
		$ownCopy = str_replaceAll($ownCopy, " Ltd.",                  " Ltd");
		$ownCopy = str_replaceAll($ownCopy, " MR.",                   " Mr");
		$ownCopy = str_replaceAll($ownCopy, " MR ",                   " Mr ");
		$ownCopy = str_replaceAll($ownCopy, " MRS.",                  " Mrs");
		$ownCopy = str_replaceAll($ownCopy, " MRS ",                  " Mrs ");
		$ownCopy = str_replaceAll($ownCopy, " Mrs.",                  " Mrs");
		$ownCopy = str_replaceAll($ownCopy, "Us Department Of State", "US Department of State");
		$ownCopy = str_replaceAll($ownCopy, "Us Navy",                "US Navy");
		if( strpos($ownCopy, "Department of") === FALSE )
		$ownCopy = str_punctuationShrink($ownCopy);

//echo("str_processOwnership - WAYPOINT A:  " . $ownCopy . "<br>\n");
		// Reorder reversed individual owner name
		$ownCopy = str_replace(", ", ",", $ownCopy);
		$chunks = explode(",", $ownCopy);
		$firstChunk = trim($chunks[0]);
		$trust = "";
			if( str_ends($firstChunk, "Trustee") )
			{
				$trust = " Trustee";
				$firstChunk = trim(str_rTrim($firstChunk, "Trustee"));
			}
			else if( str_ends($firstChunk, "trustee") )
			{
				$trust = " Trustee";
				$firstChunk = trim(str_rTrim($firstChunk, "trustee"));
			}
		$dba = "";
			if( str_ends($firstChunk, "DBA") )
			{
				$dba = " DBA";
				$firstChunk = trim(str_rTrim($firstChunk, "DBA"));
			}
		$jr = "";
			if( str_ends($firstChunk, "Jr") )
			{
				$jr = " Jr";
				$firstChunk = trim(str_rTrim($firstChunk, "Jr"));
			}
		$sr = "";
			if( str_ends($firstChunk, "Sr") )
			{
				$sr = " Sr";
				$firstChunk = trim(str_rTrim($firstChunk, "Sr"));
			}
		$firstChunkWords = explode(" ", $firstChunk);
		$firstChunkWordsSize = count($firstChunkWords);
		$lastFirstChunkWord = $firstChunkWords[$firstChunkWordsSize - 1];
		if( $lastFirstChunkWord == "Inc" )
		{
			// Do nothing
		}
		if
        (
            $firstChunkWordsSize                              == 3 &&
		    strlen($lastFirstChunkWord)                       == 1 &&
		    preg_match("/^([0-9]{1})$/", $lastFirstChunkWord) == 0 &&
            $firstChunkWords[1] !== "and"
        ) {
			$firstChunk = $firstChunkWords[1] . " " . $firstChunkWords[2] . ". " . $firstChunkWords[0];
			$chunks[0]  = $firstChunk . $dba . $jr . $sr . $trust;
		}

        // Check for postal information in the first chunk
		$tag = "Po Box";
			$pos = strpos($chunks[0], $tag);
		    if( $pos !== FALSE ) $chunks[0] = trim(substr($chunks[0], 0, $pos));
		$tag = "PO Box";
			$pos = strpos($chunks[0], $tag);
		    if( $pos !== FALSE ) $chunks[0] = trim(substr($chunks[0], 0, $pos));
		$tag = "P.O. Box";
			$pos = strpos($chunks[0], $tag);
		    if( $pos !== FALSE ) $chunks[0] = trim(substr($chunks[0], 0, $pos));

		// Trim from left side of the first chunk
		$tag = "MR ";
			if( str_starts($chunks[0], $tag) ) $chunks[0] = str_lTrim($chunks[0], $tag);
		$tag = "MRS ";
			if( str_starts($chunks[0], $tag) ) $chunks[0] = str_lTrim($chunks[0], $tag);

		// Reassemble the chunks
		$ownCopy = implode(", ", $chunks);
//echo("str_processOwnership - WAYPOINT B:  " . $ownCopy . "<br>\n");

		// Scan the words
		$ownCopy = trim(str_punctuationExpand($ownCopy));
		$ownCopy = str_replace("/", " / ", $ownCopy);
		$ownCopy = str_replace("-", " - ", $ownCopy);
		$ownCopy = str_replace("  ", " ", $ownCopy);
		$words = explode(" ", $ownCopy);
		$wordsSize = count($words);
		for( $index = 0; $index < $wordsSize; $index++ )
		{
			$aWord = $words[$index];
			$aWordLower = str_lower($aWord);
			$aWordUpper = str_upper($aWord);
			
			// Match:  Exact
			switch($aWordLower)
			{
				case "ad":       $aWord = "AD";            break;
				case "afb":      $aWord = "AFB";           break;
				case "afres":    $aWord = "AFRES";         break;
				case "afs":      $aWord = "AFS";           break;
				case "airp":     $aWord = "Airport";       break;
				case "and":      $aWord = "and";           break;
				case "ann":      $aWord = "Ann";           break;
				case "cfb":      $aWord = "CFB";           break;
				case "cma":      $aWord = "CMA";           break;
				case "dba":      $aWord = "DBA";           break;
				case "de":       $aWord = "de";            break;
				case "dept":     $aWord = "Department";    break;
				case "des":      $aWord = "Des";           break;
				case "ectt":     $aWord = "ECTT";          break;
				case "ft":       $aWord = "Fort";          break;
				case "ge":       $aWord = "GE";            break;
				case "gm":       $aWord = "GM";            break;
				case "ii":       $aWord = "II";            break;
				case "iii":      $aWord = "III";           break;
				case "inc":      $aWord = "Inc";           break;
				case "intl":     $aWord = "International"; break;
				case "jr":       $aWord = "Jr";            break;
				case "llc":      $aWord = "Llc";           break;
				case "ltd":      $aWord = "Ltd";           break;
				case "mr":       $aWord = "Mr.";           break;
				case "mrs":      $aWord = "Mrs.";          break;
				case "muni":     $aWord = "Municipal";     break;
				case "nas":      $aWord = "NAS";           break;
				case "niteops":  $aWord = "NITEOPS";       break;
				case "of":       $aWord = "of";            break;
				case "rnas":     $aWord = "RNAS";          break;
				case "san":      $aWord = "San";           break;
				case "sr":       $aWord = "Sr";            break;
				case "st":       $aWord = "Saint";         break;
				case "squadron": $aWord = "Squadron";      break;
				case "uscgas":   $aWord = "USCGAS";        break;
				case "usa":      $aWord = "USA";           break;
				case "usda":     $aWord = "USDA";          break;
				case "uss":      $aWord = "USS";           break;
				case "us":       $aWord = "US";            break;
				case "usafa":    $aWord = "USAFA";         break;
				case "usntps":   $aWord = "USNTPS";        break;
				case "vfw":      $aWord = "VFW";           break;
				case "vmfa":     $aWord = "VMFA";          break;
				
				default:
				{
					// Match:  Pattern to lower
					if
					(
						preg_match("/^([0-9]{1,4}st)$/", $aWordLower) > 0 ||
						preg_match("/^([0-9]{1,4}nd)$/", $aWordLower) > 0 ||
						preg_match("/^([0-9]{1,4}rd)$/", $aWordLower) > 0 ||
						preg_match("/^([0-9]{1,4}th)$/", $aWordLower) > 0
					)
					{
						$aWord = $aWordLower;
					}
					
					// Match:  Pattern to upper
					else if
					(
						preg_match("/^([abcdefghijklmnopqrstuvwxyz]{2,3}-[0-9]{2,3})$/", $aWordLower) > 0 // Example:  va-42
					)
					{
						$aWord = $aWordUpper;
					}
					
                    // Match:  Civil registration, all consanents and all vowels
					else if
					(
						isValidCR($aWordUpper) ||
						preg_match("/^([abcdefghijklmnopqrstuvwxyz]{1)$/", $aWordLower) > 0 ||
						(preg_match("([bcdfghjklmnpqrstvwxz]{1,})", $aWordLower) > 0 && preg_match("([aeiouy]{1,})", $aWordLower) == 0) || // all concenants no vowels
						(preg_match("([bcdfghjklmnpqrstvwxz]{1,})", $aWordLower) == 0 && preg_match("([aeiouy]{1,})", $aWordLower) > 0) || // no concenants all vowels
						(preg_match("([0123456789]{1,})", $aWordLower) == 0 && preg_match("([aeiouy]{1,})", $aWordLower) == 0)
					)
					{
						$aWord = $aWordUpper;
					}
					
					// Match:  If word starts with "Mc", capitalize the first letter of the remaining
					else if( str_starts($aWord, "Mc") )
					{
						$aWord = str_ltrim($aWord, "Mc");
						$aWord = "Mc" . str_capWords($aWord);
					}
					
					// Match:  The word "in" is used where it should be a comma
                    else if( $aWordLower == "in" && $index < ($wordsSize - 3) ) {
                        $mIndex = array_search("Museum", $words) ||
                                  array_search("museum", $words);
                        if( $mIndex !== FALSE && $index > $mIndex )
                        {
                            $aWord = " , ";
                        }
                    }
				}
			}
			
			$words[$index] = $aWord;
		}

		$ownCopy = implode(" ", $words);
		$ownCopy = str_punctuationShrink($ownCopy);

		// String search replacement
		$ownCopy = " " . $ownCopy . " ";
		$ownCopy = str_replaceAll($ownCopy, ", ST ",  ", Saint ");
		$ownCopy = str_replaceAll($ownCopy, ", ST. ", ", Saint ");
		$ownCopy = str_replaceAll($ownCopy, " DR ",   " Doctor ");
		$ownCopy = str_replaceAll($ownCopy, " DR. ",  " Doctor ");

		// Check for trailing region designation
		$ownCopy = str_replaceAll($ownCopy, ", ", ",");
		$bits = explode(",", $ownCopy);
		$size = count($bits);
		$lastSegment = $bits[$size-1];
			$converted = geoUtilities_regionConvertAbbreviatedToFull($lastSegment);
			if( $converted != $lastSegment )
			{
				$lastSegment = geoUtilities_regionConvertFullToAbbreviated($converted);
			}
			else
			{
				$temp = geoUtilities_regionConvertFullToAbbreviated($lastSegment);
				if( $temp != $converted )
				{
					$lastSegment = $temp;
				}
				else
				{
					$low = str_lower($lastSegment); 
					switch($low)
					{
						case "ont": $lastSegment = "ON"; break;
						default:
					}
				}
			}
		$bits[$size-1] = $lastSegment;
		$ownCopy = trim(implode(", ", $bits));

		// Scan for lower case following hyphens
		$len = strlen($ownCopy);
		$index = 0;
		while( $index !== FALSE && $index < $len )
		{
			$index = strpos($ownCopy, "-", $index);
			if( $index !== FALSE && ($index + 1) < $len && $ownCopy[$index + 1] != " " )
			{
				$ownCopy[$index + 1] = strtoupper($ownCopy[$index + 1]);
			}
            $index++;
		}

		// Trim away undesired trailing characters
		$ownCopy  = str_rTrim($ownCopy , "?");

		// Done!
		if( $ownCopy == "" )
		{
			return $refOwner;
		}
		return $ownCopy;
	}

	define("EXACT_MATCH", 99.9);
	function str_nearOwnershipMatch($own1, $own2, $threshold = 70.0, &$actual = 0.0)
	{
		$own1 = str_replaceAll(str_lower(str_altASCII(str_processOwnership($own1))), " ", "");
		$own2 = str_replaceAll(str_lower(str_altASCII(str_processOwnership($own2))), " ", "");
        $actual = 0.0;
		similar_text($own1, $own2, $actual);
		return $actual >= $threshold;
	}
	
	function str_convertShortHand($refStr)
	{
		$temp = trim($refStr);
		$temp = str_replace("  ", " ", $temp);
		$temp = str_replaceQuotes($temp);
		$temp = str_normalizeOrds($temp);
		if( str_isUpper($temp) )
		{
			$temp = str_lower($temp);
		}
		
		$temp = str_replace(" 0-",          " zero-",                            $temp);
		$temp = str_replace(" 1-",          " one-",                             $temp);
		$temp = str_replace(" 2-",          " two-",                             $temp);
		$temp = str_replace(" 3-",          " three-",                           $temp);
		$temp = str_replace(" 4-",          " four-",                            $temp);
		$temp = str_replace(" 5-",          " five-",                            $temp);
		$temp = str_replace(" 6-",          " six-",                             $temp);
		$temp = str_replace(" 7-",          " seven-",                           $temp);
		$temp = str_replace(" 8-",          " eight-",                           $temp);
		$temp = str_replace(" 9-",          " nine-",                            $temp);
		$temp = str_replace(" circuit br ", " circuit breaker ",                 $temp);
		$temp = str_replace(", Co., ",      "  Co, ",                            $temp);
		$temp = str_replace(",Co., ",       "  Co, ",                            $temp);
		$temp = str_replace(" Co., ",       "  Co, ",                            $temp);
		$temp = str_replace(", CO., ",      "  Co, ",                            $temp);
		$temp = str_replace(",CO., ",       "  Co, ",                            $temp);
		$temp = str_replace(" CO., ",       "  Co, ",                            $temp);
		$temp = str_replace(" ft. agl ",    " ft AGL ",                          $temp);
		$temp = str_replace("fpl ctlr",     "full performance level controller", $temp);
		$temp = str_replace(", Inc., ",     "  Inc, ",                           $temp);
		$temp = str_replace(",Inc., ",      "  Inc, ",                           $temp);
		$temp = str_replace(" Inc., ",      "  Inc, ",                           $temp);
		$temp = str_replace(", INC., ",     "  Inc, ",                           $temp);
		$temp = str_replace(",INC., ",      "  Inc, ",                           $temp);
		$temp = str_replace(" INC., ",      "  Inc, ",                           $temp);
		$temp = str_replace(", Ltd., ",     "  Ltd, ",                           $temp);
		$temp = str_replace(",Ltd., ",      "  Ltd, ",                           $temp);
		$temp = str_replace(" Ltd., ",      "  Ltd, ",                           $temp);
		$temp = str_replace(", LTD., ",     "  Ltd, ",                           $temp);
		$temp = str_replace(",LTD., ",      "  Ltd, ",                           $temp);
		$temp = str_replace(" LTD., ",      "  Ltd, ",                           $temp);
		$temp = str_replace(" master sw ",  " master switch ",                   $temp);
		$temp = str_replace(" MK.",         " Mk ",                              $temp);
		$temp = str_replace(" Mk.",         " Mk ",                              $temp);
		$temp = str_replace(" mk.",         " Mk ",                              $temp);
		$temp = str_replace(" no. 1 ",       " #1 ",                              $temp);
		$temp = str_replace(" no.1 ",       " #1 ",                              $temp);
		$temp = str_replace(" no. 2 ",       " #2 ",                              $temp);
		$temp = str_replace(" no.2 ",       " #2 ",                              $temp);
		$temp = str_replace(" no. 3 ",       " #3 ",                              $temp);
		$temp = str_replace(" no.3 ",       " #3 ",                              $temp);
		$temp = str_replace(" no. 4 ",       " #4 ",                              $temp);
		$temp = str_replace(" no.4 ",       " #4 ",                              $temp);
		$temp = str_replace(" no 1 ",       " #1 ",                              $temp);
		$temp = str_replace(" no 2 ",       " #2 ",                              $temp);
		$temp = str_replace(" no 3 ",       " #3 ",                              $temp);
		$temp = str_replace(" no 4 ",       " #4 ",                              $temp);
		$temp = str_replace(" nbr ",        " nr ",                              $temp);
		$temp = str_replace(" nr 1 ",       " #1 ",                              $temp);
		$temp = str_replace(" nr 2 ",       " #2 ",                              $temp);
		$temp = str_replace(" nr 3 ",       " #3 ",                              $temp);
		$temp = str_replace(" nr 4 ",       " #4 ",                              $temp);
		$temp = str_replace(" nr ",         " number ",                          $temp);
		
		// Patterns	
		$pattern = "/(\d+),(\d+)/i";
			$replacement = "$1$2";
			$temp = preg_replace($pattern, $replacement, $temp);
		$temp = str_punctuationExpand($temp);
		$pattern = "/ fl(\d+) /i";
			$replacement = " flight level $1 ";
			$temp = preg_replace($pattern, $replacement, $temp);
		$pattern = "/ (\d+)ias /i";
			$replacement = " $1 indicated air speed ";
			$temp = preg_replace($pattern, $replacement, $temp);
		$pattern = "/ (\d+)ft /i";
			$replacement = " $1 feet ";
			$temp = preg_replace($pattern, $replacement, $temp);
		$pattern = "/ ([0-9]{2})l /i";
			$replacement = " $1L ";
			$temp = preg_replace($pattern, $replacement, $temp); // 27l => 27L
		$pattern = "/ ([0-9]{2})r /i";
			$replacement = " $1R ";
			$temp = preg_replace($pattern, $replacement, $temp); // 27r => 27R	
		$temp = str_cleanPunctuation($temp);
		$pattern = "/ (\d+)\.(\d+) /i";
			$replacement = " $1xDOTx$2 ";
			$temp = preg_replace($pattern, $replacement, $temp);
		$pattern = "/ (\d+),(\d+) /i";
			$replacement = " $1xCOMMAx$2 ";
			$temp = preg_replace($pattern, $replacement, $temp);
		
		// Loop through the words
		$temp = trim($temp);
		$temp = str_replace("  ", " ", $temp);
		$words = explode(" ", $temp);
		$wordsSize = count($words);
		for( $index = 0; $index < $wordsSize; $index++ )
		{
			$aWord = $words[$index];

// bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbb
//			// Convert to upper case if it contains a number
//			if( str_contains($aWord, "0") ||
//			    str_contains($aWord, "1") ||
//			    str_contains($aWord, "2") ||
//			    str_contains($aWord, "3") ||
//			    str_contains($aWord, "4") ||
//			    str_contains($aWord, "5") ||
//			    str_contains($aWord, "6") ||
//			    str_contains($aWord, "7") ||
//			    str_contains($aWord, "8") ||
//			    str_contains($aWord, "9") )
//			{
//				$aWord = str_upper($aWord);
//			}
			
			// Check for civil registration
//			else
			 if( isValidCR(str_upper($aWord)) )
			{
				$aWord = str_upper($aWord);
			}
			
			// Check for a two letter region code
			else if( $index              > 0   &&
			         $words[$index - 1] == "," &&
			         strlen($aWord)     == 2   )
			{
				$converted = geoUtilities_regionConvertAbbreviatedToFull($aWord);
				if( $converted != $aWord )
				{
					$aWord = str_upper($aWord);
				}
			}
			
			// Convert full state text to designation
			else if( $aWord == "," )
			{
				$aState = $words[$index];
				$converted = geoUtilities_regionConvertFullToAbbreviated($aState);
				if( $aState != $converted )
				{
					$words[$index] = $converted;
				}
				else
				{
					$aState = $words[$index] . " " . $words[$index + 1];
					$converted = geoUtilities_regionConvertFullToAbbreviated($aState);
					if( $aState != $converted )
					{
						$words[$index]     = $converted;
						$words[$index + 1] = "";
						$index++;
					}
					else
					{
						$aState = $words[$index] . " " . $words[$index + 1] . " " . $words[$index + 2];
						$converted = geoUtilities_regionConvertFullToAbbreviated($aState);
						if( $aState != $converted )
						{
							$words[$index]     = $converted;
							$words[$index + 1] = "";
							$words[$index + 2] = "";
							$index = $index + 2;
						}
					}
				}
			}
			
			// Convert short hand
			else
			{
				// Specific cases
				switch($aWord)
				{
					case "january":
					case "jan":       $aWord = "January";   break;
					case "february":
					case "febr":
					case "feb":       $aWord = "February";  break;
					case "march":
					case "mar":       $aWord = "March";     break;
					case "april":
					case "apr":       $aWord = "April";     break;
					//case "may":
					case "mai":       $aWord = "May";       break;
					case "june":
					case "jun":       $aWord = "June";      break;
					case "july":
					case "jul":       $aWord = "July";      break;
					case "august":
					case "aug":       $aWord = "August";    break;
					case "september":
					case "sept":
					case "sep":       $aWord = "September"; break;
					case "october":
					case "oct":       $aWord = "October";   break;
					case "november":
					case "nov":       $aWord = "November";  break;
					case "december":
					case "dec":       $aWord = "December";  break;
					
					case "0":         $aWord = "zero";  break;
					case "1":         $aWord = "one";   break;
					case "2":         $aWord = "two";   break;
					case "3":         $aWord = "three"; break;
					case "4":         $aWord = "four";  break;
					case "5":         $aWord = "five";  break;
					case "6":         $aWord = "six";   break;
					case "7":         $aWord = "seven"; break;
					case "8":         $aWord = "eight"; break;
					case "9":         $aWord = "nine";  break;
					
					case "1st":       $aWord = "first";  break;
					case "2nd":       $aWord = "second"; break;
					case "3rd":       $aWord = "third";  break;
					
					case "&":          $aWord = "and";                                  break;
					case "1/2":        $aWord = "half";                                 break;
					case "acc":        $aWord = "accident";                             break;
					case "accd":       $aWord = "accident";                             break;
					case "acft":       $aWord = "aircraft";                             break;
					case "acfts":      $aWord = "aircraft";                             break;
					case "afb":        $aWord = "AFB";                                  break;
					case "Afb":        $aWord = "AFB";                                  break;
					case "afbase":     $aWord = "AFB";                                  break;
					case "agl":        $aWord = "above ground level";                   break;
					case "alt":        $aWord = "altitude";                             break;
					case "ang":        $aWord = "Air National Guard";                   break;
					case "apch":       $aWord = "approach";                             break;
					case "appch":      $aWord = "approach";                             break;
					case "aprt":       $aWord = "airport";                              break;
					case "aprx":       $aWord = "approximately";                        break;
					case "arpt":       $aWord = "airport";                              break;
					case "artcc":      $aWord = "ARTCC";                                break;
					case "assy":       $aWord = "assembly";                             break;
					case "atmt":       $aWord = "attempt";                              break;
					case "auth":       $aWord = "authorized";                           break;
					case "avbl":       $aWord = "available";                            break;
					case "bfor":       $aWord = "before";                               break;
					case "bgn":        $aWord = "began";                                break;
					case "cfi":        $aWord = "CFI";                                  break;
					case "cg":         $aWord = "center of gravity";                    break;
					case "chg":        $aWord = "change";                               break;
					case "clb":        $aWord = "climb";                                break;
					case "clrd":       $aWord = "cleared";                              break;
					case "co-plt":     $aWord = "co-pilot";                             break;
					case "coplts":     $aWord = "co-pilots";                            break;
					case "comd":       $aWord = "command";                              break;
					case "cond":       $aWord = "condition";                            break;
					case "conds":      $aWord = "conditions";                           break;
					case "cont":       $aWord = "continued";                            break;
					case "contd":      $aWord = "continued";                            break;
					case "coplt":      $aWord = "co-pilot";                             break;
					case "cs":         $aWord = "CS";                                   break;
					case "ctl":        $aWord = "control";                              break;
					case "ctlr":       $aWord = "controller";                           break;
					case "ctr":        $aWord = "center";                               break;
					case "cyl":        $aWord = "cylinder";                             break;
					case "dest":       $aWord = "destination";                          break;
					case "deg":        $aWord = "degree";                               break;
					case "degs":       $aWord = "degree";                               break;
					case "dep":        $aWord = "departure";                            break;
					case "deptd":      $aWord = "departed";                             break;
					case "dmg":        $aWord = "damage";                               break;
					case "drg":        $aWord = "during";                               break;
					case "drctn":      $aWord = "direction";                            break;
					case "dscndg":     $aWord = "descending";                           break;
					case "dsndd":      $aWord = "descended";                            break;
					case "elv":        $aWord = "elevation";                            break;
					case "enctrd":     $aWord = "encountered";                          break;
					case "eng":        $aWord = "engine";                               break;
					case "engs":       $aWord = "engines";                              break;
					case "emerg":      $aWord = "emergency";                            break;
					case "exh":        $aWord = "exhaust";                              break;
					case "fap":        $aWord = "FAP";                                  break;
					case "feath":      $aWord = "feather";                              break;
					case "fld":        $aWord = "field";                                break;
					case "flt":        $aWord = "flight";                               break;
					case "fm":         $aWord = "from";                                 break;
					case "freq":       $aWord = "frequency";                            break;
					case "ft":         $aWord = "feet";                                 break;
					case "fwd":        $aWord = "forward";                              break;
					case "g":          $aWord = "G";                                    break;
					case "gals":       $aWord = "G";                                    break;
					case "gnd":        $aWord = "ground";                               break;
					case "grnd":       $aWord = "ground";                               break;
					case "govt":       $aWord = "government";                           break;
					case "gr":         $aWord = "gear";                                 break;
					case "hi":         $aWord = "high";                                 break;
					case "hdg":        $aWord = "heading";                              break;
					case "hyd":        $aWord = "hydrualic";                            break;
					case "ifr":        $aWord = "IFR";                                  break;
					case "�ms":        $aWord = "instrument meteorological conditions"; break;
					case "inducd":     $aWord = "induced";                              break;
					case "inop":       $aWord = "inoperable";                           break;
					case "insp":       $aWord = "inspection";                           break;
					case "inspn":      $aWord = "inspection";                           break;
					case "intntl":     $aWord = "intentional";                          break;
					case "invest":     $aWord = "investigation";                        break;
					case "ip":         $aWord = "instructor pilot";                     break;
					case "isl":        $aWord = "island";                               break;
					case "kts":        $aWord = "knots";                                break;
					case "l":          $aWord = "left";                                 break;
					case "ld":         $aWord = "land";                                 break;
					case "lft":        $aWord = "left";                                 break;
					case "ldg":        $aWord = "landing";                              break;
					case "lnd":        $aWord = "land";                                 break;
					case "lndd":       $aWord = "landed";                               break;
					case "lndg":       $aWord = "landing";                              break;
					case "lt":         $aWord = "light";                                break;
					case "ltd":        $aWord = "lighted";                              break;
					case "mag":        $aWord = "magneto";                              break;
					case "malfunct":   $aWord = "malfunctioned";                        break;
					case "mda":        $aWord = "MDA";                                  break;
					case "mi":         $aWord = "mile";                                 break;
					case "msl":        $aWord = "MSL";                                  break;
					case "multi-eng":  $aWord = "multi-engined";                        break;
					case "nas":        $aWord = "NAS";                                  break;
					case "Nas":        $aWord = "NAS";                                  break;
					case "nav":        $aWord = "navigation";                           break;
					case "ne":         $aWord = "north-east";                           break;
					case "nite":       $aWord = "night";                                break;
					case "nrby":       $aWord = "nearby";                               break;
					case "nw":         $aWord = "north-west";                           break;
					case "ok":         $aWord = "OK";                                   break;
					case "oper":       $aWord = "operator";                             break;
					case "ops":        $aWord = "operations";                           break;
					case "otr":        $aWord = "outer";                                break;
					case "pax":        $aWord = "passengers";                           break;
					case "pdt":        $aWord = "PDT";                                  break;
					case "pic":        $aWord = "pilot in command";                     break;
					case "plt":        $aWord = "pilot";                                break;
					case "plt-rated":  $aWord = "pilot-rated";                          break;
					case "pos":        $aWord = "position";                             break;
					case "plts":       $aWord = "pilots";                               break;
					case "pos":        $aWord = "position";                             break;
					case "pre-flt":    $aWord = "pre-flight inspection";                break;
					case "pt":         $aWord = "point";                                break;
					case "pvt":        $aWord = "private";                              break;
					case "prw":        $aWord = "power";                                break;
					case "pwr":        $aWord = "power";                                break;
					case "qual":       $aWord = "qualification";                        break;
					case "r":          $aWord = "right";                                break;
					case "rdo":        $aWord = "radio";                                break;
					case "re":         $aWord = "RE";                                   break;
					case "recd":       $aWord = "recorded";                             break;
					case "recov":      $aWord = "recovery";                             break;
					case "reptd":      $aWord = "reported";                             break;
					case "rgt":        $aWord = "right";                                break;
					case "rt":         $aWord = "right";                                break;
					case "rnwy":       $aWord = "runway";                               break;
					case "rwy":        $aWord = "runway";                               break;
					case "rpm":        $aWord = "RPM";                                  break;
					case "rprtd":      $aWord = "reported";                             break;
					case "rpted":      $aWord = "reported";                             break;
					case "rwy":        $aWord = "runway";                               break;
					case "se":         $aWord = "south-east";                           break;
					case "serv":       $aWord = "service";                              break;
					case "shwrs":      $aWord = "showers";                              break;
					case "single-eng": $aWord = "single-engined";                       break;
					case "snw":        $aWord = "snow";                                 break;
					case "sub":        $aWord = "substantial";                          break;
					case "substl":     $aWord = "substantial";                          break;
					case "sw":         $aWord = "south-west";                           break;
					case "sys":        $aWord = "system";                               break;
					case "tkof":       $aWord = "takeoff";                              break;
					case "t/o":        $aWord = "takeoff";                              break;
					case "tng":        $aWord = "training";                             break;
					case "tso":        $aWord = "TSO";                                  break;
					case "turb":       $aWord = "turbulence";                           break;
					case "twr":        $aWord = "tower";                                break;
					case "undet":      $aWord = "undetermined";                         break;
					case "unltd":      $aWord = "unlighted";                            break;
					case "unkn":       $aWord = "unknown";                              break;
					case "usaf":       $aWord = "USAF";                                 break;
					case "vcnty":      $aWord = "vicinity";                             break;
					case "vfr":        $aWord = "VFR";                                  break;
					case "vmc":        $aWord = "visual meterological conditions";      break;
					case "vor":        $aWord = "VOR";                                  break;
					case "wea":        $aWord = "weather";                              break;
					case "wt":         $aWord = "wet";                                  break;
					case "wx":         $aWord = "weather";                              break;
					case "x-country":  $aWord = "cross country";                        break;
					case "x-wind":     $aWord = "cross wind";                           break;
				 	
					
					
					
				}
			} // end of examine for shorthand
			$words[$index] = $aWord;
		} // end of loop through words
		$temp = implode(" ", $words);
		
		$temp = str_replace(", and ",                  " and ",                   $temp);
		$temp = str_replace(" eastern standard time",  " Eastern Standard Time",  $temp);
		$temp = str_replace(" central standard time",  " Central Standard Time",  $temp);
		$temp = str_replace(" mountain standard time", " Mountain Standard Time", $temp);
		$temp = str_replace(" pacific standard time",  " Pacific Standard Time",  $temp);
		
		$temp = str_punctuationShrink($temp);
		$pattern = "/(\d+)xDOTx(\d+)/i";
			$replacement = "$1.$2";
			$temp = preg_replace($pattern, $replacement, $temp);
		$pattern = "/(\d+)xCOMMAx(\d+)/i";
			$replacement = "$1,$2";
			$temp = preg_replace($pattern, $replacement, $temp);
		return $temp;
	}
	
	function str_appendIfNotContained($haystack, $needle)
	{
		if( !str_contains($haystack, $needle) )
		{
			$haystack .= $needle;
		}
		return $haystack;
	}


*/

?>