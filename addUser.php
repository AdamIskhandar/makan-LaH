<html>

<head>
    <title>
        Makan-LaH | Add New User
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

    <!-- INSERT MENU ADD ON TO DATABASE -->
    <?php
    if (isset($_POST['submit'])) {

        $error = [];

        // get user name
        if (empty($_POST['addUserName'])) {
            $error = 'You forgot to enter the user name';
        } else {
            $aUN = mysqli_real_escape_string($connect, trim($_POST['addUserName']));
        }

        // get menu AddOn Desc
        if (empty($_POST['addUserPassword'])) {
            $error = 'You forgot to enter the user password';
        } else {
            $aUP = mysqli_real_escape_string($connect, trim($_POST['addUserPassword']));
        }

        // get menu AddOn Price
        if (empty($_POST['addUserEmail'])) {
            $error = 'You forgot to enter the user email';
        } else {
            $aUE = mysqli_real_escape_string($connect, trim($_POST['addUserEmail']));
        }

        // get menu AddOn Catgeory
        if (empty($_POST['addUserPhoneNo'])) {
            $error = 'You forgot to enter the  user phone no';
        } else {
            $aUP = mysqli_real_escape_string($connect, trim($_POST['addUserPhoneNo']));
        }

        // get menu AddOn Catgeory
        if (empty($_POST['addUserAddress'])) {
            $error = 'You forgot to enter the user address';
        } else {
            $aUA = mysqli_real_escape_string($connect, trim($_POST['addUserAddress']));
        }

        // get menu AddOn Catgeory
        if (empty($_POST['isAdmin'])) {
            $error = 'You forgot to enter the isAdmin';
        } else {
            $iA = mysqli_real_escape_string($connect, trim($_POST['isAdmin']));
        }

        $userQ = "INSERT INTO `user`(`userName`, `userPassword`, `userEmail`, `userPhoneNo`, `userAddress`, `userCreated_at`, `isAdmin`) VALUES ('$aUN','$aUP','$aUE','$aUP','$aUA',current_timestamp(), '$iA')";

        $userQResult = @mysqli_query($connect, $userQ);

        if ($userQResult) {
            echo '<script>
                    alert("Add new item to the database");
                    window.location.href = "addUser.php?userID=' . $row['userID'] . '";
                    </script>';
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

    <!-- ADD USER START -->
    <div class="wrapperAllAddUser">
        <div class="wrapperAddUser">
            <div class="subTitleAddUser">
                <h2>Add User</h2>
            </div>
            <form action="addUser.php?userID=<?php echo $row['userID'] ?>" method="post">
                <div class="inputAddUser">
                    <label for="addUserName">User Name</label>
                    <input type="text" id="addUserName" name="addUserName" placeholder="user name" required value="<?php if (isset($_POST['addUserName'])) echo $_POST['addUserName']; ?>" />
                </div>
                <div class="inputAddUser">
                    <label for="addUserPassword">User Password</label>
                    <input type="text" id="addUserPassword" name="addUserPassword" placeholder="user password" required value="<?php if (isset($_POST['addUserPassword'])) echo $_POST['addUserPassword']; ?>" />
                </div>
                <div class="inputAddUser">
                    <label for="addUserEmail">User Email</label>
                    <input type="text" id="addUserEmail" name="addUserEmail" placeholder="user email" required value="<?php if (isset($_POST['addUserEmail'])) echo $_POST['addUserEmail']; ?>" />
                </div>
                <div class="inputAddUser">
                    <label for="addUserPhoneNo">User Phone No</label>
                    <input type="text" id="addUserPhoneNo" name="addUserPhoneNo" placeholder="user phone no" required value="<?php if (isset($_POST['addUserPhoneNo'])) echo $_POST['addUserPhoneNo']; ?>" />
                </div>
                <div class="inputAddUser">
                    <label for="addUserAddress">User Address</label>
                    <textarea id="addUserAddress" name="addUserAddress" placeholder="user address" required value="<?php if (isset($_POST['addUserAddress'])) echo $_POST['addUserAddress']; ?>"></textarea>
                </div>
                <div class="inputAddUser">
                    <label for="isAdmin">is Admin?</label>
                    <div>
                        <input type="checkbox" class="inputCheckBox" id="isAdmin" name="isAdmin" value="yes" />
                        <label for="isAdmin">Yes</label>
                    </div>
                    <div>
                        <input type="checkbox" class="inputCheckBox" id="isAdmin" name="isAdmin" value="no" />
                        <label for="isAdmin">No</label>
                    </div>
                </div>
                <div class="btnSubmit">
                    <input type="submit" value="Add" class="submit" name="submit">
                    <input type="reset" value="Reset" class="reset">
                </div>
            </form>
        </div>
        <div>
            <?php
            include('userList.php');
            ?>
        </div>
    </div>
    <!-- ADD USER END -->
</body>

</html>