<html>

<head>
    <title>Makan-LaH</title>
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

    <!-- ADD TO CART START -->
    <div class="wrapperAllAddToCart">
        <div class="wrapperAddToCart">
            <h3>Your Orders</h3>
            <div class="wrapAddToCart">

                <?php
                // amik order current customer
                $currentOrderQ = "SELECT `orderID`, `userID`, `orderDate`, `orderTotalAmount`, `orderStatus` FROM `orders` WHERE userID = '$userID'";

                // run the query for current customer
                $runCurrentOrderQ = @mysqli_query($connect, $currentOrderQ);

                $rowOrder = mysqli_fetch_array($runCurrentOrderQ, MYSQLI_ASSOC);

                $haveOrder = '';
                // check if customer ada order atau tak
                if (!$rowOrder) {
                    $haveOrder = FALSE;
                } else {
                    $haveOrder = TRUE;
                    $orderCurrentID = $rowOrder['orderID'];
                }

                if ($haveOrder) {
                    // get all order item for the orderID
                    $orderItemQ = "SELECT `orderItemID`, `orderID`, `orderItemName`, `orderItemQuantity`, `orderItemPrice`, `orderItemAddOn`, `orderItemPicture` FROM `order_item` WHERE orderID = '$orderCurrentID'";

                    $runOrderItemQ = @mysqli_query($connect, $orderItemQ);

                    while ($rowOrderItem = mysqli_fetch_array($runOrderItemQ, MYSQLI_ASSOC)) {
                        // get total for per itam
                        $totalPerOrderItem = $rowOrderItem['orderItemPrice'];

                        // get the menuaddon for each orderitem
                        $arrayMenuAddOnID = explode(',', $rowOrderItem['orderItemAddOn']);

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

                        echo '
                    <div class="addToCartCard">
                        <div class="wrapAddToCartCard">
                            <div class="imageOrder">';
                ?>
                        <div class="imageOrderr" style="background-image: url('imagesUpload/<?php echo $rowOrderItem['orderItemPicture']; ?>');"></div>
                <?php
                        echo '       
                            </div>
                            <div class="orderCartDetails">
                                <div class="fooAndDetails">
                                <h3 class="foodName">' . $rowOrderItem['orderItemName'] . ' x ' . $rowOrderItem['orderItemQuantity'] . '</h3>
                                <div class="menuAddOndetails"
                            ';

                        // looping the menuaddon array
                        if ($arrayMenuAddOnName != null) {
                            foreach ($arrayMenuAddOnName as $menuAddOn) {
                                echo '<p>' . $menuAddOn . '</p>';
                            }
                        } else {
                            echo '<p>no addOn</p>';
                        }

                        echo '        
                                </div>
                                </div>
                                <div class="foodCartPrice">
                                    <p>' . 'RM ' . $totalPerOrderItem . '</p>
                                </div>
                                <form action="deleteOrderItemCart.php" method="POST" class="removeItem">
                                <input type="text" hidden name="orderItemDelID" value="' . $rowOrderItem['orderItemID'] . '"/>
                                <input type="text" hidden name="userID" value="' . $userID . '"/>
                                <input type="text" hidden name="orderID" value="' . $orderCurrentID . '"/>

                                    <button type="submit" name="deleteID" value="delete"> 
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="white" viewBox="0 0 256 256">
                                            <path d="M216,48H176V40a24,24,0,0,0-24-24H104A24,24,0,0,0,80,40v8H40a8,8,0,0,0,0,16h8V208a16,16,0,0,0,16,16H192a16,16,0,0,0,16-16V64h8a8,8,0,0,0,0-16ZM96,40a8,8,0,0,1,8-8h48a8,8,0,0,1,8,8v8H96Zm96,168H64V64H192ZM112,104v64a8,8,0,0,1-16,0V104a8,8,0,0,1,16,0Zm48,0v64a8,8,0,0,1-16,0V104a8,8,0,0,1,16,0Z"></path>
                                    </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                        <hr>
                    </div>';
                    }
                } else {
                    echo '<div class="noOrder">
                    <h3>NO ORDER</h3>
                </div>';
                }
                ?>

            </div>

            <?php

            if ($haveOrder) {
                echo ' <!-- totall and proceed payment -->
                <div class="wrapperTotalAndProceed">
                    <div class="totalPaymnet">
                        <h3>Total</h3>
                        <h4>RM ' . $rowOrder['orderTotalAmount'] . '</h4>
                    </div>
                    <div class="proceedPayment">
                        <a href="payment.php?userID=' . $userID . '">
                            <button type="button">Proceed To Payment</button>
                        </a>
                    </div>
                </div>';
            } else {
                echo '';
            }

            ?>

        </div>
    </div>
</body>

</html>