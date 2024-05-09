<html>

<head>
	<title>Makan-LaH</title>
</head>

<body>


	<!-- BACK END -->
	<?php
	// include file connection.php
	include("connection.php");
	?>

	<?php
	// This query insert a record in the eLeave table
	// has form been submitted?
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		$error = array(); //initialize an error array

		// check for a userName
		if (empty($_POST['username'])) {
			$error[] = 'You forgot to enter your name.';
		} else {
			$n = mysqli_real_escape_string($connect, trim($_POST['username']));
		}

		// check for a userEmail
		if (empty($_POST['email'])) {
			$error[] = 'You forgot to enter your email.';
		} else {
			$e = mysqli_real_escape_string($connect, trim($_POST['email']));
		}

		// check for a userPassword
		if (empty($_POST['password'])) {
			$error[] = 'You forgot to the password';
		} else {
			$p = mysqli_real_escape_string($connect, trim($_POST['password']));
		}

		// check for a userPhone number
		if (empty($_POST['phoneNo'])) {
			$error[] = 'You forgot to the phone number';
		} else {
			$ph = mysqli_real_escape_string($connect, trim($_POST['phoneNo']));
		}

		// check for a userAddress
		if (empty($_POST['address'])) {
			$error[] = 'You forgot to the address';
		} else {
			$ad = mysqli_real_escape_string($connect, trim($_POST['address']));
		}


		// register the admin in the database
		// make the query
		$q = "INSERT INTO user (userID, userName, userPassword, userEmail, userPhoneNo, userAddress, userCreated_at, isAdmin) VALUES ('', '$n', '$p', '$e', '$ph', '$ad', current_timestamp(), 'no')";

		$result = @mysqli_query($connect, $q); // run the query

		if ($result) {
			echo '<script>
			alert("Thank you for register!");
			window.location.href = "login.php";
			</script>;';
			exit();
		} else {
			// if it didn't run
			// message 
			echo '<h1>System error</h1>';

			// debugging message
			echo '<p>' . mysqli_error($connect) . '<br><br>Query : ' . $q . '</p>';
		} // end of it (result)

		mysqli_close($connect); //close the database connection_aborted
		exit();
		// end of the main submit conditional  
	}

	?>

	<style>
		<?php
		include("style.css");
		?>
	</style>

	<!-- FRONT END -->
	<div class="wrapperAll">
		<div class="wrappRegister">
			<div class="wrapTitle">
				<h1>Welcome to Makan-LaH!</h1>
				<p>
					where every login opens the door to a delightful dining experience.
				</p>
			</div>
			<div class="wrapperLogin">
				<div class="loginBox">
					<div class="loginTitle">
						<h2>Sign up</h2>
					</div>
					<form class="wrapInputUser" action="register.php" method="POST">
						<div class="inputUser">
							<label for="username">Username</label>
							<input type="text" id="username" name="username" placeholder="your username" required value="<?php if (isset($_POST['username'])) echo $_POST['username']; ?>" />
						</div>
						<div class="inputUser">
							<label for="email">Email</label>
							<input type="email" id="email" name="email" placeholder="your email" required value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" />
						</div>
						<div class="inputUser">
							<label for="phoneNo">Phone No</label>
							<input type="tel" id="phoneNo" name="phoneNo" placeholder="your phone number" required value="<?php if (isset($_POST['phoneNo'])) echo $_POST['phoneNo']; ?>" />
						</div>
						<div class="inputUser">
							<label for="address">Address</label>
							<input type="text" id="address" name="address" placeholder="your Address" required value="<?php if (isset($_POST['address'])) echo $_POST['address']; ?>" />
						</div>
						<div class="inputUser">
							<label for="password">Password</label>
							<input type="password" id="password" name="password" placeholder="your password" required value="<?php if (isset($_POST['password'])) echo $_POST['password']; ?>" />
						</div>
						<div class="loginButton">
							<input type="submit" value="sign up" />
						</div>
						<div class="newUser">
							<p>
								Have an Account ?
								<a class="linktoRegister" href="login.php">Login Here!</a>
							</p>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>

</html>