<html>

<head>
    <title>
        Makan-Lah | Admin
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

    <!-- ADMIN PAGE STAET -->
    <div class="wrapperAllAdmin">
        <div>
            <h2>Choose what you want to do</h2>
        </div>
        <!-- for restaurant -->
        <div class="wrapperAdminCard">
            <div class="subtitleAdmin">
                <h4>FOR FOOD</h4>
            </div>
            <div class="wrapperAdminCardAll">
                <button class="adminCard">
                    <?php
                    echo '<a href="./addNewFood.php?userID=' . $row['userID'] . '"><h3>Add New Food</h3></a>';
                    ?>
                </button>
                <button class="adminCard">
                    <?php
                    echo '<a href="./addMenuAddOn.php?userID=' . $row['userID'] . '"><h3>Add Menu Add-On</h3></a>';
                    ?>
                </button>
                <button class="adminCard">
                    <?php
                    echo '<a href="./orderPending.php?userID=' . $row['userID'] . '"><h3>Order Pending</h3></a>';
                    ?>
                </button>
                <button class="adminCard">
                    <?php
                    echo '<a href="./addMenuAddOn.php?userID=' . $row['userID'] . '"><h3>Order Successful</h3></a>';
                    ?>l
                </button>
            </div>
        </div>
        <!-- for user -->
        <div class="wrapperAdminCard">
            <div class="subtitleAdmin">
                <h4>FOR USER</h4>
            </div>
            <div class="wrapperAdminCardAll">
                <button class="adminCard">
                    <?php
                    echo '<a href="./addUser.php?userID=' . $row['userID'] . '"><h3>Add User</h3></a>';
                    ?>
                </button>
            </div>
        </div>
        <!-- for rider -->
        <!-- <div class="wrapperAdminCard">
            <div class="subtitleAdmin">
                <h4>FOR RIDER</h4>
            </div>
            <div class="wrapperAdminCardAll">
                <button class="adminCard">
                    <h3>Add New Rider</h3>
                </button>
                <button class="adminCard">
                    <h3>Delete Rider</h3>
                </button>
                <button class="adminCard">
                    <h3>Edit Rider</h3>
                </button>
                <button class="adminCard">
                    <h3>View All Rider</h3>
                </button>
            </div>
        </div> -->
    </div>
    <!-- ADMIN PAGE END -->

</body>

</html>