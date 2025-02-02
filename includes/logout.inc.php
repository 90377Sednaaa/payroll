<?php
session_start();
session_unset();
session_destroy();
header("Location: ../login-form/login-form.php");
exit();