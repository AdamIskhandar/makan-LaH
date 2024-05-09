<html>

<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Makan LaH</title>
	<!-- <link rel="stylesheet" href="style.css" /> -->
	<script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>

<body>

	<?php
	// call file connection.php to connect to server
	include("connection.php");
	?>

	<style>
		<?php include 'style.css'; ?>
	</style>

	<?php
	// look for a valid user id, either through GET or POST
	if ((isset($_GET['userID'])) && (is_numeric($_GET['userID']))) {
		$userID = $_GET['userID'];
		// echo '<p>ada user ' . $userID . ' </p>';
	} else if (isset($_POST['userID']) && (is_numeric($_POST['userID']))) {
		$userID = $_POST['userID'];
	} else {
		echo '<p class="error">This Page has been accessed in error</p>';
		exit();
	}


	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
		$error = array(); //initialize an error array

		if (empty($error)) {
			$q = "SELECT userID, userName, userPassword, userEmail, userPhoneNo, userAddress, userCreated_at, isAdmin FROM user WHERE ( userID = '$userID')";

			//run the query
			$result = @mysqli_query($connect, $q);

			// if one database row (record) mathes the input
			if (@mysqli_num_rows($result) == 1) {
				// start the session, fetch the record and insert the three values in an array
				$_SESSION = mysqli_fetch_array($result, MYSQLI_ASSOC);

				include('header.php');
			}
		} else {
			echo "ada errorrrr";
		}
	}
	?>

	<!-- CONTENT -->
	<div class="wrapperContent">
		<div class="content">
			<!-- search bar -->
			<div class="wrapperSearchBar">
				<div class="textContent">
					<h1>Hungry? Let Makan-LaH handle it.</h1>
				</div>
				<form class="searchBar" action="allFood.php?userID=<?php echo $userID; ?>" method="POST">
					<label for="searchBar" class="searchLabel">Search Your Food</label>
					<input type="text" class="searchBarInput" name="searchBar" id="searchBar" placeholder="Your Favourite Food" value="<?php if (isset($_POST['searchBar'])) echo $_POST['searchBar']; ?>" />

					<div class="wrapperbtnSearch">
						<button type="submit">Find Food</button>
					</div>
				</form>
			</div>

			<!-- image  -->
			<div class="imageContent">
				<img src="images/menuPoster-removebg-preview.png" alt="imageContent" />
			</div>
		</div>
	</div>
	<!-- CONTENT END -->


	<!-- FOOD START -->
	<div class="foodContainer">
		<div class="food">
			<h1>Choose your favourite food at Makan-Lah</h1>
		</div>
		<div class="foodCardContainer">

			<?php
			// make the query
			$query = 'SELECT * FROM food ORDER BY foodID';

			// run the query and assign it to the variable $result
			$result = @mysqli_query($connect, $query);

			if ($result) {
				while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
					echo '<div class="foodCard">
							<a href="orderFood.php?foodID=' . $row['foodID'] . '&userID=' . $userID . '">
							<div class="imageFood" style="background-image: url(imagesUpload/' .  $row['foodToken'] . ');"></div>
								<div class="title">
									<div>
										' . $row['foodName'] . '
										<div class="description">' . $row['foodDesc'] . '</div>
									</div>
									<div class="foodPrice">' . 'RM ' . $row['foodPrice'] . '</div>
								</div>
							</a>
							</div>';
				}
			} else {
				echo '<div class="foodCard">
				<a href="orderFood.php?foodID=' . $row['foodID'] . '&userID=' . $userID . '">
					<img src="images/logo.png" alt="nasi ayam" />
					<div class="title">
						<div>
							' . $row['foodName'] . '
							<div class="description">' . $row['foodDesc'] . '</div>
						</div>
						<div class="foodPrice">' . $row['foodPrice'] . '</div>
					</div>
				</a>
				</div>';
			}
			?>

		</div>
	</div>
	<!-- FOOD END -->


</body>

</html>