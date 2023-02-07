<?php
#Sign up
if (isset($_POST['signup'])) {
    #Declare varaibles
    $user_first_name = mysqli_real_escape_string($mysqli, $_POST['user_first_name']);
    $user_last_name = mysqli_real_escape_string($mysqli, $_POST['user_last_name']);
    $user_email = mysqli_real_escape_string($mysqli, $_POST['user_email']);
    $user_password = password_hash(mysqli_real_escape_string($mysqli, $_POST['user_password']), PASSWORD_DEFAULT);
    #Prevent Double Entries 
    $sql = "SELECT * FROM  users WHERE user_email = '{$user_email}' ";
    $res = mysqli_query($mysqli, $sql);
    if (mysqli_num_rows($res) > 0) {
        $err = "user name already exists";
    } else {
        #Store to Users Table
        $query = "INSERT INTO `users`(`user_email`, `user_password`,  `user_first_name`, `user_last_name`)
     VALUES ('{$user_email}','{$user_password}','{$user_first_name}','{$user_last_name}')";
        #Welcome Email
        /* Load New User Account Mailer  */
        include('../mailers/welcome.php');
        if (mysqli_query($mysqli, $query) && $mail->send()) {
            $_SESSION['success'] = "Sign up is Done";
            header('Location: index');
        } else {
            $err = "Failed !Try Again";
        }
    }
}

#Sign up
session_start();
if (isset($_POST['sign_in'])) {
    #Declare Variable
    $user_email = mysqli_real_escape_string($mysqli, $_POST['user_email']);
    $user_password = mysqli_real_escape_string($mysqli, $_POST['user_password']);

    #Check Password
    $sql = "SELECT * FROM  users WHERE user_email = '{$user_email}' ";
    $res = mysqli_query($mysqli, $sql);
    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        $hash_password = $row['user_password'];

        if (mysqli_num_rows($res) > 0 && password_verify($user_password, $hash_password)) {
            /* Session Variables */
            $_SESSION['user_id'] =  $row['user_id'];
            $_SESSION['success'] = 'You have successfully logged in';
            header('Location: dashboard');
            exit;
        } else {
            $err = "Failed !Try Again";
        }
    }
}

#Update User

if(isset($_POST['update_user'])){
    $user_id =mysqli_real_escape_string($mysqli,$_POST['user_id']);
    $user_first_name = mysqli_real_escape_string($mysqli, $_POST['user_first_name']);
    $user_last_name = mysqli_real_escape_string($mysqli, $_POST['user_last_name']);
    $user_email = mysqli_real_escape_string($mysqli, $_POST['user_email']);

    #Update User sql
    $sql="UPDATE `users` SET `user_email`='{$user_email}',`user_first_name`='{$user_first_name}',`user_last_name`='{$user_last_name}' WHERE `user_id`='{$user_id}'";
    $query=mysqli_query($mysqli,$sql);
    if ($query) {
        $_SESSION['success'] = 'You have update info';
    } else {
        $err = "Failed !Try Again";   
    
}
}

#update Income 
if(isset($_POST['update_income'])){
    $user_id =mysqli_real_escape_string($mysqli,$_POST['user_id']);
    $user_current_salary = mysqli_real_escape_string($mysqli, $_POST['user_current_salary']);
   

    #Update User sql
    $sql="UPDATE `users` SET `user_current_salary`='{$user_current_salary}' WHERE `user_id`='{$user_id}'";
    $query=mysqli_query($mysqli,$sql);
    if ($query) {
        $_SESSION['success'] = 'You have update Income';
    } else {
        $err = "Failed !Try Again";   
    
}
}
