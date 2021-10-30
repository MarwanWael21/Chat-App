<?php
    session_start();
    include_once "config.php";

    $outgoing_id = $_SESSION['unique_id'];
    $searchForm = mysqli_real_escape_string($conn, $_POST['searchForm']);

    $sql = "SELECT * FROM users WHERE NOT user_id = {$outgoing_id} AND (fname LIKE '%{$searchForm}%' OR lname LIKE '%{$searchForm}%') ";
    $output = "";
    $query = mysqli_query($conn, $sql);
    if(mysqli_num_rows($query) > 0){
        include_once "data.php";
    }else{
        $output .= 'No user found related to your search term';
    }
    echo $output;
