<html>

<head>
    <title>ORDER PENDING | MAKAN-LAH</title>
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
    if ((isset($_GET['userID'])) && (is_numeric($_GET['userID']))) {
        $userID = $_GET['userID'];
    } else if (isset($_POST['userID']) && (is_numeric($_POST['userID']))) {
        $userID = $_POST['userID'];
    } else {
        echo '<p class="error">This Page has been accessed in error</p>';
        exit();
    }
    ?>

    <div class="wrapperAllRestaurantList">
        <div class="wrapperRestaurantList">
            <div class="subTitleRestaurantList">
                <h2>LIST ALL ORDER PENDING</h2>
            </div>
            <div class="wrapperTable">
                <table>
                    <tr>
                        <th>ORDER ID</th>
                        <th>ORDER DATE</th>
                        <th>ORDER AMOUNT</th>
                        <th>STATUS</th>
                    </tr>
                    <?php
                    // query all user
                    $allOrdersQ = "SELECT * FROM `orderhistory` WHERE orderHistoryStatus = 'Pending'";

                    // run the query
                    $resultAllOrders = @mysqli_query($connect, $allOrdersQ);

                    if ($resultAllOrders) {
                        while ($rowAllOrders = mysqli_fetch_array($resultAllOrders, MYSQLI_ASSOC)) {
                            echo '  <tr align="center" class="list">
                            <td>' . $rowAllOrders['orderID'] . '</td>
                            <td>' . $rowAllOrders['orderHistoryDate'] . '</td>
                            <td>' . $rowAllOrders['orderHistoryTotalAmount'] . '</td>
                            <td class="tdEdit"><a href="updateOrder.php?orderID=' . $rowAllOrders['orderID'] . '&typeF=1"><button class="btnEdit">DONE</button></a></td>
                        </tr>';
                        }
                    }
                    ?>

                </table>
            </div>
        </div>
    </div>


    <!-- <td class="tdEdit"><a href="./editUser.php?userID=' . $row['userID'] . '&userEditID=' . $rowAllUsers['userID'] . '"><button class="btnEdit">EDIT</button></a></td>
                            <td class="tdEdit"><a href="./deleteUser.php?userID=' . $row['userID'] . '&userDeleteID=' . $rowAllUsers['userID'] . '"><button class="btnDelete">DElETE</button></a></td> -->
</body>

</html>