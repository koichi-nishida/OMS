<?php
require_once("session.php");
require_once("included_functions_group8.php");
require_once("databasegroup8.php");

new_head("OMS");
new_admin("Sign Out");
if(empty($_SESSION['adusername'])){
	echo "You are not logged in";
	redirect("OMSadminlogin.php");
}


	$mysqli = Database::dbConnect();
	$mysqli -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	if (($output = message()) !== null) {
		echo $output;
	}

  $query = "SELECT adID, adUser, adFirst, adLast, adEmail FROM ADMIN ORDER BY adLast ASC;";

  $stmt = $mysqli -> query($query);
	$stmt -> execute();

  if ($stmt) {
		echo "<div class='row'>\n";
		echo "<center>\n";
		echo "<h2>Admins</h2>\n";
		echo "<table>\n";
		echo "  <thead>\n";
		echo "    <tr><th></th><th>User Name</th><th>First Name</th><th>Last Name</th><th>Email Address</th></tr>\n";
		echo "  </thead>\n";
		echo "  <tbody>\n";

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      echo "<tr>";
			echo "<td><a style='color:red;' href='OMSdeleteadmins.php?id=".urlencode($row['adID'])."' onclick='return confirm(\"Are you sure you want to delete?\");'>X</a></td>\n";
      echo "<td>".$row['adUser']."</td>\n";
			echo "<td>".$row['adFirst']."</td>\n";
			echo "<td>".$row['adLast']."</td>\n";
			echo "<td>".$row['adEmail']."</td>\n";
      echo "</tr>\n";
    }
    echo "  </tbody>\n";
    echo "</table>\n";

		echo "<a href='OMScreateadmins.php'> Add an Admin";
    echo "</center>\n";
		echo "</div>\n";
		echo "<br /><p>&laquo:<a href='OMSadminhome.php'>Back to Main Page</a>";
	}

  new_footer(" OMS ");
	Database::dbDisconnect($mysqli);

?>
