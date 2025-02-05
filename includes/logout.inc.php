<?php
session_start();
$_SESSION = array(); // Clear all session variables
session_destroy(); // Destroy session
// Clear session cookie
if (ini_get('session.use_cookies')) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 4200, 
              $params['path'], $params['domain'], 
              $params['secure'], $params['httponly']);
}
header("Location: ../login-form/login-form.php");
exit();