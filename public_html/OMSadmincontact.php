<?php
require_once("session.php");
require_once("included_functions_group8.php");
require_once("databasegroup8.php");

new_header("OMS");
new_logout("Sign out");

if(empty($_SESSION['username'])){
	echo "You are not logged in";
	redirect("OMSlogin.php");
}


	$mysqli = Database::dbConnect();
	$mysqli -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	if (($output = message()) !== null) {
		echo $output;
	}

  $query = "SELECT adID, adFirst, adLast, adEmail FROM ADMIN ORDER BY adLast ASC;";

  $stmt = $mysqli -> query($query);
	$stmt -> execute();

  if ($stmt) {
		echo "<div class='row'>\n";
		echo "<center>\n";
		echo "<h2>OMS Admins</h2>\n";
		echo "<table>\n";
		echo "  <thead>\n";
		echo "    <tr><th>First Name</th><th>Last Name</th><th>Email Address</th></tr>\n";
		echo "  </thead>\n";
		echo "  <tbody>\n";

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      echo "<tr>\n";
			echo "<td>".$row['adFirst']."</td>\n";
			echo "<td>".$row['adLast']."</td>\n";
			echo "<td>".$row['adEmail']."</td>\n";
      echo "</tr>";
    }
    echo "  </tbody>\n";
    echo "</table>\n";
    echo "</center>\n";
		echo "</div>\n";
		echo "<br /><p>&laquo:<a href='OMSuserhome.php'>Back to Main Page</a>\n";
	}

  new_footer(" OMS ");
	Database::dbDisconnect($mysqli);

?>
