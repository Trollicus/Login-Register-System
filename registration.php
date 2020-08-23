<?php

require 'class/SMTPMailer.php';

$con = mysqli_connect("localhost", "root", "", "autism");


if (isset($_POST['submit'])) {
    $name =  ($_POST['user_username']);
    $pass = Important::generateRandomString();
    $lmfao = password_hash($pass, PASSWORD_DEFAULT);
    $email = $_POST['user_email'];
    $hash = md5(rand(0, 10000));
    $token = ($_POST['user_token']);

    $sql = "SELECT * FROM dang WHERE user_username = '$name'";
    $result = mysqli_query($con, $sql);
    $count = mysqli_num_rows($result);

    $SelectEmail = "SELECT * FROM dang WHERE user_email = '$email'";
    $EmailResult = mysqli_query($con, $SelectEmail);
    $EmailCount = mysqli_num_rows($EmailResult);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format!");
    }
    if (empty($name)) {
        die("Name is Required");
    }
    if (empty($email)) {
        die("Email is Required");
    }
    if (empty($token)) {
        die("Token is Required");
    }
    if ($count > 0) {
        echo "Username is Already Taken";
    } else {
        if ($EmailCount > 0) {
            echo "Email Address Already Registered!";
        } else {
            $SelectToken = "SELECT * FROM tokenz WHERE user_token = '$token'";
            $TokenlResult = mysqli_query($con, $SelectToken);
            $TokenCount = mysqli_num_rows($TokenlResult);

            if ($TokenCount > 0) {
                mysqli_query($con, "DELETE FROM `tokenz` WHERE `user_token` = '$token'");

                $query = $con->prepare("INSERT INTO `dang` (user_username, user_password, user_email, user_hash) VALUES ('$name', '$lmfao', '$email', '$hash')");
                $query->store_result();
                $query->execute();

                //echo $pass;

                if ($query) {
                    echo "Successfully Registered";
                    //echo "An verification email has been sent to you!" . "\r\n";


                    $mail = new SMTPMailer();

                    $mail->addTo($email);
                    $mail->from = "Trollicus";
                    $mail->Subject('Verification Email - Trollicus');
                    $mail->Body("
     
                        Thanks for signing up!
                       Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.
                        
                        =-=-=-=-=-=-=-=-=-=
                        Username: '.$name.'
                        Password: '.$pass.'
                       =-=-=-=-=-=-=-=-=-=
                        
                        Please click this link to activate your account:
                       http://localhost/verify.php?user_email=$email&user_hash=$hash
                   ");

                    if ($mail->Send()) echo ' An verification email has been sent to you!\n\r';
                    else               echo ' Mail failure, Please Contact a Developer!';

                    echo "\n\r Redirecting in 5s...";
                    header("Refresh: 5; location:loging.php");
                } else {
                    die("something went wrong");
                }
                //   }
            } else {
                echo ("Invalid Token");
            }
        }
    }
} else {
    die("Nope baby <3");
}

class Important
{
    function generateRandomString($length = 20)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
