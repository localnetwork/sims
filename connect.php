<?php
    $con = mysqli_connect("localhost", "crud_php", "crud_php", "crud_php", port: 3390);

    // Check connection
    if (!$con) {
        die("Connection failed: " . mysqli_connect_error());
    }
?>