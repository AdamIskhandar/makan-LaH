<html>

<head>
    <title>Makan-LaH</title>
</head>

<body>

    <?php
    // call file connection.php to connect to server
    include("connection.php");
    ?>

    <style>
        <?php include 'style.css'; ?>
    </style>

    <!-- call header file -->
    <?php
    include("header.php");
    ?>

    <?php
    // get all data for current user
    $userQuery = "SELECT `userID`, `userName`, `userPassword`, `userEmail`, `userPhoneNo`, `userAddress`, `userCreated_at`, `isAdmin` FROM `user` WHERE userID = '$userID'";
    $runUserQuery = @mysqli_query($connect, $userQuery);
    $resultUserQuery = mysqli_fetch_array($runUserQuery, MYSQLI_ASSOC);
    ?>


    <div class="wrapperProfilePicture">
        <div class="wrapperProfile">
            <!-- profile image -->
            <div class="wrapProfileImage">
                <img src="./images/logo.png" alt="profile">
                <div class="wrapProfileDetails">
                    <?php
                    echo '
                    <h3>' . $resultUserQuery['userName'] . '</h3>
                    <p class="gmail">' . $resultUserQuery['userEmail'] . '</p>
                    <p class="profilePhone">' . $resultUserQuery['userPhoneNo'] . '</p>
                    ';
                    ?>

                </div>
                <div class="editProfileButton">
                    <a href="editprofile.php?userID=<?php echo $userID; ?>">
                        <button>Edit Profile</button>
                    </a>
                </div>
            </div>
            <hr>
            <!-- profile order history -->
            <div class="wrapProfileOrderHistory">
                <div class="wrapOrderHistory">
                    <h3>Your Order</h3>
                    <div class="orderList">

                        <?php
                        // get all data order history for current user
                        $orderHistoryQ = "SELECT `orderHistoryID`, `orderID`, `userID`, `orderHistoryDate`, `orderHistoryTotalAmount`, `orderHistoryStatus`, `orderPaymentMethod` FROM `orderhistory` WHERE userID = '$userID'";
                        $runOrderHistoryQ = @mysqli_query($connect, $orderHistoryQ);


                        while ($resultOrderHistoryQ = mysqli_fetch_array($runOrderHistoryQ, MYSQLI_ASSOC)) {
                            echo '
                    <div class="orderHistoryCard">
                        <a href="orderHistoryDetails.php?userID=' . $userID . '&orderID=' . $resultOrderHistoryQ['orderID'] . '&chooseBank=' . $resultOrderHistoryQ['orderPaymentMethod'] . '">
                            <h4 class="orderIDCard">Order ID - #' . $resultOrderHistoryQ['orderID'] . '</h4>
                        </a>
                        <div class="statusOrder">
                            <p>' . $resultOrderHistoryQ['orderHistoryStatus'] . '</p>
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
                        ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</body>

</html>