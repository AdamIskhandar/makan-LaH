<html>

<head>
    <title>Makan-LaH | About Us</title>
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
    <!-- ABOUT US PAGE START -->
    <div class="wrapperAllAboutUs">
        <div class="wrapperAboutUs">
            <div class="about-section">
                <h1>About Us Page</h1>

                <div class="logoAndDescc">
                    <div class="desc">
                        <p>
                            Welcome to Makan-Lah, where culinary excellence meets heartfelt hospitality! As a premier restaurant,
                            Makan-Lah is more than just a place to dine; it's an experience infused with the rich flavors
                            and vibrant culture of malaysia. Our journey began with a simple yet
                            profound mission: to create a haven where food lovers can indulge in authentic dishes crafted
                            with love and attention to detail. With a team of passionate chefs and dedicated staff,
                            we pour our hearts into every dish we serve, ensuring that each bite is a culinary delight.
                            From traditional favorites to innovative creations, our menu showcases the best of the best,
                            prepared with fresh, locally sourced ingredients whenever possible.
                            Whether you're joining us for a casual meal with friends or celebrating a special occasion,
                            Makan-Lah invites you to savor the moment and relish the flavors that unite us all.
                            Come dine with us and experience the magic of Makan-Lah –
                            where every meal is a celebration of good food, good company, and good times.</p>
                    </div>

                    <div class="logoo">
                        <img src="images/logo.png" alt="imageContent" />
                    </div>
                </div>
            </div>

            <h2 style="text-align:center">Our Developer</h2>
            <div class="row">
                <div class="column">
                    <div class="card">
                        <img src="images/bg2.png" alt="Jane" style="width:100%">
                        <div class="container">
                            <h2>Adam Iskhandar</h2>
                            <p class="titleAbt">CEO & Founder</p>
                            <p>The moon isn't beautiful right?</p>
                            <p>AdamIskhandar@gmail.com</p>
                            <p><button class="button">Contact</button></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>