<html>

<head>
    <title>Makan-LaH | Add User List</title>
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




    <!-- RESTAURANT LIST START -->
    <div class="wrapperAllRestaurantList">
        <div class="wrapperRestaurantList">
            <div class="subTitleRestaurantList">
                <h2>LIST ALL USER AND ADMIN</h2>
            </div>
            <div class="wrapperTable">
                <table>
                    <tr>
                        <th>User Name</th>
                        <th>is User Admin?</th>
                        <th>EDIT</th>
                        <th>DELETE</th>
                    </tr>
                    <?php
                    // query all user
                    $allUsersQ = "SELECT * FROM `user` ORDER BY userID";

                    // run the query
                    $resultAllUsers = @mysqli_query($connect, $allUsersQ);

                    if ($resultAllUsers) {
                        while ($rowAllUsers = mysqli_fetch_array($resultAllUsers, MYSQLI_ASSOC)) {
                            echo '  <tr align="center" class="list">
                            <td>' . $rowAllUsers['userName'] . '</td>
                            <td>' . $rowAllUsers['isAdmin'] . '</td>
                            <td class="tdEdit"><a href="./editUser.php?userID=' . $row['userID'] . '&userEditID=' . $rowAllUsers['userID'] . '"><button class="btnEdit">EDIT</button></a></td>
                            <td class="tdEdit"><a href="./deleteUser.php?userID=' . $row['userID'] . '&userDeleteID=' . $rowAllUsers['userID'] . '"><button class="btnDelete">DElETE</button></a></td>
                        </tr>';
                        }
                    }
                    ?>

                </table>
            </div>
        </div>
    </div>
    <!-- RESTAURANT LIST END -->
</body>

</html>