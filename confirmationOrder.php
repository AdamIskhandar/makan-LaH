<html>

<head>
    <title>Makan-Lah | Resit</title>
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



    <!-- CONFIRMATION ORDER START -->
    <div class="wrapperConfirmationOrder">
        <div class="wrapConfirmationOrder">
            <h2>THANK YOU!</h2>
            <div class="speechConfirmOrder">
                <p>Your order has been received and is now being prepared with care. We'll let you know once it's ready for pickup or on its way to you. Enjoy your meal.</p>
            </div>
            <div class="seeOrder">
                <a href="receipt.php?userID=<?php echo $userID; ?>&orderID=<?php echo $orderID; ?>&chooseBank=<?php echo $chooseBank; ?>">
                    <button type="button">See Your Order Receipt</button>
                </a>
            </div>
        </div>
    </div>
</body>

</html>