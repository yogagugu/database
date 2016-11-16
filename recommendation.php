<?php
	session_start();
	require_once "connection.php";	
	
if(isset($_SESSION['ClientID'])){
    $ClientID = $_SESSION['ClientID'];
}	
	if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['action'] == 'submitted'){
		$SearchBySQL = "SELECT *
					    FROM  Appetites_Request A,Restaurants_Own R left join Reviews_Have RH on R.RestaurantID=RH.RestaurantID
						WHERE RRating>= ARating and RCost<= ACost AND RFlavor=AFlavor AND A.ClientID='".$ClientID."'
						Order BY RFlavor";	
			
			$results = mysqli_query($conn,$SearchBySQL);
			
		if(!$results ){
		   die('There was an error running the query [' . $conn->error . ']');
		   echo "<br>";
		   echo "bad";
		}

		if ($results->num_rows > 0) {
			echo"<br>";
			echo "<table><tr><th>Restaurant name</th><th>Flavor</th><th>Cost</th><th>Rating</th><th>Review Rating</th><th>Description</th><th>ReviewDate</th></tr>";
            // output data of each row
			while( $row= $results->fetch_assoc()){
			
				echo"<tr><td>".$row["RName"]."</td><td>".$row["RFlavor"]."</td><td>".$row["RCost"]." </td><td> ".$row["RRating"]."</td><td> ".$row["RVRating"]."</td><td> ".$row["Description"]."</td><td> ".$row["ReviewDate"]." </td></tr>";
    			}
    		echo "</table>";

		} else {
   		 echo "0 results";	
		$conn->close();
	}

		}

?>

<!DOCTYPE HTML>
<html> 
  <?php include 'head/headclient.php';?>
 
  <head>
  <title>Recommendation</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
  </head>
	<style>
	.table table-bordered td
	{
		text-align: left;
	}
	#center td
	{
		text-align: center;
	}
	h2, h3 
	{
		text-align: center;
	}
	</style> 
    <body background="./images/background.jpg">	
		<div class="container">
		<div class="container">

			<form class="form-inline" method='post' action="<?php $_SERVER['PHP_SELF'];?>">
			
			</div><tr><td colspan='5'>
			<br><br>
			
			<input type="hidden" name="action" value="submitted">
			<input type='submit' name='search' value='Recommendation According to My Appetite' >
			<input type='button' name='cancel' value='Cancel' onclick="location.href='./clienthomepage.php'" />
			</form>
		</div>			
		</div>

</html>
