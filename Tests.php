<?php
/*
Welcome to "Tests"

This a simple utility for testing other classes.
*/

include_once "Strings.php";

class Tests {
    private $__testResults = [];

    public function add($function, $testName, $passFail, $actual) {
        $this->__testResults[] = [$function, $testName, $passFail, $actual];
    }

    public function dump() {
        echo("\n\n\n");
        echo ("Test results...");
        $passCount = 0;
        $failCount = 0;

        foreach($this->__testResults as $aResult) {
            $toEcho = $aResult[0] . " - " . $aResult[1] . " - ";
            $toEcho .= $aResult[2] ? "passed" : "FAILED";
            $toEcho .= "\n";
            echo ($toEcho);
            if (!$aResult[2]) {
                $failCount++;
                var_dump($aResult[3]);
            } else {
                $passCount++;
            }
        }
        
        echo("\n\n\n");
        echo("Passed:  " . $passCount . "\n");
        echo("Failed:  " . $failCount . "\n");
        echo("\n\n\n");
    }
}
?>