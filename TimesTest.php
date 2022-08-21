<?php
/*
Welcome to "TimesTest"

This is the test file used to ensure the time utilities behave as expected.
*/

include_once "Times.php";
include_once "Tests.php";
$tests = new Tests();


/* TESTS PENDING IMPLEMENTATION

// Test 1:  Input not a string
$expected = "a1a2a3a";
$actual = Strings::_replaceAll("x1x2x3x", "x", "a");
$tests->add("Strings::_replaceAll", "Test 1", $actual === $expected, $actual);

// Test 2:  Class
$subject = new Strings("x1x2x3x");
$expected = "a1a2a3a";
$actual = $subject->replaceAll("x", "a");
$tests->add("Strings->replaceAll", "Test 2", $actual->equals($expected), $actual);
*/



$tests->dump();
?>