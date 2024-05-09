<html>

<head>
    <title>Makan-Lah | Payment</title>
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
    if (isset($_POST['submit'])) {

        $error = [];

        // get user name
        if (empty($_POST['chooseBank'])) {
            $error = 'You forgot to enter the user name';
        } else {
            $cB = mysqli_real_escape_string($connect, trim($_POST['chooseBank']));
        }

        // get orders detail for the current user
        $currentOrderQ = "SELECT `orderID`, `userID`, `orderDate`, `orderTotalAmount`, `orderStatus` FROM `orders` WHERE userID = '$userID'";
        $runCurrentOrderQ = @mysqli_query($connect, $currentOrderQ);
        $resultCurrentOrder = mysqli_fetch_array($runCurrentOrderQ, MYSQLI_ASSOC);

        // set the value to variable
        $orderID = $resultCurrentOrder['orderID'];
        $orderDate = $resultCurrentOrder['orderDate'];
        $orderTotalAmount = $resultCurrentOrder['orderTotalAmount'];

        if ($resultCurrentOrder) {
            // insert into order history
            $orderHistoryQ = "INSERT INTO `orderhistory`(`orderID`, `userID`, `orderHistoryDate`, `orderHistoryTotalAmount`, `orderHistoryStatus`, `orderPaymentMethod`) VALUES ('$orderID','$userID','$orderDate','$orderTotalAmount','Pending', '$cB')";
            $runOrderHistoryQ = @mysqli_query($connect, $orderHistoryQ);


            if ($runOrderHistoryQ) {
                // delete order at table current order
                $deleteCurrentOrderQ = "DELETE FROM `orders` WHERE orderID = '$orderID'";
                $runDeleteCurrentOrderQ = @mysqli_query($connect, $deleteCurrentOrderQ);

                if ($runDeleteCurrentOrderQ) {
                    echo '<script>
                    window.location.href = "confirmationOrder.php?userID=' . $userID . '&orderID=' . $orderID . '&chooseBank=' . $cB . '";
                    </script>';
                }
            }
        }
    }
    ?>

    <!-- PAYMENT PAGE START -->
    <div class="wrapperAllPaymentPage">
        <div class="wrapPaymentPage">
            <h3>PAYMENT</h3>
            <form class="choosePay" action="payment.php?userID=<?php echo $userID; ?>" method="POST">
                <div class="wrapBankCard">
                    <input type="radio" id="chooseBank" name="chooseBank" value="cash">
                    <div>
                        <p><b>CASH AT COUNTER</b></p>
                    </div>
                </div>
                <div>
                    <hr>
                    <div class="or">
                        <p>OR</p>
                    </div>
                </div>
                <div class="onlinePay">
                    <div class="titlePayment">
                        <h3>Online Banking</h3>
                    </div>
                    <div class="wrapperChooseBank">
                        <div class="wrapBankCard">
                            <input type="radio" id="chooseBank" name="chooseBank" value="maybank">
                            <div>
                                <p><b>MAYBANK</b></p>
                            </div>
                        </div>
                        <div class="wrapBankCard">
                            <input type="radio" id="chooseBank" name="chooseBank" value="bankislam">
                            <div>
                                <p><b>BANK ISLAM</b></p>
                            </div>
                        </div>
                        <div class="wrapBankCard">
                            <input type="radio" id="chooseBank" name="chooseBank" value="hlb">
                            <div>
                                <p><b>HONG LEONG BANK</b></p>
                            </div>
                        </div>
                        <div class="wrapBankCard">
                            <input type="radio" id="chooseBank" name="chooseBank" value="adamubank">
                            <div>
                                <p><b>ADAMU BANK</b></p>
                            </div>
                        </div>
                        <div class="wrapperPlaceOrder">
                            <button type="submit" name="submit">PLACE ORDER</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- PAYMENT PAGE END -->
</body>

</html>