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
    if ((isset($_GET['userDeleteID'])) && (is_numeric($_GET['userDeleteID']))) {
        $userDeleteID = $_GET['userDeleteID'];
    } else if (isset($_POST['userDeleteID']) && (is_numeric($_POST['userDeleteID']))) {
        $userDeleteID = $_POST['userDeleteID'];
    } else {
        echo '<p class="error">This Page has been accessed in error</p>';
        exit();
    }
    ?>

    <!-- INSERT MENU ADD ON TO DATABASE -->
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $error = [];

        // get user name
        if (empty($_POST['isDelete'])) {
            $error = 'choose delete or cancel';
        } else {
            $iD = mysqli_real_escape_string($connect, trim($_POST['isDelete']));
        }

        // get menu AddOn Desc
        if (empty($_POST['deleteID'])) {
            $error = 'no delete id';
        } else {
            $iDID = mysqli_real_escape_string($connect, trim($_POST['deleteID']));
        }

        if ($iD == 'delete') {

            // user delete query
            $userDeleteQuery = "DELETE FROM `user` WHERE userID = '$iDID'";

            // run the query
            $resultUserDeleteQuery = @mysqli_query($connect, $userDeleteQuery);

            if ($resultUserDeleteQuery) {
                echo '<script>
                        alert("The user has been delete from database");
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
        } else {
            echo '<script>
            alert("The user not delete from database");
            window.location.href ="addUser.php?userID=' . $row['userID'] . '";
            </script>';
        }

        mysqli_close($connect); //close the database connection_aborted
        exit();
        // end of the main submit conditional

    }

    ?>

    <!-- ADD USER START -->
    <div class="wrapperAllAddUser">
        <div class="wrapperAddUser">
            <div class="subTitleAddUser">
                <h2>Delete User</h2>
            </div>
            <?php

            $userQuery = "SELECT * FROM user WHERE userID = $userDeleteID";

            // run the userQuery
            $resultUserQuery = @mysqli_query($connect, $userQuery);
            if ($resultUserQuery) {
                $rowDeleteUser = mysqli_fetch_array($resultUserQuery, MYSQLI_ASSOC);
            }

            ?>
            <form action="deleteUser.php?userID=<?php echo $row['userID'] ?>&userDeleteID=<?php echo $userDeleteID ?>" method="POST">
                <div class="userDeleteName">
                    <h3>Are you sure to delete this user? : <?php echo $rowDeleteUser['userName'] ?></h3>
                    <input type="hidden" name="deleteID" value="<?php echo $rowDeleteUser['userID'] ?>">
                </div>
                <div class="btnSubmit">
                    <input type="submit" name="isDelete" value="delete">
                    <input type="submit" name="isDelete" value="cancel">
                </div>
            </form>
        </div>
    </div>
    <!-- ADD USER END -->
</body>

</html>