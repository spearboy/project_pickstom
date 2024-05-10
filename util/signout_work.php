<?php
    include "./connect.php";
    include "./session.php";
    unset($_SESSION['userEmail']);
    unset($_SESSION['userName']);
    session_destroy();

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
    echo "<script>window.location.href='../'</script>";
?>