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

    <!-- to save data new food to database -->
    <?php
    if (isset($_POST['submit'])) {

        $error = array(); //initialize an error array

        // check for a newMenuName
        if (empty($_POST['newMenuName'])) {
            $error[] = 'You forgot to enter your newMenuName.';
        } else {
            $nM = mysqli_real_escape_string($connect, trim($_POST['newMenuName']));
        }

        // check for a newMenuDesc
        if (empty($_POST['newMenuDesc'])) {
            $error[] = 'You forgot to enter your newMenuDesc.';
        } else {
            $nMD = mysqli_real_escape_string($connect, trim($_POST['newMenuDesc']));
        }

        // check for a newMenuPrice
        if (empty($_POST['newMenuPrice'])) {
            $error[] = 'You forgot to the newMenuPrice';
        } else {
            $nMP = mysqli_real_escape_string($connect, trim($_POST['newMenuPrice']));
        }

        // check for a newMenuCategory
        if (empty($_POST['newMenuCategory'])) {
            $error[] = 'You forgot to the newMenuCategory';
        } else {
            $nMC = mysqli_real_escape_string($connect, trim($_POST['newMenuCategory']));
        }

        // check for a newFoodAddOnCategory
        if (empty($_POST['newFoodAddOnCategory'])) {
            $error[] = 'You forgot to the newFoodAddOnCategory';
        } else {
            $arrayChoices = $_POST['newFoodAddOnCategory'];
            $arrayChoiceFinal = [];

            foreach ($arrayChoices as $choice) {
                $tempChoice = $choice . ',';
                array_push($arrayChoiceFinal, $tempChoice);
            }

            $nFAC = implode($arrayChoiceFinal);
        }

        // for picture
        if (isset($_FILES['newMenuPicture']) && $_FILES['newMenuPicture']['error'] === UPLOAD_ERR_OK) {
            $imageName = $_FILES['newMenuPicture']['name'];
            if ($imageName == '') {
                $foodPicID = $rowEditFood['foodPictureID'];
                $imagePlusToken = $rowEditFood['foodToken'];
                echo "Not uploaded because of error #" . $_FILES["newMenuPicture"]["error"];
            } else {
                $imageContent = $_FILES['newMenuPicture']['tmp_name'];
                $imageType = $_FILES['newMenuPicture']['type'];
                $imageSize = $_FILES['newMenuPicture']['size'];
                $foodTokenizer = base64_encode(random_bytes(30));
                $divideImageName = explode('.', $imageName);
                $imagePlusToken = $divideImageName[0] . '-' . $foodTokenizer . '.' . $divideImageName[1];

                // upload to file directory
                $uploads_dir = 'imagesUpload/';
                if (is_uploaded_file($imageContent)) {
                    //in case you want to move  the file in uploads directorys

                    if (move_uploaded_file($imageContent, $uploads_dir . $imagePlusToken)) {
                    } else {
                        $foodPicID = $rowEditFood['foodPictureID'];
                        $imagePlusToken = $rowEditFood['foodToken'];
                    }
                }
            }
        } else {
            echo "Not uploaded because of error #" . $_FILES["newMenuPicture"]["error"];
            $foodTokenizer = $rowEditFood['foodToken'];
            $foodPicID = $rowEditFood['foodPictureID'];
            $imagePlusToken = $rowEditFood['foodToken'];
        }


        $q = "INSERT INTO food (foodName, foodDesc, foodPrice, foodCategory, foodToken, foodAddOnCategory) VALUES ('$nM','$nMD','$nMP','$nMC','$imagePlusToken','$nFAC')";

        $result = @mysqli_query($connect, $q); // run the query

        if ($result) {
            echo '<script>
                    alert("Add new item to the database");
                    // window.location.href = "addNewFood.php?userID=' . $row['userID'] . '";
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

    <!-- ADD NEW RESTURANT START -->
    <div class="wrapperAllAddMenu">
        <div class="wrapperAddmenu">
            <div class="AddMenuTitle">
                <h2>Add New Menu</h2>
            </div>

            <form action="" method="POST" enctype="multipart/form-data">
                <div class="inputMenu">
                    <label for="newMenuName">Food Name</label>
                    <input type="text" id="newMenuName" name="newMenuName" placeholder="your menu name" required value="<?php if (isset($_POST['newMenuName'])) echo $_POST['newMenuName']; ?>" />
                </div>
                <div class="inputMenu">
                    <label for="newMenuDesc">Food Description</label>
                    <input type="text" id="newMenuDesc" name="newMenuDesc" placeholder="your menu desc" required value="<?php if (isset($_POST['newMenuDesc'])) echo $_POST['newMenuDesc']; ?>" />
                </div>
                <div class="inputMenu">
                    <label for="newMenuPrice">Food Price</label>
                    <input type="text" id="newMenuPrice" name="newMenuPrice" placeholder="your menu price" required value="<?php if (isset($_POST['newMenuPrice'])) echo $_POST['newMenuPrice']; ?>" />
                </div>
                <div class="inputMenu">
                    <label for="newMenuCategory">Food Category</label>
                    <input type="text" id="newMenuCategory" name="newMenuCategory" placeholder="your menu price" required value="<?php if (isset($_POST['newMenuCategory'])) echo $_POST['newMenuCategory']; ?>" />
                </div>
                <div class="inputMenu">
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
                <div class="inputMenu">
                    <label for="newMenuPicture">Food Picture</label>
                    <label class="btnPicture" for="newMenuPicture">Choose Picture</label>
                    <input type="file" id="newMenuPicture" name="newMenuPicture" style="display: none;" />
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
                <h3>list all Menu</h3>
            </div>
            <div class="wrapperMenu">
                <?php
                // make query
                $q = 'SELECT * FROM `food`';

                // run the query
                $result = @mysqli_query($connect, $q);

                // display all food if have result
                if ($result) {
                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

                        echo '<div class="menuCard">
                            <div class="detailMenu">
                                <div>
                                    <h3>' . $row['foodName'] . '</h3>
                                    <p>' . $row['foodDesc'] . '</p>
                                </div>
                                <div class="btnEditFood">
                                    <p>RM ' . $row['foodPrice'] . '</p>
                                    <div>
                                    <a href="editFood.php?userID=' . $userID . '&foodEditID=' . $row['foodID'] . '">
                                        <button>Edit</button>
                                    </a>
                                    <a href="deleteFood.php?userID=' . $userID . '&foodDeleteID=' . $row['foodID'] . '">
                                        <button>Delete</button>
                                    </a>
                                    </div>
                                </div>
                            </div>
                            <div class="menuPicture">
                            <div style="background-image: url(imagesUpload/' . $row['foodToken'] . ')">
                            </div>
                            </div>
                            </div>';

                        // Change the content type according to your image type (e.g., image/png for PNG images)






                    }
                } else {
                    echo '<div class="menuCard">
                    <div class="detailMenu">
                        <div>
                            <h3>' . $row['foodName'] . '</h3>
                            <p>' . $row['foodDesc'] . '</p>
                        </div>
                        <div class="btnEditFood">
                            <p>' . $row['foodPrice'] . '</p>
                            <div>
                            <a href="editFood.php?userID=' . $userID . '&foodEditID=' . $row['foodID'] . '">
                                <button>Edit</button>
                            </a>
                            <a href="deleteFood.php?userID=' . $userID . '&foodDeleteID=' . $row['foodID'] . '">
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
                ?>

            </div>
        </div>
    </div>
    <!-- ADD NEW RESTURANT END -->
</body>

</html>