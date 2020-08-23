<!DOCTYPE html>
<html>

<head>
    <title>Trollicus</title>
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <script>
        function onSubmit(token) {
            document.getElementById("Login").submit();
        }
    </script>


</head>

<body>
    <div id="frm">
        <form action="connect.php" method="POST">
            <p>
                <label>Username:</label>
                <input type="text" id="user_username" name="username" required />
            </p>
            <p>
                <label>Password:</label>
                <input type="password" autocomplete="off" id="user_password" name="password"  required />
            </p>
            <p>
                <div class="g-recaptcha" data-sitekey="6Le0dKYZAAAAAPJtoWauTEY4ahXqgRqRmE3K0Ya0" data-callback='onSubmit'></div>
                </br>
                <input type="submit" id="btn" value="Login" />
                <script>
                    window.onload = function() {
                        var $recaptcha = document.querySelector('#g-recaptcha-response');

                        if ($recaptcha) {
                            $recaptcha.setAttribute("required", "required");
                        }
                    };
                </script>
                <?php ini_set('session.cookie_secure', 1);
                ini_set('session.cookie_httponly', 1); ?>

                <input id="login-username" type="hidden" class="form-control" name="csrf_token" value="<?php ini_set('display_errors', '0');
                                                                                                        echo $_SESSION['oken']; ?>">
            </p>
        </form>
    </div>
</body>

</html>