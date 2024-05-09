<html>

<head>
	<title>Makan-LaH</title>
</head>

<body>


	<!-- BACK END WEB APP -->
	<?php
	// include file connection.php
	include("connection.php");
	?>

	<?php
	//This section processes submission from the login page
	//Check if the form has been submitted
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		// validate the adminID
		if (!empty($_POST['userName'])) {

			$un = mysqli_real_escape_string($connect, $_POST['userName']);
		} else {

			$un = FALSE;
			echo '<p class="error"> You forgot to enter your user name </p>';
		}

		// validate the adminPassword
		if (!empty($_POST['userPassword'])) {

			$up = mysqli_real_escape_string($connect, $_POST['userPassword']);
		} else {

			$up = FALSE;
			echo '<p class="error"> You forgot to enter your password</p>';
		}

		// if no problems
		if ($un && $up) {
			// Retrieve the adminID, adminPassword, adminName, adminPassword, adminEmail
			$q = "SELECT userID, userName, userPassword, userEmail, userPhoneNo, userAddress, userCreated_at, isAdmin FROM user WHERE ( userName = '$un' AND userPassword = '$up')";

			// run the query and assign it to the variable $result
			$result = mysqli_query($connect, $q);

			// count the number of rows that match the adminID/adminPassword combination
			// if one database row (record) mathes the input
			if (@mysqli_num_rows($result) == 1) {
				// start the session, fetch the record and insert the three values in an array
				session_start();
				$_SESSION = mysqli_fetch_array($result, MYSQLI_ASSOC);

				// chec if user is admin or not
				echo '<script>
				window.location.href = "home.php?isAdmin=' . $_SESSION['isAdmin'] . '&userID=' . $_SESSION['userID'] . '";
				localStorage.setItem("name", "' . $_SESSION['userName'] . '");
				
				</script>';


				// Cancel the rest of the script
				exit();

				mysqli_free_result($result);
				mysqli_close($connect);
				// no match was made
			} else {
				echo '<p class="error"> The adminID and adminPassword entered do not match our records <br> perhaps you need to register, just click the register button</p>';
			}

			// if there was a problems
		} else {
			echo '<p class="error"> Please try again.</p>';
		}
		mysqli_close($connect);
		// end of submit conditional
	}
	?>

	<style>
		<?php
		include("style.css");
		?>
	</style>
	<!-- FRONT END WEB DESIGN -->
	<div class="wrapperAllLogin">
		<div class="wrapp">
			<div class="wrapTitle">
				<h1>Welcome to Makan-LaH!</h1>
				<p>
					where every login opens the door to a delightful dining experience.
				</p>
			</div>
			<div class="wrapperLogin">
				<div class="loginBox">
					<div class="loginTitle">
						<h2>Login</h2>
					</div>
					<form class="wrapInputUser" action="login.php" method="POST">
						<div class="inputUser">
							<label for="userName">Username</label>
							<input type="text" id="userName" name="userName" placeholder="your username" required value="<?php if (isset($_POST['userName'])) echo $_POST['userName']; ?>" />
						</div>
						<div class="inputUser">
							<label for="userPassword">Password</label>
							<input type="password" id="userPassword" name="userPassword" placeholder="your password" required value="<?php if (isset($_POST['userPassword'])) echo $_POST['userPassword']; ?>" />
						</div>
						<div class="loginButton">
							<input type="submit" value="login" />
						</div>
						<div class="newUser">
							<p>
								New to Makan-LaH ?
								<a class="linktoRegister" href="register.php">register now!</a>
							</p>
							<p>
								<a class="linktoRegister" href="https://drive.google.com/file/d/19d8GiuwQ_Kux0ARdVVqqFoeusHgXByr5/view?usp=sharing" target="_blank">User Manual!</a>
							</p>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>

</html>