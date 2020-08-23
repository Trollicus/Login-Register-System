<?php
session_unset();
session_destroy();

header("location:loging.php");
exit();