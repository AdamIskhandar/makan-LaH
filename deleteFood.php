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
    if ((isset($_GET['foodDeleteID'])) && (is_numeric($_GET['foodDeleteID']))) {
        $foodDeleteID = $_GET['foodDeleteID'];
    } else if (isset($_POST['foodDeleteID']) && (is_numeric($_POST['foodDeleteID']))) {
        $foodDeleteID = $_POST['foodDeleteID'];
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
            $userDeleteQuery = "DELETE FROM `food` WHERE foodID = '$foodDeleteID'";

            // run the query
            $resultUserDeleteQuery = @mysqli_query($connect, $userDeleteQuery);

            if ($resultUserDeleteQuery) {
                echo '<script>
                        alert("The food has been deleted from database");
                        window.location.href ="addNewFood.php?userID=' . $row['userID'] . '";
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
            alert("The food not delete from database");
            window.location.href ="addNewFood.php?userID=' . $row['userID'] . '";
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
                <h2>Delete Food</h2>
            </div>
            <?php

            $foodQuery = "SELECT * FROM food WHERE foodID = $foodDeleteID";

            // run the userQuery
            $resultFoodQuery = @mysqli_query($connect, $foodQuery);
            if ($resultFoodQuery) {
                $rowDeleteFood = mysqli_fetch_array($resultFoodQuery, MYSQLI_ASSOC);
            }

            ?>
            <form action="deleteFood.php?userID=<?php echo $row['userID'] ?>&foodDeleteID=<?php echo $foodDeleteID ?>" method="POST">
                <div class="userDeleteName">
                    <h3>Are you sure to delete this food? : <?php echo $rowDeleteFood['foodName'] ?></h3>
                    <input type="hidden" name="deleteID" value="<?php echo $rowDeleteFood['foodID'] ?>">
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