<?php
    session_start();
    require_once "config.php";
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, md5($_POST['password']));

    if (!empty($email) && !empty($password)) {
        $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}' AND password = '{$password}'");
        if (mysqli_num_rows($sql) > 0) {
            $row = mysqli_fetch_assoc($sql);
            $_SESSION['unique_id'] = $row['user_id'];
            echo "Success";
        } else {
            echo "Email Or Password Is In Correct, Try Again";
        }
    } else {
        echo "Form Can't Be Empty";
    }

