<html>

<head>
    <title>Makan-Lah | Add MenuAddOn</title>
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

        // get menu AddOn Name
        if (empty($_POST['menuAddOnName'])) {
            $error = 'You forgot to enter the menu AddOn name';
        } else {
            $mAN = mysqli_real_escape_string($connect, trim($_POST['menuAddOnName']));
        }

        // get menu AddOn Desc
        if (empty($_POST['menuAddOnDesc'])) {
            $error = 'You forgot to enter the menu AddOn desc';
        } else {
            $mAD = mysqli_real_escape_string($connect, trim($_POST['menuAddOnDesc']));
        }

        // get menu AddOn Price
        if (empty($_POST['menuAddOnPrice'])) {
            $error = 'You forgot to enter the menu AddOn price';
        } else {
            $mAP = mysqli_real_escape_string($connect, trim($_POST['menuAddOnPrice']));
        }

        // get menu AddOn Catgeory
        if (empty($_POST['menuAddOnCategory'])) {
            $error = 'You forgot to enter the menu AddOn category';
        } else {
            $mAC = mysqli_real_escape_string($connect, trim($_POST['menuAddOnCategory']));
        }

        // query menu add on
        $q = "INSERT INTO `menuaddon`(`menuAddOnName`, `menuAddOnDesc`, `menuAddOnPrice`, `menuAddOnCategory`) VALUES ('$mAN','$mAD','$mAP','$mAC')";
        $resultMenuAddOn = @mysqli_query($connect, $q);

        if ($resultMenuAddOn) {
            echo '<script>
                    alert("Add new menu AddOn to the database");
                    window.location.href = "addMenuAddOn.php?userID=' . $row['userID'] . '";
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

    <!-- ADD MENU ADD ON START -->
    <div class="wrapperAllAddMenu">
        <div class="wrapperAddmenu">
            <div class="AddMenuTitle">
                <h2>Add Menu Add-On</h2>
            </div>

            <form action="addMenuAddOn.php?userID=<?php echo $row['userID'] ?>" method="POST" enctype="multipart/form-data">
                <div class="inputMenu">
                    <label for="menuAddOnName">Menu Add-On Name</label>
                    <input type="text" id="menuAddOnName" name="menuAddOnName" placeholder="your menu name" required value="<?php if (isset($_POST['menuAddOnName'])) echo $_POST['menuAddOnName']; ?>" />
                </div>
                <div class="inputMenu">
                    <label for="menuAddOnDesc">Menu Add-On Description</label>
                    <input type="text" id="menuAddOnDesc" name="menuAddOnDesc" placeholder="your menu desc" required value="<?php if (isset($_POST['menuAddOnDesc'])) echo $_POST['menuAddOnDesc']; ?>" />
                </div>
                <div class="inputMenu">
                    <label for="menuAddOnPrice">Menu Add-On Price</label>
                    <input type="text" id="menuAddOnPrice" name="menuAddOnPrice" placeholder="your menu price" required value="<?php if (isset($_POST['menuAddOnPrice'])) echo $_POST['menuAddOnPrice']; ?>" />
                </div>
                <div class="inputMenu">
                    <label for="menuAddOnCategory">Menu Add-On Category</label>
                    <select class="menuAddOnCategory" name="menuAddOnCategory" id="menuAddOnCategory" value="<?php if (isset($_POST['menuAddOnCategory'])) echo $_POST['menuAddOnCategory']; ?>">
                        <option value="water">Water</option>
                        <option value="meal">Meal</option>
                        <option value="sideDish">Side Dish</option>
                    </select>
                </div>
                <div class="btnSubmit">
                    <input type="submit" value="Add" class="submit" name="submit">
                    <input type="reset" value="Reset" class="reset">
                </div>
            </form>

        </div>
        <hr>
        <!-- display all menu available and show status -->
        <div class="availableManu">
            <div class="subTitleMenu">
                <h3>list all Menu Add-On</h3>
            </div>
            <div class="wrapperMenu">
                <?php
                // make query
                $q = 'SELECT * FROM `menuaddon`';

                // run the query
                $result = @mysqli_query($connect, $q);

                // display all food if have result
                if ($result) {
                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                        echo '<div class="menuCard">
                            <div class="detailMenu">
                                <div>
                                    <h3>' . $row['menuAddOnName'] . '</h3>
                                    <p>' . $row['menuAddOnDesc'] . '</p>
                                </div>
                                <div class="btnEditFood">
                                    <p>' . 'RM ' . $row['menuAddOnPrice'] . '</p>
                                    <div>
                                    <a href="editMenuAddOn.php?userID=' . $userID . '&menuAddOnEditID=' . $row['menuAddOnID'] . '">
                                        <button>Edit</button>
                                    </a>
                                    <a href="deleteAddOnMenu.php?userID=' . $userID . '&menuAddOnDeleteID=' . $row['menuAddOnID'] . '">
                                        <button>Delete</button>
                                    </a>
                                    </div>
                                </div>
                            </div>
                            <div class="menuPicture">
                            <div style="background-image: url(images/logo.png)">
                            </div>
                            </div>
                            </div>';
                    }
                }

                ?>

            </div>
        </div>
    </div>
    <!-- ADD NEW RESTURANT END -->
</body>

</html>