<html>

<head>
    <title>
        Makan-Lah | Order History
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



    <!-- ORDER HISTORY PAGE START -->
    <div class="wrapperAllOrderHistory">
        <div class="wrapOrderHistoryy">
            <div>
                <h3>YOUR ORDER HISTORY</h3>
            </div>
            <div class="wrapOrderHistoryCard">
                <?php
                // get all data order history for current user
                $orderHistoryQ = "SELECT `orderHistoryID`, `orderID`, `userID`, `orderHistoryDate`, `orderHistoryTotalAmount`, `orderHistoryStatus`, `orderPaymentMethod` FROM `orderhistory` WHERE userID = '$userID'";
                $runOrderHistoryQ = @mysqli_query($connect, $orderHistoryQ);


                while ($resultOrderHistoryQ = mysqli_fetch_array($runOrderHistoryQ, MYSQLI_ASSOC)) {
                    if ($resultOrderHistoryQ['orderHistoryStatus'] == 'Pending') {
                        echo '
                        <div class="orderHistoryCard">
                            <a href="orderHistoryDetails.php?userID=' . $userID . '&orderID=' . $resultOrderHistoryQ['orderID'] . '&chooseBank=' . $resultOrderHistoryQ['orderPaymentMethod'] . '">
                                <h4 class="orderIDCard">Order ID - #' . $resultOrderHistoryQ['orderID'] . '</h4>
                            </a>
                            <div class="statusOrder">
                                <p>Pending</p>
                            </div>
                            <div class="orderDateAndAmount">
                                <div class="date">
                                    <p>Date - ' . $resultOrderHistoryQ['orderHistoryDate'] . '</p>
                                </div>
                                <div class="amount">
                                    <p>Total - RM ' . $resultOrderHistoryQ['orderHistoryTotalAmount'] . '</p>
                                </div>
                            </div>
                        </div>
                        ';
                    } else {
                        echo '
                        <div class="orderHistoryCard">
                            <a href="orderHistoryDetails.php?userID=' . $userID . '&orderID=' . $resultOrderHistoryQ['orderID'] . '&chooseBank=' . $resultOrderHistoryQ['orderPaymentMethod'] . '">
                                <h4 class="orderIDCard">Order ID - #' . $resultOrderHistoryQ['orderID'] . '</h4>
                            </a>
                            <div class="statusOrderSucces">
                                <p>Done</p>
                            </div>
                            <div class="orderDateAndAmount">
                                <div class="date">
                                    <p>Date - ' . $resultOrderHistoryQ['orderHistoryDate'] . '</p>
                                </div>
                                <div class="amount">
                                    <p>Total - RM ' . $resultOrderHistoryQ['orderHistoryTotalAmount'] . '</p>
                                </div>
                            </div>
                        </div>
                        ';
                    }
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>