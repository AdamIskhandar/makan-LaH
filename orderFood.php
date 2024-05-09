<html>

<head>
    <title>RESTAURANT DETAILS</title>
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

    <!-- 1) terima data foodID dari home -->
    <?php
    // look for a valid food id, either through GET or POST
    if ((isset($_GET['foodID'])) && (is_numeric($_GET['foodID']))) {
        $foodID = $_GET['foodID'];
    } else if (isset($_POST['foodID']) && (is_numeric($_POST['foodID']))) {
        $foodID = $_POST['foodID'];
    } else {
        echo '<p class="error">This Page has been accessed in error</p>';
        exit();
    }

    // make the query for food
    $query = "SELECT foodID, foodName, foodDesc, foodPrice, foodCategory, foodPictureID, foodToken, foodAddOnCategory FROM food WHERE ( foodID = '$foodID')";

    // run the query and assign it to the variable $result
    $result = @mysqli_query($connect, $query);
    $rowFood = mysqli_fetch_array($result, MYSQLI_ASSOC)

    ?>




    <!-- to save data new food to database -->
    <?php
    if (isset($_POST['submit'])) {

        $error = array(); //initialize an error array
        $currentMenuAddOnID = array();

        // amik data menuAddon sebelum proceed buat orders
        // kalau takde menuAddOn order still boleh create

        // tukar interface menuAddOn from card tu checkBox
        // check for a waterAddOn
        if (empty($_POST['waterAddOn'])) {
            $error[] = 'You forgot to the waterAddOn';
        } else {
            $arrayChoices = $_POST['waterAddOn'];
            $arrayChoiceFinal = [];

            foreach ($arrayChoices as $choice) {
                $tempChoice = $choice . ',';
                array_push($arrayChoiceFinal, $tempChoice);
                array_push($currentMenuAddOnID, $choice);
            }

            $wAO = implode($arrayChoiceFinal);
        }

        // check for a mealAddOn
        if (empty($_POST['mealAddOn'])) {
            $error[] = 'You forgot to the mealAddOn';
        } else {
            $arrayChoices = $_POST['mealAddOn'];
            $arrayChoiceFinal = [];

            foreach ($arrayChoices as $choice) {
                $tempChoice = $choice . ',';
                array_push($arrayChoiceFinal, $tempChoice);
                array_push($currentMenuAddOnID, $choice);
            }

            $mAO = implode($arrayChoiceFinal);
        }

        // check for a sideDishAddOn
        if (empty($_POST['sideDishAddOn'])) {
            $error[] = 'You forgot to the sideDishAddOn';
        } else {
            $arrayChoices = $_POST['sideDishAddOn'];
            $arrayChoiceFinal = [];

            foreach ($arrayChoices as $choice) {
                $tempChoice = $choice . ',';
                array_push($arrayChoiceFinal, $tempChoice);
                array_push($currentMenuAddOnID, $choice);
            }

            $sAO = implode($arrayChoiceFinal);
        }

        // check for a newMenuName
        if (empty($_POST['quantityFood'])) {
            $error[] = 'You forgot to enter your quantityFood.';
            echo 'takde quantity';
        } else {
            $qF = mysqli_real_escape_string($connect, trim($_POST['quantityFood']));
        }

        // ------------------------------------------------------------


        // get details for food that user choose
        $currentFoodQ = "SELECT `foodID`, `foodName`, `foodDesc`, `foodPrice`, `foodCategory`, `foodPictureID`, `foodToken`, `foodAddOnCategory` FROM `food` WHERE foodID = '$foodID'";
        $runCurrentFoodQ = @mysqli_query($connect, $currentFoodQ);
        $currentFoodRow = mysqli_fetch_array($runCurrentFoodQ, MYSQLI_ASSOC);

        // set the value for each food attributee
        $currentFoodName = $currentFoodRow['foodName'];
        $currentFoodPrice = $currentFoodRow['foodPrice'] * $qF;

        // get Details for the menuAddOn
        foreach ($currentMenuAddOnID as $menuID) {
            $currentMenuAddOnQ = "SELECT `menuAddOnID`, `menuAddOnName`, `menuAddOnDesc`, `menuAddOnPrice`, `menuAddOnCategory`, `menuAddOnPictureID` FROM `menuaddon` WHERE menuAddOnID = '$menuID'";

            $runCurrentMenuAddOnQ = @mysqli_query($connect, $currentMenuAddOnQ);

            // get the price for each menuaddon and plus with current total food price
            $rowCurrentMenuAddOnQ = mysqli_fetch_array($runCurrentMenuAddOnQ, MYSQLI_ASSOC);

            $totalmenuAddOnperQuantity = $rowCurrentMenuAddOnQ['menuAddOnPrice'] * $qF;
            // plus the currentFoodPrice
            $currentFoodPrice += $totalmenuAddOnperQuantity;
        }

        // check if user dah ada order pending atau tak
        // amik order current customer
        $currentOrderQ = "SELECT `orderID`, `userID`, `orderDate`, `orderTotalAmount`, `orderStatus` FROM `orders` WHERE userID = '$userID'";

        // run the query for current customer
        $runCurrentOrderQ = @mysqli_query($connect, $currentOrderQ);

        $row = mysqli_fetch_array($runCurrentOrderQ, MYSQLI_ASSOC);


        if ($row) {
            $orderCurrentID = $row['orderID'];
            $arrayChoices = $currentMenuAddOnID;
            $arrayChoiceFinal = [];

            foreach ($arrayChoices as $choice) {
                $tempChoice = $choice . ',';
                array_push($arrayChoiceFinal, $tempChoice);
            }

            $nAMenuAddOn = implode($arrayChoiceFinal);
            // jika ada order, tambah menuAddOn
            // set picture for each order Item
            $orderItemPicture = $rowFood['foodToken'];
            // tambah food dalam order item
            $orderItemQ = "INSERT INTO `order_item`(`orderID`, `orderItemName`, `orderItemQuantity`, `orderItemPrice`, `orderItemAddOn`, `orderItemPicture`) VALUES ('$orderCurrentID','$currentFoodName','$qF','$currentFoodPrice','$nAMenuAddOn', '$orderItemPicture')";

            $runOrderItemQ = @mysqli_query($connect, $orderItemQ);

            if ($runOrderItemQ) {
                echo ' <script>
                alert("add menu to current orders");
                 </script>';
            }
        } else {
            // jika takder current orders
            // create orders
            // new order quuery
            $arrayChoices = $currentMenuAddOnID;
            $arrayChoiceFinal = [];

            foreach ($arrayChoices as $choice) {
                $tempChoice = $choice . ',';
                array_push($arrayChoiceFinal, $tempChoice);
            }

            $nAMenuAddOn = implode($arrayChoiceFinal);


            $orderQ = "INSERT INTO `orders`(`userID`, `orderDate`, `orderTotalAmount`, `orderStatus`) VALUES ('$userID',current_timestamp(),'0','pending')";

            // run the query
            $runOrderQ = @mysqli_query($connect, $orderQ);

            if ($runOrderQ) {

                // check if user dah ada order pending atau tak
                // amik order current customer
                $currentOrderQ = "SELECT `orderID`, `userID`, `orderDate`, `orderTotalAmount`, `orderStatus` FROM `orders` WHERE userID = '$userID'";

                // run the query for current user
                $runCurrentOrderQ = @mysqli_query($connect, $currentOrderQ);

                $rowOrderCurrent = mysqli_fetch_array($runCurrentOrderQ, MYSQLI_ASSOC);

                // add current food
                $orderCurrentID = $rowOrderCurrent['orderID'];

                // set picture for each order item
                $orderItemPicture = $rowFood['foodToken'];
                // tambah food dalam order item
                $orderItemQ = "INSERT INTO `order_item`(`orderID`, `orderItemName`, `orderItemQuantity`, `orderItemPrice`, `orderItemAddOn`, `orderItemPicture`) VALUES ('$orderCurrentID','$currentFoodName','$qF','$currentFoodPrice','$nAMenuAddOn','$orderItemPicture')";

                $runOrderItemQ = @mysqli_query($connect, $orderItemQ);

                if ($runOrderItemQ) {
                    echo ' <script>
                    alert("add menu to currentn orders");
                    </script>';
                }
            }
        }

        // update orderTotalAmount
        // update to orderTotalAmount attribute
        $updateOrderItemQ = "SELECT `orderItemID`, `orderID`, `orderItemName`, `orderItemQuantity`, `orderItemPrice`, `orderItemAddOn`, `orderItemPicture` FROM `order_item` WHERE orderID = '$orderCurrentID'";

        $runUpdateOrderItemQ = @mysqli_query($connect, $updateOrderItemQ);;

        if ($runUpdateOrderItemQ) {

            $currentTotalAmount = 0;

            while ($rowUpdateOrderItemQ = mysqli_fetch_array($runUpdateOrderItemQ, MYSQLI_ASSOC)) {

                $orderItemPrice = $rowUpdateOrderItemQ['orderItemPrice'];

                $currentTotalAmount += $orderItemPrice;
            }

            $updateOrderTotalQ = "UPDATE `orders` SET `orderTotalAmount`='$currentTotalAmount' WHERE orderID = $orderCurrentID";

            $runUpdateOrderTotalQ = @mysqli_query($connect, $updateOrderTotalQ);
        } else {
            echo "ROSAKK ANJAY";
        }

        if ($runUpdateOrderTotalQ) {
            echo '<script>
            alert("dah update order total amount");
            window.location.href = "home.php?userID=' . $userID . '";
            </script>';
        }

        mysqli_close($connect); //close the database connection_aborted
        exit();
    }
    ?>


    <!-- RESTAURANT DETAILS CODE START -->
    <div class="wrapperAllRestaurant">
        <div class="wrapRestaurant">
            <div class="foodImage">
                <div style="background-image: url('imagesUpload/<?php echo $rowFood['foodToken']; ?>');"></div>
            </div>
            <div>
                <div class="restaurantName">
                    <?php
                    echo '<h1>' . $rowFood['foodName'] . '</h1>';
                    ?>
                </div>
                <div clas="deliveryAndTime">
                    <?php
                    echo '<h3>' . 'RM ' .  $rowFood['foodPrice'] . '</h3>';
                    ?>
                </div>
            </div>
        </div>
        <hr>

        <!-- menu add on -->
        <?php
        $divideCategory = explode(',', $rowFood['foodAddOnCategory']);

        echo '<form action="orderFood.php?foodID=' . $foodID . '&userID=' . $userID . '" method="post">';
        // addon water
        if (in_array('water', $divideCategory)) {

            echo '
                <div class="availableManu">
                <div class="subTitleMenu">
                <h3>Add-On Water?</h3>
                <div class="inputMenuAddOn">';

            $waterQ = "SELECT * FROM `menuaddon` WHERE menuAddOnCategory = 'water'";

            $resultWaterQ = @mysqli_query($connect, $waterQ);

            if ($resultWaterQ) {
                while ($row = mysqli_fetch_array($resultWaterQ, MYSQLI_ASSOC)) {
                    echo '    
                    <div>
                        <div class="rowMenuAddOn">
                            <input type="checkbox" class="inputCheckBox" id="newFoodAddOnCategory" name="waterAddOn[]" value="' . $row['menuAddOnID'] . '" />
                            <label for="newFoodAddOnCategory">' . $row['menuAddOnName'] . '</label>
                        </div>
                        <div class="priceAddOn">
                            <p>+ RM ' . $row['menuAddOnPrice'] . '</p>
                        </div>
                    </div>';
                }
            }

            echo '        
                </div>
                </div>
                </div>';
        }

        // addon Meal
        if (in_array('meal', $divideCategory)) {

            echo '
                <div class="availableManu">
                <div class="subTitleMenu">
                <h3>Add-On Meal?</h3>
                <div class="inputMenuAddOn">';

            $mealQ = "SELECT * FROM `menuaddon` WHERE menuAddOnCategory = 'meal'";

            $resultMealQ = @mysqli_query($connect, $mealQ);

            if ($resultMealQ) {
                while ($row = mysqli_fetch_array($resultMealQ, MYSQLI_ASSOC)) {
                    echo '    
                    <div>
                        <div class="rowMenuAddOn">
                            <input type="checkbox" class="inputCheckBox" id="newFoodAddOnCategory" name="mealAddOn[]" value="' . $row['menuAddOnID'] . '" />
                            <label for="newFoodAddOnCategory">' . $row['menuAddOnName'] . '</label>
                        </div>
                        <div class="priceAddOn">
                            <p>+ RM ' . $row['menuAddOnPrice'] . '</p>
                        </div>
                    </div>';
                }
            }

            echo '        
                </div>
                </div>
                </div>';
        }

        // addon Side Dish
        if (in_array('sideDish', $divideCategory)) {

            echo '
                <div class="availableManu">
                <div class="subTitleMenu">
                <h3>Add-On SideDish?</h3>
                <div class="inputMenuAddOn">';

            $sideDishQ = "SELECT * FROM `menuaddon` WHERE menuAddOnCategory = 'sideDish'";

            $resultSideDishQ = @mysqli_query($connect, $sideDishQ);

            if ($resultSideDishQ) {
                while ($row = mysqli_fetch_array($resultSideDishQ, MYSQLI_ASSOC)) {
                    echo '    
                    <div>
                        <div class="rowMenuAddOn">
                            <input type="checkbox" class="inputCheckBox" id="newFoodAddOnCategory" name="sideDishAddOn[]" value="' . $row['menuAddOnID'] . '" />
                            <label for="newFoodAddOnCategory">' . $row['menuAddOnName'] . '</label>
                        </div>
                        <div class="priceAddOn">
                            <p>+ RM ' . $row['menuAddOnPrice'] . '</p>
                        </div>
                    </div>';
                }
            }

            echo '        
                </div>
                </div>
                </div>';
        }
        ?>


        <div class="addToCartFood">
            <div class="wrapQuantity">
                <button type="button" name="minus" id="minus">-</button>
                <input type="text" name="quantityFood" id="quantityFood" value="1">
                <button type="button" name="plus" id="plus">+</button>
            </div>
            <input type="submit" name="submit" value="Add to Cart | <?php echo $rowFood['foodName'] ?>">
        </div>
        </form>
        <!-- RESTAURANT DETAILS CODE END -->
        <script src="./addQuantity.js"></script>
</body>

</html>