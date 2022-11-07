<?php
    
    //CONNECT TO MYSQL DATABASE USING MYSQLI
    $link = mysqli_connect("localhost", "root", "", "projectdata");

    // Check connection
    if($link === false){
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }
?>