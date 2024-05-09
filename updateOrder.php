<?php
// call file connection.php to connect to server
include("connection.php");


if ((isset($_GET['orderID'])) && (is_numeric($_GET['orderID']))) {
    $orderID = $_GET['orderID'];
} else if (isset($_POST['orderID']) && (is_numeric($_POST['orderID']))) {
    $orderID = $_POST['orderID'];
} else {
    echo '<p class="error">This Page has been accessed in error</p>';
    exit();
}

if ((isset($_GET['typeF'])) && (is_numeric($_GET['typeF']))) {
    $typeF = $_GET['typeF'];
} else if (isset($_POST['typeF']) && (is_numeric($_POST['typeF']))) {
    $typeF = $_POST['typeF'];
} else {
    echo '<p class="error">This Page has been accessed in error</p>';
    exit();
}

if ($typeF = '1') {
    // query all user
    $OrdersQ = "UPDATE `orderhistory` SET `orderHistoryStatus`='Succesfull' WHERE orderID = $orderID";

    // run edit user query
    $resultOrder = @mysqli_query($connect, $OrdersQ);

    if ($resultOrder) {
        echo '<script>
                        alert("The order succesfully done!");
                        window.location.href ="orderPending.php?userID=' . $row['userID'] . '";
                        </script>';
        exit();
    } else {
        // if it didn't run
        // message 
        echo '<h1>System error</h1>';

        // debugging message
        echo '<p>' . mysqli_error($connect) . '<br><br>Query : ' . $q . '</p>';
    } // end of it (result)
    mysqli_close($connect); //close the database connection_aborted
    exit();
}
