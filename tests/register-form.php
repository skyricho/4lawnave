<?php
ini_set('display_errors', 1);

if (isset($_COOKIE['4lawnave'])) {
	if ($_GET['action'] == "delete") {
		// set the expiration date to one hour ago
		setcookie("4lawnave[iD]", "", time() - 3600, "/");
		setcookie("4lawnave[name]", "", time() - 3600, "/");
		setcookie("4lawnave[mobileNumber]", "", time() - 3600, "/");
		echo "Cookies have been deleted.";
	} else {
	    foreach ($_COOKIE['4lawnave'] as $name => $value) {
	        $name = htmlspecialchars($name);
	        $value = htmlspecialchars($value);
	        echo "$name : $value <br />\n";
	    }
	    echo "<a href=\"register-form.php?action=delete\">Delete Cookies</a>";
    }
} else {
	// define variables and set to empty values
	$iD = $name1 = $mobileNumber = "";

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
	  $iD = rand(0,999);
	  setcookie("4lawnave[iD]", $iD, time() + (86400 * 365), "/"); // 86400 = 1 day
	  $name = test_input($_POST["name"]);
	  setcookie("4lawnave[name]", $name, time() + (86400 * 365), "/"); // 86400 = 1 day
	  $mobileNumber = test_input($_POST["mobileNumber"]);
	  setcookie("4lawnave[mobileNumber]", $mobileNumber, time() + (86400 * 365), "/"); // 86400 = 1 day
	  echo "ID: " . $iD . "<br>Name: " . $name . "<br>Mobile: " . $mobileNumber . "<br><a href=\"register-form.php?action=delete\">Delete Cookies</a>";
	  
	  /*foreach ($_COOKIE['4lawnave'] as $name => $value) {
	        $name = htmlspecialchars($name);
	        $value = htmlspecialchars($value);
	        echo "$name : $value <br />\n";
	  }
	  echo "<br><a href=\"register-form.php?action=delete\">Delete Cookies</a>";*/
	} else {
	    echo "
	<html>
		<body>
			<form action=\"register-form.php\" method=\"post\">
				Name: <input type=\"text\" name=\"name\"><br>
				Mobile: <input type=\"text\" name=\"mobileNumber\"><br>
				<input type=\"submit\">
			</form>
		</body>
	</html>";
	}
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

