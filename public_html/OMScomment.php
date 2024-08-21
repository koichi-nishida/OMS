<?php

require_once("session.php");
require_once("included_functions_group8.php");
require_once("databasegroup8.php");


new_head("OMS");
new_admin("Sign Out");
$mysqli = Database::dbConnect();
$mysqli -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (($output = message()) !== null) {
  echo $output;
}

if(empty($_SESSION['username'])){
	echo "You are not logged in";
	redirect("OMSlogin.php");
}

echo "<h3>Rate an Opportunity</h3>";
echo "<div class='row'>";
echo "<label for='left-label' class='left inline'>";

  if (isset($_POST["submit"])) {
        if((!empty($_POST['rating'])) && (!(trim($_POST['rating']) == "")) ){
            $query4 = "UPDATE RATING SET rating = ?, comment = ? WHERE jobID = ? and acID = ?;";
            $stmt4 = $mysqli->prepare($query4);
            $stmt4-> execute([$_POST['rating'], $_POST['comment'], $_SESSION['job'], $_SESSION['userID']]);

          if($stmt4) {
            $_SESSION['message'] = "Your review has been added";
            redirect("OMSreadjob_users.php");
          }else{
            $_SESSION["message"] = "Error!! Could not post a review";
            redirect("OMSreadjob_users.php");
          }
          redirect("OMSreadjob_users.php");
        }
        else{
          $_SESSION["message"] = "Error!! Rate the opportunity!!";
          redirect("OMSreadjob_users.php");
        }

}else {

   if ((isset($_SESSION["job"]) && $_SESSION["job"] !== "") &&(isset($_SESSION["userID"])&& $_SESSION["userID"] !== "")) {
    $query = "SELECT rating, comment
    FROM RATING WHERE jobID = ? and acID = ?;";
    $stmt = $mysqli->prepare($query);
    $stmt-> execute([$_SESSION['job'], $_SESSION['user']]);


  if ($stmt)  {
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      echo "<form action='OMScomment.php' method='POST'>\n";

      echo "<p>Rate: <input type=number name='rating' value = '".$row['rating']."' min=1 max= 5></p>\n";
      echo "<p>Comment: <input type=text name='comment' value = '".$row['comment']."'></p>\n";
      echo "<input type='submit' name='submit' value='Post'/>\n";

    }
    else {
      $_SESSION["message"] = "Company could not be found!";
      redirect("OMSreadjob_users.php");
    }
  }
}

echo "</label>\n";
echo "</div>\n";
echo "<br /><p>&laquo:<a href='OMSreadjob_users.php'>Back to Main Page</a>\n";

new_footer(" OMS ");
Database::dbDisconnect($mysqli);

?>
