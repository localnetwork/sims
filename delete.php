<?php

    include 'connect.php';

    $id = $_GET['id'];
    $delete = " DELETE FROM `student_info` WHERE stud_id = $id ";
    mysqli_query($con, $delete);
    header('location:index.php');

?>