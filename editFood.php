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
    if ((isset($_GET['foodEditID'])) && (is_numeric($_GET['foodEditID']))) {
        $foodEditID = $_GET['foodEditID'];
    } else if (isset($_POST['foodEditID']) && (is_numeric($_POST['foodEditID']))) {
        $foodEditID = $_POST['foodEditID'];
    } else {
        echo '<p class="error">This Page has been accessed in error</p>';
        exit();
    }
    ?>

    <!-- get al the data for the food -->
    <?php
    // edit user query
    $editFoodQ = "SELECT * FROM `food` WHERE foodID = '$foodEditID'";

    // run the query
    $resultEditFoodQ = @mysqli_query($connect, $editFoodQ);

    if ($resultEditFoodQ) {
        $rowEditFood = mysqli_fetch_array($resultEditFoodQ, MYSQLI_ASSOC);
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
            $nFN = $rowEditFood['foodName'];
        } else {
            $nFN = mysqli_real_escape_string($connect, trim($_POST['newFoodName']));
        }

        // get menu AddOn Desc
        if (empty($_POST['newFoodDesc'])) {
            $error = 'You forgot to enter the food desc';
            $nFD = $rowEditFood['foodDesd'];
        } else {
            $nFD = mysqli_real_escape_string($connect, trim($_POST['newFoodDesc']));
        }

        // get menu AddOn Price
        if (empty($_POST['newFoodPrice'])) {
            $error = 'You forgot to enter the food price';
            $nFP = $rowEditFood['foodPrice'];
        } else {
            $nFP = mysqli_real_escape_string($connect, trim($_POST['newFoodPrice']));
        }

        // get menu AddOn Catgeory
        if (empty($_POST['newFoodCategory'])) {
            $error = 'You forgot to enter the  user phone no';
            $nFC = $rowEditFood['foodCategory'];
        } else {
            $nFC = mysqli_real_escape_string($connect, trim($_POST['newFoodCategory']));
        }

        // check for a newFoodAddOnCategory
        if (empty($_POST['newFoodAddOnCategory'])) {
            $error[] = 'You forgot to the newFoodAddOnCategory';
            $nFAC = $rowEditFood['foodAddOnCategory'];
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
        if (isset($_FILES['newFoodPicture']) && $_FILES['newFoodPicture']['error'] === UPLOAD_ERR_OK) {
            $imageName = $_FILES['newFoodPicture']['name'];
            if ($imageName == '') {
                $foodPicID = $rowEditFood['foodPictureID'];
                $imagePlusToken = $rowEditFood['foodToken'];
                echo "Not uploaded because of error #" . $_FILES["newFoodPicture"]["error"];
            } else {
                $imageContent = $_FILES['newFoodPicture']['tmp_name'];
                $imageType = $_FILES['newFoodPicture']['type'];
                $imageSize = $_FILES['newFoodPicture']['size'];
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
            $foodTokenizer = $rowEditFood['foodToken'];
            $foodPicID = $rowEditFood['foodPictureID'];
            $imagePlusToken = $rowEditFood['foodToken'];
        }

        // validate user choose edit or cancel
        if ($choose == 'Submit') {
            $foodQ = "UPDATE `food` SET `foodName`='$nFN',`foodDesc`='$nFD',`foodPrice`='$nFP',`foodCategory`='$nFC',`foodPictureID`='1',`foodToken`='$imagePlusToken',`foodAddOnCategory`='$nFAC' WHERE foodID = '$foodEditID'";

            $foodQrun = @mysqli_query($connect, $foodQ);

            if ($foodQrun) {
                echo '<script>
                        alert("The food has been editted to the database");
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
            alert("The food not edit from database");
            window.location.href ="addNewFood.php?userID=' . $row['userID'] . '";
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
                <h2>Edit Food</h2>
            </div>
            <form action="" method="POST" enctype="multipart/form-data" s>
                <div class="inputRestaurant">
                    <label for="newFoodName">Food Name</label>
                    <input type="text" id="newFoodName" name="newFoodName" placeholder="your restaurant name" required value="<?php echo $rowEditFood['foodName'] ?>" />
                </div>
                <div class="inputRestaurant">
                    <label for="newFoodDesc">Food Description</label>
                    <textarea id="newFoodDesc" name="newFoodDesc" placeholder="your restaurant desc" required></textarea>
                </div>
                <script>
                    document.getElementById("newFoodDesc").defaultValue = "<?php echo $rowEditFood['foodDesc']  ?>";
                </script>
                <div class="inputRestaurant">
                    <label for="newFoodPrice">Food Price</label>
                    <input id="newFoodPrice" name="newFoodPrice" placeholder="your restaurant Address" required value="<?php echo $rowEditFood['foodPrice'] ?>"></input>
                </div>
                <div class="inputRestaurant">
                    <label for="newFoodCategory">Food Category</label>
                    <input type="text" id="newFoodCategory" name="newFoodCategory" placeholder="your restaurant Phone No" required value="<?php echo $rowEditFood['foodCategory'] ?>" />
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
                <div class="inputMenu">
                    <label for="newMenuPicture">Food Picture</label>
                    <label class="btnPicture" for="newMenuPicture">Choose Picture</label>
                    <input type="file" id="newMenuPicture" name="newMenuPicture" style="display: none;" />
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