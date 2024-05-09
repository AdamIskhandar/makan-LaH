<html>

<head>
    <title>Database Connecton</title>
</head>

<body>
    <?php
    // connect to server
    $connect = mysqli_connect("localhost", "root", "", "makanlah",);

    if (!$connect) {
        die('ERROR:' . mysqli_connect_error());
    }
    ?>
</body>

</html>