<?php
    session_start();
    require_once "config.php";
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    if (!empty($fname) && !empty($lname) &&!empty($email) &&!empty($password)) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $sql = mysqli_query($conn, "SELECT email FROM users WHERE email = '{$email}'");
            if (mysqli_num_rows($sql) > 0) {
                echo $email . "This Email Already Exist";
            } else {
                if (isset($_FILES['image'])) {
                    $img_name = $_FILES['image']['name'];
                    $img_type = $_FILES['image']['type'];
                    $img_temp = $_FILES['image']['tmp_name'];

                    $img_explode = explode('.',$img_name);
                    $img_ext = end($img_explode);
                    $extensions = ["jpeg", "png", "jpg"];

                    if (in_array($img_ext, $extensions)) {
                        $time = time();
                        $up_img_name = $time.$img_name;
                        if (move_uploaded_file($img_temp, "images/" . $up_img_name)) {
                            $status = "Online";
                            $rand_id = rand(time(), 1000000000);
                            $encrypt_pass = md5($password);
                            $new_acc = mysqli_query($conn, "INSERT INTO users (user_id, fname, lname, email, password, img, status)
                            VALUES ({$rand_id}, '{$fname}','{$lname}', '{$email}', '{$encrypt_pass}', '{$up_img_name}', '{$status}')");
                            if ($new_acc) {
                                $check_acc = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
                                if(mysqli_num_rows($check_acc) > 0){
                                        $row = mysqli_fetch_assoc($check_acc);
                                        $_SESSION['unique_id'] = $row['user_id'];
                                        echo "Success";
                                }
                            } else {
                                echo "Something Is Wrong, Try Again!";
                            }
                        }
                    } else { 
                        echo "Please Select An Image With Extenxion [jpg, jpeg, png] Only";
                    }
                } else {
                    echo "Please Select An Image";
                }
            }
        } else {
            $email . " Is Not Valid";
        }
    } else {
        echo "Please Insert Data Into The Feild";
    }
?>