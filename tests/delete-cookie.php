<?php
// set the expiration date to one hour ago
setcookie("4lawnave[iD]", "", time() - 3600, "/");
setcookie("4lawnave[name]", "", time() - 3600, "/");
setcookie("4lawnave[mobileNumber]", "", time() - 3600, "/");
?>
<html>
<body>

<?php
echo "Cookies have been deleted.";
?>

</body>
</html>