<html>

<head>
    <title>
        Makan-Lah | Food
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

    <!-- search bar -->
    <div class="wrapperSearchBarFood">
        <div class="textContentFood">
            <h1>Hungry? Let Makan-LaH handle it.</h1>
        </div>
        <form class="searchBar" action="allFood.php?userID=<?php echo $userID; ?>" method="POST">
            <label for="searchBar" class="searchLabel">Search Your Food</label>
            <input type="text" class="searchBarInput" name="searchBar" id="searchBar" placeholder="Your Favourite Food" value="<?php if (isset($_POST['searchBar'])) echo $_POST['searchBar']; ?>" />

            <div class="wrapperbtnSearch">
                <button type="submit">Find Food</button>
            </div>
        </form>
    </div>
    <!-- FOOD START -->
    <div class="foodContainer">


        <!-- food -->
        <div class="food">
            <h1>Choose your favourite food at Makan-Lah</h1>
        </div>
        <div class="foodCardContainer">

            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {

                $error = [];

                // get user name
                if (empty($_POST['searchBar'])) {
                    $error = 'no search value';
                    $searchValue = FALSE;
                } else {
                    $searchValue = mysqli_real_escape_string($connect, trim($_POST['searchBar']));
                }

                if ($searchValue) {
                    // if searcvalue have value
                    // query search value
                    $searchQ = "SELECT * FROM `food` WHERE CONCAT(foodName, foodCategory) LIKE '%$searchValue%'";
                    $runSearchQ = @mysqli_query($connect, $searchQ);

                    while ($resultSearchQ = mysqli_fetch_array($runSearchQ, MYSQLI_ASSOC)) {
                        echo '<div class="foodCard">
                        <a href="orderFood.php?foodID=' . $resultSearchQ['foodID'] . '&userID=' . $userID . '">
                        <div class="imageFood" style="background-image: url(imagesUpload/' . $resultSearchQ['foodToken'] . ');"></div>
                            <div class="title">
                                <div>
                                    ' . $resultSearchQ['foodName'] . '
                                    <div class="description">' . $resultSearchQ['foodDesc'] . '</div>
                                </div>
                                <div class="foodPrice">' . 'RM ' . $resultSearchQ['foodPrice'] . '</div>
                            </div>
                        </a>
                        </div>';
                    }
                } else {
                    // if search value is false or no value
                    // make the query
                    $query = 'SELECT * FROM food ORDER BY foodID';

                    // run the query and assign it to the variable $result
                    $result = @mysqli_query($connect, $query);

                    if ($result) {
                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                            echo '<div class="foodCard">
                                                <a href="orderFood.php?foodID=' . $row['foodID'] . '&userID=' . $userID . '">
                                                <div class="imageFood" style="background-image: url(imagesUpload/' . $row['foodToken'] . ');"></div>
                                                    <div class="title">
                                                        <div>
                                                            ' . $row['foodName'] . '
                                                            <div class="description">' . $row['foodDesc'] . '</div>
                                                        </div>
                                                        <div class="foodPrice">' . 'RM ' . $row['foodPrice'] . '</div>
                                                    </div>
                                                </a>
                                                </div>';
                        }
                    } else {
                        echo '<div class="foodCard">
                                    <a href="orderFood.php?foodID=' . $row['foodID'] . '&userID=' . $userID . '">
                                        <img src="images/nasiayam.png" alt="nasi ayam" />
                                        <div class="title">
                                            <div>
                                                ' . $row['foodName'] . '
                                                <div class="description">' . $row['foodDesc'] . '</div>
                                            </div>
                                            <div class="foodPrice">' . $row['foodPrice'] . '</div>
                                        </div>
                                    </a>
                                    </div>';
                    }
                }
            } else {
                // if no post form server
                // make the query
                $query = 'SELECT * FROM food ORDER BY foodID';

                // run the query and assign it to the variable $result
                $result = @mysqli_query($connect, $query);

                if ($result) {
                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                        echo '<div class="foodCard">
                                                <a href="orderFood.php?foodID=' . $row['foodID'] . '&userID=' . $userID . '">
                                                <div class="imageFood" style="background-image: url(imagesUpload/' . $row['foodToken'] . ');"></div>
                                                    <div class="title">
                                                        <div>
                                                            ' . $row['foodName'] . '
                                                            <div class="description">' . $row['foodDesc'] . '</div>
                                                        </div>
                                                        <div class="foodPrice">' . 'RM ' . $row['foodPrice'] . '</div>
                                                    </div>
                                                </a>
                                                </div>';
                    }
                } else {
                    echo '<div class="foodCard">
                                    <a href="orderFood.php?foodID=' . $row['foodID'] . '&userID=' . $userID . '">
                                        <img src="images/nasiayam.png" alt="nasi ayam" />
                                        <div class="title">
                                            <div>
                                                ' . $row['foodName'] . '
                                                <div class="description">' . $row['foodDesc'] . '</div>
                                            </div>
                                            <div class="foodPrice">' . $row['foodPrice'] . '</div>
                                        </div>
                                    </a>
                                    </div>';
                }
            }
            mysqli_close($connect); //close the database connection_aborted
            exit();


            ?>

        </div>
    </div>
    <!-- FOOD END -->
</body>

</html>