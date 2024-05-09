<html>

<head>
    <title>Makan-Lah | Add Restaurant</title>
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

    <!-- ADD NEW RESTURANT START -->
    <div class="wrapperAllAddRestaurant">
        <div class="wrapperAddRestaurant">
            <div class="Addtitle">
                <h2>Add New Restaurant</h2>
            </div>
            <form action="addNewRestaurant.php" method="post">
                <div class="inputRestaurant">
                    <label for="newRestaurantName">Restaurant Name</label>
                    <input type="text" id="newRestaurantName" name="newRestaurantName" placeholder="your restaurant name" required />
                </div>
                <div class="inputRestaurant">
                    <label for="newRestaurantDesc">Restaurant Description</label>
                    <textarea id="newRestaurantDesc" name="newRestaurantDesc" placeholder="your restaurant desc" required></textarea>
                </div>
                <div class="inputRestaurant">
                    <label for="newRestaurantAddress">Restaurant Address</label>
                    <textarea id="newRestaurantAddress" name="newRestaurantAddress" placeholder="your restaurant Address" required></textarea>
                </div>
                <div class="inputRestaurant">
                    <label for="newRestaurantPhoneNo">Restaurant Phone No</label>
                    <input type="tel" id="newRestaurantPhoneNo" name="newRestaurantPhoneNo" placeholder="your restaurant Phone No" required />
                </div>
                <div class="inputRestaurant">
                    <label for="newRestaurantEmail">Restaurant Email</label>
                    <input type="email" id="newRestaurantEmail" name="newRestaurantEmail" placeholder="your restaurant Email" required />
                </div>
                <div class="inputRestaurant">
                    <label for="newRestaurantOpenHours">Restaurant Open Hours</label>
                    <input type="text" id="newRestaurantOpenHours" name="newRestaurantOpenHours" placeholder="your restaurant Open Hours" required />
                </div>
                <div class="btnSubmit">
                    <input type="submit" value="Next" class="submit">
                    <input type="reset" value="Reset" class="reset">
                </div>
            </form>


            <button class="btnModal" id="btnModal">Add Menu</button>

            <div id="modal" class="wrapperAddMenuModal">
                <div class="modalContent">
                    <span class="close">&times;</span>
                    <div>
                        <h1>Add menu for the restaurant</h1>
                    </div>

                    <div class="wrapMenuForm">
                        <div class="menuForm">
                            <form action="#" method="post">
                                <div class="menuInput">
                                    <label for="menuName">Menu Name</label>
                                    <input type="text" name="menuName" id="menuName" placeholder="Menu Name">
                                </div>
                                <div class="menuInput">
                                    <label for="menuDesc">Menu Desc</label>
                                    <input type="text" name="menuDesc" id="menuDesc" placeholder="Menu Desc">
                                </div>
                                <div class="menuInput">
                                    <label for="menuPrice">Menu Price</label>
                                    <input type="text" name="menuPrice" id="menuPrice" placeholder="Menu Price">
                                </div>
                                <div class="btnSubmit">
                                    <input type="submit" value="Add" class="submit" id="btnAddMenu">
                                    <input type="reset" value="Reset" class="reset">
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- ADD NEW RESTURANT END -->

    <script src="modal.js"></script>




</body>

</html>