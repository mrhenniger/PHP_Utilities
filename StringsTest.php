<?php
/*
Welcome to "StringsTest"

This is the test file used to ensure the string utilities behave as expected.
*/

include_once "Strings.php";
include_once "Tests.php";
$tests = new Tests();



// replaceAll
// Test 1:  Input not a string
$expected = "a1a2a3a";
$actual = Strings::_replaceAll("x1x2x3x", "x", "a");
$tests->add("Strings::_replaceAll", "Test 1", $actual === $expected, $actual);

// Test 2:  Class
$subject = new Strings("x1x2x3x");
$expected = "a1a2a3a";
$actual = $subject->replaceAll("x", "a");
$tests->add("Strings->replaceAll", "Test 2", $actual->equals($expected), $actual);



// explode
// Test 1:  Input not a string
$expected = ["123"];
$actual = Strings::_explode("x", 123);
$tests->add("Strings::_explode", "Test 1", $actual === $expected, $actual);

// Test 2:  Empty input string
$expected = [];
$actual = Strings::_explode("x", "");
$tests->add("Strings::_explode", "Test 2", $actual === $expected, $actual);

// Test 3:  Delimit not in the string
$expected = ["123"];
$actual = Strings::_explode(",", "123");
$tests->add("Strings::_explode", "Test 3", $actual === $expected, $actual);

// Test 4:  Delimit not in the string
$expected = ["1","2","3"];
$actual = Strings::_explode(",", "1,2,3");
$tests->add("Strings::_explode", "Test 4", $actual === $expected, $actual);

// Test 5:  Trim the bordering spaces
$actual = Strings::_explode(",", " 1 , 2 , 3 ");
$tests->add("Strings::_explode", "Test 5a", count($actual) === 3, $actual);
$tests->add("Strings::_explode", "Test 5b", $actual[0] === "1", $actual);
$tests->add("Strings::_explode", "Test 5c", $actual[1] === "2", $actual);
$tests->add("Strings::_explode", "Test 5d", $actual[2] === "3", $actual);

// Test 6:  Normal
$actual = Strings::_explode(",", "a,b,c");
$tests->add("Strings::_explode", "Test 6a", count($actual) === 3, $actual);
$tests->add("Strings::_explode", "Test 6b", $actual[0] === "a", $actual);
$tests->add("Strings::_explode", "Test 6c", $actual[1] === "b", $actual);
$tests->add("Strings::_explode", "Test 6d", $actual[2] === "c", $actual);

// Test 7:  Class
$subject = new Strings("a,b,c");
$actual = $subject->explode(",");
$tests->add("Strings->explode", "Test 7a", count($actual) === 3, $actual);
$tests->add("Strings->explode", "Test 7b", $actual[0] === "a", $actual);
$tests->add("Strings->explode", "Test 7c", $actual[1] === "b", $actual);
$tests->add("Strings->explode", "Test 7d", $actual[2] === "c", $actual);



// str_lower
// Test 1:  Input not a string
$expected = "abcdefghi";
$actual = Strings::_lower(" aBcDeFgHi ");
$tests->add("Strings::_lower", "Test 1", $actual === $expected, $actual);

// Test 2:  Normal
$expected = "abcdefghi";
$actual = Strings::_lower("aBcDeFgHi");
$tests->add("Strings::_lower", "Test 2", $actual === $expected, $actual);

// Test 3:  Class
$subject = new Strings("ABC123");
$expected = "abc123";
$actual = $subject->lower();
$tests->add("Strings->lower", "Test 3", $actual->getCore() === $expected, $actual);



// str_uppper
// Test 1:  Input not a string
$expected = "ABCDEFGHI";
$actual = Strings::_upper(" aBcDeFgHi ");
$tests->add("Strings::_upper", "Test 1", $actual === $expected, $actual);

// Test 2:  Normal
$expected = "ABCDEFGHI";
$actual = Strings::_upper("aBcDeFgHi");
$tests->add("Strings::_upper", "Test 2", $actual === $expected, $actual);

// Test 3:  Class
$subject = new Strings("abc123");
$expected = "ABC123";
$actual = $subject->upper();
$tests->add("Strings->lower", "Test 3", $actual->getCore() === $expected, $actual);






// chaining
$expected = "abcdefghijk";
$subject = new Strings("aBcDeFgHiJk");
$actual = $subject->upper()->lower();
$tests->add("Strings chaining", "Test 1", $actual->getCore() === $expected, $actual);



$tests->dump();
?>