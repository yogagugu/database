<?php
	session_start();
	require_once "connection.php";	
	if (isset($_SESSION['ClientID'])) $ClientID = $_SESSION['ClientID'];
	

	if($_SERVER["REQUEST_METHOD"] == "POST"&& $_POST['action'] == 'submitted'){
		// Get Variable
		$RFlavor = $_POST['Flavor'];
		$RCost = $_POST['Cost'];
		$RRating = $_POST['Rating'];

		// Check if any criteria is set 
		If ((empty($RFlavor))&&(empty($RCost))&&(empty($RRating))){
			echo 'No Search Criteria is set.';
		}else{
			// Set SQL Statement
									
			$SearchByRRatingSQL = "SELECT *
								FROM  Restaurants_Own R left join Reviews_Have RH on R.RestaurantID=RH.RestaurantID
								WHERE RRating>= $RRating and RCost<= $RCost AND RFlavor='".$RFlavor."'
								ORDER BY RCost";	
			
			$results = mysqli_query($conn,$SearchByRRatingSQL);
			
			if(!$results ){
		    die('There was an error running the query [' . $conn->error . ']');
		    }

		if ($results->num_rows > 0) {
			echo"<br>";
			echo "<table><tr><th>Restaurant name</th><th>Flavor</th><th>Cost</th><th>Rating</th><th>Review Rating</th><th>Description</th><th>ReviewDate</th></tr>";
            // output data of each row
			while( $row= $results->fetch_assoc()){
				echo"<tr><td>".$row["RName"]."</td><td>".$row["RFlavor"]."</td><td>".$row["RCost"]." </td><td> ".$row["RRating"]."</td><td> ".$row["RVRating"]."</td><td> ".$row["Description"]."</td><td> ".$row["ReviewDate"]."</td></tr>";
    			}
    		echo "</table>";

		} else {
		 echo"<br>";
   		 echo "0 results";	
		$conn->close();
	}

		}
	}
?>

<!DOCTYPE HTML>
<html> 
  <?php include 'head/headclient.php';?>
 
  <head>
  <title>Search</title>
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
			<table class="table table-bordered" >
			<tr id="center"><td colspan='2'><h2>Search Criteria<h2></td></tr>
			<tr><td>
	        <label>Flavor  : </label></td><td><div class='radio'>
	   			<input type="radio" name="Flavor" value="Burgers" > Burgers
				<input type="radio" name="Flavor" value="Pizza" > Pizza
				<input type="radio" name="Flavor" value="Food with rice" > Food with rice
				<input type="radio" name="Flavor" value="Others" > Others					
	        </div></td></tr><tr><td colspan='4'>
	        </td></tr><tr><td>
  			<label>Cost: </label></td><td><input class="form-control" type="number" name="Cost"  min="0" max="200" step="1" >
	   		</td></tr><tr><td>
	  		 <label>Rating  : </label></td><td><div class='radio'>
	   			<input class="form-control" type="radio" name="Rating" value="5" > 5 
				<input class="form-control" type="radio" name="Rating" value="4" > 4
				<input class="form-control" type="radio" name="Rating" value="3" > 3
				<input class="form-control" type="radio" name="Rating" value="2" > 2
				<input class="form-control" type="radio" name="Rating" value="1" > 1						
	   		</td></tr>
			</div><tr><td colspan='5'>
			<br><br>
			
			<input type="hidden" name="action" value="submitted">
			<input type='submit' name='search' value='Search Restaurant' >
			<input type='button' name='cancel' value='Cancel' onclick="location.href='./clienthomepage.php'" />
			</form>
		</div>			
		</div>
		
</html>
