<?php
ini_set('display_errors', 1);
// set the cookies
setcookie("4lawnave[iD]", "99");
setcookie("4lawnave[name]", "Bob Bruford");
setcookie("4lawnave[mobileNumber]", "0412 345 678");

// after the page reloads, print them out
if (isset($_COOKIE['4lawnave'])) {
    foreach ($_COOKIE['4lawnave'] as $name => $value) {
        $name = htmlspecialchars($name);
        $value = htmlspecialchars($value);
        echo "$name : $value <br />\n";
    }
}
?>