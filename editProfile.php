<html>

<head>
    <title>
        Makan-Lah | Edit Profile
    </title>
</head>

<body>
    <!-- call connection.php file to connect to server -->
    <?php
    include("connection.php");
    ?>

    <!-- call css file -->
    <style>
        <?php
        include("style.css");
        ?>
    </style>

    <!-- call header file -->
    <?php
    include("header.php");
    ?>

    <?php
    // get all data for current user
    $userQuery = "SELECT `userID`, `userName`, `userPassword`, `userEmail`, `userPhoneNo`, `userAddress`, `userCreated_at`, `isAdmin` FROM `user` WHERE userID = '$userID'";
    $runUserQuery = @mysqli_query($connect, $userQuery);
    $resultUserQuery = mysqli_fetch_array($runUserQuery, MYSQLI_ASSOC);
    ?>

    <?php
    if (isset($_POST['submit'])) {

        $error = [];

        // get user choose
        if (empty($_POST['submit'])) {
            $error = 'choose delete or cancel';
        } else {
            $choose = mysqli_real_escape_string($connect, trim($_POST['submit']));
        }

        // get user name
        if (empty($_POST['username'])) {
            $error = 'You forgot to enter the usernames';
            $nU = $resultUserQuery['userName'];
        } else {
            $nU = mysqli_real_escape_string($connect, trim($_POST['username']));
        }

        // get user password
        if (empty($_POST['userpassword'])) {
            $error = 'You forgot to enter the userpassword';
            $nUP = $resultUserQuery['userPassword'];
        } else {
            $nUP = mysqli_real_escape_string($connect, trim($_POST['userpassword']));
        }

        // get user email
        if (empty($_POST['useremail'])) {
            $error = 'You forgot to enter the user email';
            $nUE = $resultUserQuery['userEmail'];
        } else {
            $nUE = mysqli_real_escape_string($connect, trim($_POST['useremail']));
        }

        // get user phone no
        if (empty($_POST['userphoneno'])) {
            $error = 'You forgot to enter the user phone no';
            $nUPH = $resultUserQuery['userPhoneNo'];
        } else {
            $nUPH = mysqli_real_escape_string($connect, trim($_POST['userphoneno']));
        }

        // get user address
        if (empty($_POST['useraddress'])) {
            $error = 'You forgot to enter the user phone no';
            $nUA = $resultUserQuery['userAddress'];
        } else {
            $nUA = mysqli_real_escape_string($connect, trim($_POST['useraddress']));
        }

        if ($choose == 'Submit') {
            // query to update in user table
            $updateUserQ = "UPDATE `user` SET `userName`='$nU',`userPassword`='$nUP',`userEmail`='$nUE',`userPhoneNo`='$nUPH',`userAddress`='$nUA' WHERE userID = '$userID'";
            $runUpdateUserQ = @mysqli_query($connect, $updateUserQ);


            if ($runUpdateUserQ) {
                echo '<script>
                    alert("The User Profile has been edited");
                    window.location.href ="profile.php?userID=' . $row['userID'] . '";
                    </script>';
                exit();
            } else {
                // if it didn't run
                // message 
                echo '<h1>System error</h1>';

                // debugging message
                echo '<p>' . mysqli_error($connect) . '<br><br>Query : ' . $q . '</p>';
            } // end of it (result)

        } else {
            echo '<script>
            alert("The profile not edit from database");
            window.location.href ="profile.php?userID=' . $row['userID'] . '";
            </script>';
        }

        mysqli_close($connect); //close the database connection_aborted
        exit();
        // end of the main submit conditional
    }

    ?>



    <!-- EDIT RESTURANT START -->
    <div class="wrapperAllAddRestaurant">
        <div class="wrapperAddRestaurant">
            <div class="Addtitle">
                <h2>Edit Profile</h2>
            </div>
            <form action="editProfile.php?userID=<?php echo $row['userID'] ?>" method="POST" enctype="multipart/form-data" s>
                <div class="inputRestaurant">
                    <label for="username">User Name</label>
                    <input type="text" id="username" name="username" placeholder="your new username" required value="<?php echo $resultUserQuery['userName'] ?>" />
                </div>

                <div class="inputRestaurant">
                    <label for="userpassword">User Password</label>
                    <input id="userpassword" name="userpassword" placeholder="your new user password" value="<?php echo $resultUserQuery['userPassword'] ?>"></input>
                </div>
                <div class="inputRestaurant">
                    <label for="useremail">User Email</label>
                    <input id="useremail" name="useremail" placeholder="your new user email" value="<?php echo $resultUserQuery['userEmail'] ?>"></input>
                </div>
                <div class="inputRestaurant">
                    <label for="userphoneno">User Phone No</label>
                    <input type="text" id="userphoneno" name="userphoneno" placeholder="your new user phone no" value="<?php echo $resultUserQuery['userPhoneNo'] ?>" />
                </div>
                <div class="inputRestaurant">
                    <label for="useraddress">User Address</label>
                    <textarea id="useraddress" name="useraddress" placeholder="your new user address"></textarea>
                </div>
                <script>
                    document.getElementById("useraddress").defaultValue = "<?php echo $resultUserQuery['userAddress']  ?>";
                </script>
                <div class="btnSubmit">
                    <input type="submit" value="Submit" name="submit" class="submit">
                    <input type="submit" value="Cancel" name="submit" class="cancel">
                    <input type="reset" value="Reset" class="reset">
                </div>
            </form>
        </div>
    </div>
    <!-- EDIT RESTURANT END -->


</body>

</html>