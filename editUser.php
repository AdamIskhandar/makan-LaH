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

    <?php
    // look for a valid user id, either through GET or POST
    if ((isset($_GET['userEditID'])) && (is_numeric($_GET['userEditID']))) {
        $userEditID = $_GET['userEditID'];
    } else if (isset($_POST['userEditID']) && (is_numeric($_POST['userEditID']))) {
        $userEditID = $_POST['userEditID'];
    } else {
        echo '<p class="error">This Page has been accessed in error</p>';
        exit();
    }
    ?>

    <!-- INSERT MENU ADD ON TO DATABASE -->
    <?php
    if (isset($_POST['submit'])) {

        $error = [];

        // get user name
        if (empty($_POST['newUserName'])) {
            $error = 'You forgot to enter the user name';
        } else {
            $aUN = mysqli_real_escape_string($connect, trim($_POST['newUserName']));
        }

        // get menu AddOn Desc
        if (empty($_POST['newUserPassword'])) {
            $error = 'You forgot to enter the user password';
        } else {
            $aUP = mysqli_real_escape_string($connect, trim($_POST['newUserPassword']));
        }

        // get menu AddOn Price
        if (empty($_POST['newUserEmail'])) {
            $error = 'You forgot to enter the user email';
        } else {
            $aUE = mysqli_real_escape_string($connect, trim($_POST['newUserEmail']));
        }

        // get menu AddOn Catgeory
        if (empty($_POST['newUserPhoneNo'])) {
            $error = 'You forgot to enter the  user phone no';
        } else {
            $aUPH = mysqli_real_escape_string($connect, trim($_POST['newUserPhoneNo']));
        }

        // get menu AddOn Catgeory
        if (empty($_POST['newUserAddress'])) {
            $error = 'You forgot to enter the user address';
        } else {
            $aUA = mysqli_real_escape_string($connect, trim($_POST['newUserAddress']));
        }

        // get menu AddOn Catgeory
        if (empty($_POST['isAdmin'])) {
            $error = 'You forgot to enter the isAdmin';
        } else {
            $iA = mysqli_real_escape_string($connect, trim($_POST['isAdmin']));
        }

        // edit user query
        $userQ = "UPDATE `user` SET `userName`='$aUN',`userPassword`='$aUP',`userEmail`='$aUE',`userPhoneNo`='$aUPH',`userAddress`='$aUA',`userCreated_at`='',`isAdmin`='$iA' WHERE userID = '$userEditID'";

        // run edit user query
        $userQResult = @mysqli_query($connect, $userQ);

        if ($userQResult) {
            echo '<script>
                    alert("The user has been editted to the database");
                    window.location.href ="addUser.php?userID=' . $row['userID'] . '";
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
                <h2>Edit User</h2>
            </div>
            <form action="editUser.php?userID=<?php echo $row['userID'] ?>&userEditID=<?php echo $userEditID ?>" method="post">
                <?php
                // edit user query
                $editUserQ = "SELECT * FROM `user` WHERE userID = '$userEditID'";

                // run the query
                $resultEditUserQ = @mysqli_query($connect, $editUserQ);

                if ($resultEditUserQ) {
                    $rowEditUser = mysqli_fetch_array($resultEditUserQ, MYSQLI_ASSOC);
                }
                ?>
                <div class="inputAddUser">
                    <label for="newUserName">User Name</label>
                    <input type="text" id="newUserName" name="newUserName" placeholder="user name" required value="<?php echo $rowEditUser['userName'] ?>" />
                </div>
                <div class="inputAddUser">
                    <label for="newUserPassword">User Password</label>
                    <input type="text" id="newUserPassword" name="newUserPassword" placeholder="user password" required value="<?php echo $rowEditUser['userPassword'] ?>" />
                </div>
                <div class="inputAddUser">
                    <label for="newUserEmail">User Email</label>
                    <input type="text" id="newUserEmail" name="newUserEmail" placeholder="user email" required value="<?php echo $rowEditUser['userEmail'] ?>" />
                </div>
                <div class="inputAddUser">
                    <label for="newUserPhoneNo">User Phone No</label>
                    <input type="text" id="newUserPhoneNo" name="newUserPhoneNo" placeholder="user phone no" required value="<?php echo $rowEditUser['userPhoneNo'] ?>" />
                </div>
                <div class="inputAddUser">
                    <label for="newUserAddress">User Address</label>
                    <textarea id="newUserAddress" name="newUserAddress" placeholder="user address" required></textarea>
                </div>
                <script>
                    document.getElementById("newUserAddress").defaultValue = "<?php echo $rowEditUser['userAddress']  ?>";
                </script>
                <div class="inputAddUser">
                    <label for="isAdmin">is Admin?</label>
                    <?php
                    if ($rowEditUser['isAdmin'] = 'yes') {
                        echo '
                        <div>
                        <input type="checkbox" class="inputCheckBox" id="isAdmin" name="isAdmin" value="yes" checked/>
                        <label for="isAdmin">Yes</label>
                        </div>
                        <div>
                        <input type="checkbox" class="inputCheckBox" id="isAdmin" name="isAdmin" value="no" />
                        <label for="isAdmin">No</label>
                    </div>
                        ';
                    } else {
                        echo '
                        <div>
                        <input type="checkbox" class="inputCheckBox" id="isAdmin" name="isAdmin" value="yes" />
                        <label for="isAdmin">Yes</label>
                        </div>
                        <div>
                        <input type="checkbox" class="inputCheckBox" id="isAdmin" name="isAdmin" value="no" checked/>
                        <label for="isAdmin">No</label>
                    </div>
                        ';
                    }

                    ?>

                </div>
                <div class="btnSubmit">
                    <input type="submit" value="Add" class="submit" name="submit">
                    <input type="reset" value="Reset" class="reset">
                </div>
            </form>
        </div>
    </div>
    <!-- ADD USER END -->
</body>

</html>