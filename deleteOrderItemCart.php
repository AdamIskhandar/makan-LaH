
<?php
include('connection.php');
?>

<?php



if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $error = [];

    // get user choose
    if (empty($_POST['deleteID'])) {
        $error = 'choose delete or cancel';
    } else {
        $iD = mysqli_real_escape_string($connect, trim($_POST['deleteID']));
    }

    // get user choose
    if (empty($_POST['userID'])) {
        $error = 'no UserID';
    } else {
        $userID = mysqli_real_escape_string($connect, trim($_POST['userID']));
    }

    // get orderitem id value
    if (empty($_POST['orderItemDelID'])) {
        $error = 'no order item id for delete';
    } else {
        $orderItemIDDelete = mysqli_real_escape_string($connect, trim($_POST['orderItemDelID']));
    }

    // get orderitem id value
    if (empty($_POST['orderID'])) {
        $error = 'no order item id for delete';
    } else {
        $orderID = mysqli_real_escape_string($connect, trim($_POST['orderID']));
    }

    if ($iD == 'delete') {

        // serach order item details
        $searchOrderItem = "SELECT * FROM `order_item` WHERE orderItemID = '$orderItemIDDelete'";
        $runQ = @mysqli_query($connect, $searchOrderItem);


        if ($resultQ = mysqli_fetch_array($runQ, MYSQLI_ASSOC)) {
            // search orders
            $searchOrder = "SELECT * FROM `orders` WHERE orderID = '$orderID'";
            $runOrderQ = @mysqli_query($connect, $searchOrder);

            if ($resultOrder = mysqli_fetch_array($runOrderQ, MYSQLI_ASSOC)) {
                // update total amount orders
                $newTotalAmount = $resultOrder['orderTotalAmount'] - $resultQ['orderItemPrice'];
                $updateOrder = "UPDATE `orders` SET `orderTotalAmount`='$newTotalAmount' WHERE orderID = '$orderID'";
                $runUpdateOrderQ = @mysqli_query($connect, $updateOrder);
            }
        }



        // user delete query
        $orderItemIDDeleteQuery = "DELETE FROM `order_item` WHERE orderitemID = '$orderItemIDDelete'";

        // run the query
        $resultDeleteQuery = @mysqli_query($connect, $orderItemIDDeleteQuery);

        if ($resultDeleteQuery) {
            echo '<script>
                        alert("The order item has been delete from database");
                        window.location.href ="addToCart.php?userID=' . $userID . '";
                        </script>';
            exit();
        } else {
            // if it didn't run
            // message 
            echo '<h1>System error</h1>';

            // debugging message
            echo '<p>' . mysqli_error($connect) . '<br><br>Query : ' . $q . '</p>';
        } // end of it (result)
    } else {
        echo '<script>
            alert("The order item not delete from database");
            window.location.href ="addToCart.php?userID=' . $userID . '";
            </script>';
    }

    mysqli_close($connect); //close the database connection_aborted
    exit();
    // end of the main submit conditional

}
