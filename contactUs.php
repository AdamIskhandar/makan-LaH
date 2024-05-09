<html>

<head>
    <title>
        Makan-Lah | Contact Us
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

    <div class="wrapperAllContactUs">
        <div class="wrapperContactUs">
            <h2>Contact Us</h2>
            <form action="https://api.web3forms.com/submit" method="POST">

                <input type="hidden" name="access_key" value="da2926d4-449e-460f-b93e-9306cc3d1773">
                <div class="inputUser">
                    <label for="name">Your Name</label>
                    <input type="text" id="name" name="name" placeholder="Your Name" required>
                </div>
                <div class="inputUser">
                    <label for="email">Your Email</label>
                    <input type="email" id="email" name="email" placeholder="Your Email" required>
                </div>
                <div class="inputUser">
                    <label for="message">Your Message</label>
                    <textarea name="message" id="message" cols="30" rows="10"></textarea>
                </div>
                <div class="wrapbtnCont">
                    <button class="submitCont" type="submit" name="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>