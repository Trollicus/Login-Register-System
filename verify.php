<?php

$con = mysqli_connect("localhost", "root", "", "autism");

if(isset($_GET['user_email']) && !empty($_GET['user_email']) AND isset($_GET['user_hash']) && !empty($_GET['user_hash'])){
    $email = $_GET['user_email']; 
    $hash = $_GET['user_hash']; 


    $yeet = "SELECT user_email, user_hash, active FROM dang WHERE user_email='".$email."' AND user_hash='".$hash."' AND active='0'";
    $EmailResult = mysqli_query($con, $yeet);
    $EmailCount = mysqli_num_rows($EmailResult);

                 
    if($EmailCount > 0){
        mysqli_query($con,"UPDATE dang SET active='1' WHERE user_email='".$email."' AND user_hash='".$hash."'");
        echo 'Your account has been activated, you can now login';
    }else{
        echo '<div class="statusmsg">The url is either invalid or you already have activated your account.';
    }
                 
}else{
    echo 'Invalid approach, please use the link that has been send to your email.';
}