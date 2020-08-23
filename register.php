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
        <form action="registration.php" method="POST">
            <p>
                <label>Username:</label>
                <input type="text" autocomplete="off" id="user_username" name="user_username" required />
            </p>
            <p>
                <label>Your Email:</label>
                <input type="text" autocomplete="off" id="user_email" name="user_email" required />
            </p>
            <p>
            <label>Your Key:</label>
                <input type="text" autocomplete="off" id="user_token" name="user_token"  required />
            <p>
            <div class="g-recaptcha" data-sitekey="6Le0dKYZAAAAAPJtoWauTEY4ahXqgRqRmE3K0Ya0" data-callback='onSubmit'></div>
                </br>
            <script>
                    window.onload = function() {
                        var $recaptcha = document.querySelector('#g-recaptcha-response');

                        if ($recaptcha) {
                            $recaptcha.setAttribute("required", "required");
                        }
                    };
                </script>
                <input name="submit" type="submit" id="btn" value="Register" />    
            </p>
        </form>
    </div>
</body>

</html>