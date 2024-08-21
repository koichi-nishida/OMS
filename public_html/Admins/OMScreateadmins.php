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


if (isset($_POST["submit"])) {


	if((isset($_POST["aduser"]) && $_POST["aduser"] !== "") && (isset($_POST["adpwd"]) && $_POST["adpwd"] !== "") && (isset($_POST["adpwd1"]) && $_POST["adpwd1"] !== "")
  &&(isset($_POST["adfirst"]) && $_POST["adfirst"] !== "")&&(isset($_POST["adlast"]) && $_POST["adlast"] !== "")
&&(isset($_POST["ademail"]) && $_POST["ademail"] !== "")){

		if($_POST['adpwd'] == $_POST['adpwd1']){
				$aduser = $_POST["aduser"];
				$adpwd = $_POST["adpwd"];
		    $adfirst = $_POST["adfirst"];
		    $adlast = $_POST["adlast"];
				$ademail = $_POST["ademail"];
				$passwordEncrypt = password_encrypt($adpwd);

				$query = "SELECT * FROM ADMIN WHERE adUser = ?";
				$stmt = $mysqli->prepare($query);
				$stmt-> execute([$_POST['aduser']]);


			if ($rowNum = $stmt -> rowCount() >= 1) {
				$_SESSION['message'] = "The admin username already exists";
				redirect("OMScreateadmins.php");

			}else{
				$query1 = "INSERT INTO ADMIN (adUser, adHash, adFirst, adLast, adEmail) VALUES (?, ?, ?, ?, ?)";
				$stmt1 = $mysqli->prepare($query1);
				$stmt1-> execute([$aduser, $passwordEncrypt, $adfirst, $adlast, $ademail]);

				if($stmt1){
					$_SESSION['message'] = "User successfully added";
				}
				else{
					$_SESSION['message'] = "Could not add an admin!";
				}
				redirect("OMSread_adminprofile.php");
		}

	}else{
		$_SESSION['message'] = "Password does not match";
		redirect("OMScreateadmins.php");
	}
	$_SESSION['message'] = "Could not add an admin!";
	redirect("OMScreateadmins.php");
}
	$_SESSION['message'] = "Fill in all information";
	redirect("OMScreateadmins.php");


}
else{
?>

		<div class='row'>
		<label for='left-label' class='left inline'>

		<h3>Add an Admin</h3>
		<form action="OMScreateadmins.php" method="post">
		 <p>Username:<input type="text" name="aduser" value="" /> </p>
		 <p>Password: <input type="password" name="adpwd" value="" /> </p>
		 <p>Confirm Password: <input type="password" name="adpwd1" value="" /> </p>
     <p>First Name:<input type="text" name="adfirst" value="" /> </p>
     <p>Last Name:<input type="text" name="adlast" value="" /> </p>
		 <p>Email Address:<input type="email" name="ademail" value="" /> </p>
		 <input type="submit" name="submit" value="Add" />
		</form>

  	  <?php
}
			echo "<br /><p>&laquo:<a href='OMSread_adminprofile.php'>Back to Main Page</a>"; ?>

	</div>
	</label>

<?php
new_footer(" OMS ");
Database::dbDisconnect($mysqli);


?>
