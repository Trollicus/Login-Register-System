<?php


$con = mysqli_connect("localhost", "root", "", "autism");



ini_set('session.cookie_secure', 1);
ini_set('session.cookie_httponly', 1);

class Token
{
    public static function generate_token($session_id)
    {
        $_SESSION['oken'] = md5($session_id);
        return $_SESSION['oken'];
    }

    public static function check_token($token)
    {
        if (isset($_SESSION['oken']) && $token === $_SESSION['oken']) {
            unset($_SESSION['oken']);
            return true;
        } else {
            return false;
        }
    }
}


if ($stmt = $con->prepare('SELECT user_username, user_password FROM dang WHERE user_username = ? AND active = "1" LIMIT 1')) {

    $lifetime = 20;
    ini_set('display_errors', '0');
    session_start();
    $_SESSION["logeduser"] = $_POST['username'];
    $stmt->bind_param('s', $_SESSION["logeduser"]);
    $token = Token::generate_token(session_id());
    setcookie("id", session_id(), time() + $lifetime);
    setcookie("token", $token, time() + $lifetime);
    $stmt->execute();
    $stmt->store_result();
    $rows = $stmt->num_rows();

   

    $stmt->bind_result($_user_username, $_user_password);

    while ($stmt->fetch()) {
        if (password_verify($_POST['password'], $_user_password) === false) {

            header("refresh:5;url=loging.php");
            die("Username or Password is wrong!");
        }

      

        //  echo'successfully logged';
        if (Token::check_token($token)) {
            header('Refresh: 3600; location:logout.php');


            echo 'successfully logged';
            echo"\r<a href='logout.php'>LogOut</a>";


            $pageWasRefreshed = isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] === 'max-age=0';
 
            if($pageWasRefreshed ) {
                header("location:logout.php");
            }


        } else {
            die("Uhh, Ohh, Something went wrong, please try again!");
        }

        //session_destroy(); unset($_SESSION["logeduser"]);

    }



    $stmt->close();
    $con->close();
    unset($rows, $stmt, $con);
}
