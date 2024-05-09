<html>

<head>
    <title>Makan-Lah | Add Restaurant</title>
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
    if ((isset($_GET['menuAddOnEditID'])) && (is_numeric($_GET['menuAddOnEditID']))) {
        $menuAddOnEditID = $_GET['menuAddOnEditID'];
    } else if (isset($_POST['menuAddOnEditID']) && (is_numeric($_POST['menuAddOnEditID']))) {
        $menuAddOnEditID = $_POST['menuAddOnEditID'];
    } else {
        echo '<p class="error">This Page has been accessed in error</p>';
        exit();
    }
    ?>

    <?php
    if (isset($_POST['submit'])) {

        $error = [];

        // get user name
        if (empty($_POST['submit'])) {
            $error = 'choose delete or cancel';
        } else {
            $choose = mysqli_real_escape_string($connect, trim($_POST['submit']));
        }

        // get user name
        if (empty($_POST['newFoodName'])) {
            $error = 'You forgot to enter the food name';
        } else {
            $nAOM = mysqli_real_escape_string($connect, trim($_POST['newFoodName']));
        }

        // get menu AddOn Desc
        if (empty($_POST['newFoodDesc'])) {
            $error = 'You forgot to enter the food desc';
        } else {
            $nAOD = mysqli_real_escape_string($connect, trim($_POST['newFoodDesc']));
        }

        // get menu AddOn Price
        if (empty($_POST['newFoodPrice'])) {
            $error = 'You forgot to enter the food price';
        } else {
            $nAOP = mysqli_real_escape_string($connect, trim($_POST['newFoodPrice']));
        }

        // get menu AddOn Catgeory
        if (empty($_POST['newFoodCategory'])) {
            $error = 'You forgot to enter the  user phone no';
        } else {
            $nAOC = mysqli_real_escape_string($connect, trim($_POST['newFoodCategory']));
        }

        // check for a newFoodAddOnCategory
        if (empty($_POST['newFoodAddOnCategory'])) {
            $error[] = 'You forgot to the newFoodAddOnCategory';
            $nFAC = FALSE;
        } else {
            $arrayChoices = $_POST['newFoodAddOnCategory'];
            $arrayChoiceFinal = [];

            foreach ($arrayChoices as $choice) {
                $tempChoice = $choice . ',';
                array_push($arrayChoiceFinal, $tempChoice);
            }

            $nFAC = implode($arrayChoiceFinal);
        }

        // validate user choose edit or cancel
        if ($choose == 'Submit') {
            $foodQ = "UPDATE `menuaddon` SET `menuAddOnName`='$nAOM',`menuAddOnDesc`='$nAOD',`menuAddOnPrice`='$nAOP',`menuAddOnCategory`='nAOC' WHERE menuAddOnID = '$menuAddOnEditID'";

            $foodQrun = @mysqli_query($connect, $foodQ);

            if ($foodQrun) {
                echo '<script>
                        alert("The food has been editted to the database");
                        window.location.href ="addMenuAddOn.php?userID=' . $row['userID'] . '";
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
            alert("The Menu AddOn not edit from database");
            window.location.href ="addMenuAddOn.php?userID=' . $row['userID'] . '";
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
                <h2>Edit Menu Add On</h2>
            </div>
            <form action="editMenuAddOn.php?userID=<?php echo $row['userID'] ?>&menuAddOnEditID=<?php echo $menuAddOnEditID ?>" method="POST" enctype="multipart/form-data" s>
                <?php
                // edit user query
                $editMenuAddOnQ = "SELECT * FROM `menuaddon` WHERE menuAddOnID = '$menuAddOnEditID'";

                // run the query
                $resultEditMenuAddOnQ = @mysqli_query($connect, $editMenuAddOnQ);

                if ($resultEditMenuAddOnQ) {
                    $rowEditMenuAddOn = mysqli_fetch_array($resultEditMenuAddOnQ, MYSQLI_ASSOC);
                }
                ?>
                <div class="inputRestaurant">
                    <label for="newFoodName">Food Name</label>
                    <input type="text" id="newFoodName" name="newFoodName" placeholder="your restaurant name" required value="<?php echo $rowEditMenuAddOn['menuAddOnName'] ?>" />
                </div>
                <div class="inputRestaurant">
                    <label for="newFoodDesc">Food Description</label>
                    <textarea id="newFoodDesc" name="newFoodDesc" placeholder="your restaurant desc" required></textarea>
                </div>
                <script>
                    document.getElementById("newFoodDesc").defaultValue = "<?php echo $rowEditMenuAddOn['menuAddOnDesc']  ?>";
                </script>
                <div class="inputRestaurant">
                    <label for="newFoodPrice">Food Price</label>
                    <input id="newFoodPrice" name="newFoodPrice" placeholder="your menu add on prices" required value="<?php echo $rowEditMenuAddOn['menuAddOnPrice'] ?>"></input>
                </div>
                <div class="inputRestaurant">
                    <label for="newFoodCategory">Food Category</label>
                    <input type="text" id="newFoodCategory" name="newFoodCategory" placeholder="your restaurant Phone No" required value="<?php echo $rowEditMenuAddOn['menuAddOnCategory'] ?>" />
                </div>
                <div class="inputRestaurant">
                    <label for="newFoodAddOnCategory">Food Add-On Category</label>
                    <div>
                        <input type="checkbox" class="inputCheckBox" id="newFoodAddOnCategory" name="newFoodAddOnCategory[]" value="water" />
                        <label for="newFoodAddOnCategory">Water</label>
                    </div>
                    <div>
                        <input type="checkbox" class="inputCheckBox" id="newFoodAddOnCategory" name="newFoodAddOnCategory[]" value="meal" />
                        <label for="newFoodAddOnCategory">Meal</label>
                    </div>
                    <div>
                        <input type="checkbox" class="inputCheckBox" id="newFoodAddOnCategory" name="newFoodAddOnCategory[]" value="sideDish" />
                        <label for="newFoodAddOnCategory">SideDish</label>
                    </div>
                </div>
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