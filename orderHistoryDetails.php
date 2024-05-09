<html>

<head>
    <title>Makan-Lah | Details Order</title>
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
    // look for a  payment method, either through GET or POST
    if ((isset($_GET['chooseBank'])) && (is_numeric($_GET['orderID']))) {
        $chooseBank = $_GET['chooseBank'];
        $orderID = $_GET['orderID'];
    } else if (isset($_POST['chooseBank']) && (is_numeric($_GET['orderID']))) {
        $chooseBank = $_POST['chooseBank'];
        $orderID = $_GET['orderID'];
    } else {
        echo '<p class="error">This Page has been accessed in error</p>';
        exit();
    }
    ?>

    <!-- ORDER HISTORY DETAILS START -->
    <div class="wrapperAllOrderDetails">
        <div class="wrapOrderDetails">
            <div>
                <h3>ORDER DETAILS</h3>
            </div>
            <div class="orderDetailsCardWrap">
                <div class="orderDetailsCard">
                    <h3>Your Item</h3>
                    <?php
                    // get all current order data for the current user
                    $orderCurrentQ = "SELECT `orderHistoryID`, `orderID`, `userID`, `orderHistoryDate`, `orderHistoryTotalAmount`, `orderHistoryStatus`, `orderPaymentMethod` FROM `orderhistory` WHERE orderID = '$orderID'";
                    $runOrderCurrentQ = @mysqli_query($connect, $orderCurrentQ);
                    $resultRunOrderCurrenntQ = mysqli_fetch_array($runOrderCurrentQ, MYSQLI_ASSOC);

                    // set the orderID
                    $orderCurrentID = $resultRunOrderCurrenntQ['orderID'];

                    // get all data order item for the order
                    $orderItemQ = "SELECT `orderItemID`, `orderID`, `orderItemName`, `orderItemQuantity`, `orderItemPrice`, `orderItemAddOn`, `orderItemPicture` FROM `order_item` WHERE orderID = '$orderCurrentID'";
                    $runOrderItemQ = @mysqli_query($connect, $orderItemQ);

                    // while loop all order item data
                    while ($resultOrderItemQ = mysqli_fetch_array($runOrderItemQ, MYSQLI_ASSOC)) {

                        // get the menuaddon for each orderitem
                        $arrayMenuAddOnID = explode(',', $resultOrderItemQ['orderItemAddOn']);

                        // push each menuAddOn to array, make a new array for menuAddOn
                        $arrayMenuAddOnName = [];
                        foreach ($arrayMenuAddOnID as $menuAddOnID) {
                            if ($menuAddOnID != null) {

                                // query to get each menuaddon data
                                $menuaddOnQ = "SELECT `menuAddOnID`, `menuAddOnName`, `menuAddOnDesc`, `menuAddOnPrice`, `menuAddOnCategory`, `menuAddOnPictureID` FROM `menuaddon` WHERE menuAddOnID = '$menuAddOnID'";
                                $runMenuAddOnQ = @mysqli_query($connect, $menuaddOnQ);
                                $resulmenuAddOnName = mysqli_fetch_array($runMenuAddOnQ, MYSQLI_ASSOC);

                                // make seperator in array
                                $seperatorInArray = $resulmenuAddOnName['menuAddOnName'] . ',';
                                // push to array
                                array_push($arrayMenuAddOnName, $seperatorInArray);
                            }
                        }

                        // get all data menuAddOn for the order item
                        $menuAddOnQ = "SELECT `menuAddOnID`, `menuAddOnName`, `menuAddOnDesc`, `menuAddOnPrice`, `menuAddOnCategory`, `menuAddOnPictureID` FROM `menuaddon` WHERE menuAddOnID = '$menuAddOnID'";
                        $runMenuAddOnQ = @mysqli_query($connect, $menuAddOnQ);
                        $resultMenuAddOnQ = mysqli_fetch_array($runMenuAddOnQ, MYSQLI_ASSOC);


                        echo '<div class="orderItemHistory">
                        <h3>' . $resultOrderItemQ['orderItemQuantity'] . ' x ' . $resultOrderItemQ['orderItemName'] . '</h3>';

                        // looping the menuaddon array
                        if ($arrayMenuAddOnName != null) {
                            foreach ($arrayMenuAddOnName as $menuAddOn) {
                                echo '<p>' . $menuAddOn . '</p>';
                            }
                        } else {
                            echo '<p>no addOn</p>';
                        }

                        echo ' <p class="priceHistory">RM  ' . $resultOrderItemQ['orderItemPrice'] . '</p>
                         </div>';
                    }
                    ?>
                    <hr>
                </div>
                <div class="totalOrderHistory">
                    <h3>Total</h3>
                    <h3>RM <?php echo $resultRunOrderCurrenntQ['orderHistoryTotalAmount'] ?></h3>
                </div>
                <div class="paymentMethod">
                    <div>
                        <h3>Payment Method</h3>
                        <?php
                        if ($resultRunOrderCurrenntQ['orderPaymentMethod'] == 'cash') {
                            echo '<h3>Cash</h3>';
                        } else {
                            echo '<h3>Online Banking</h3>';
                        }
                        ?>
                    </div>
                    <div>
                        <h3>Bank</h3>
                        <?php
                        if ($resultRunOrderCurrenntQ['orderPaymentMethod'] == 'cash') {
                            echo '<h3>Cash</h3>';
                        } else {
                            echo '<h3>' . $resultRunOrderCurrenntQ['orderPaymentMethod'] . '</h3>';
                        }
                        ?>
                    </div>
                </div>
                <div class="print">
                    <button onclick="window.print()">Print this Order</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>