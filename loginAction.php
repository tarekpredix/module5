<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["email"];
    $password = $_POST["password"];

    $lines = file('users.txt');
    foreach ($lines as $line) {
        $user = json_decode($line, true);
        if ($user['email'] == $username && password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] == 'admin') {
                header("Location: admin_dashboard.php");
                exit;
            } else if ($user['role'] == 'manager') {
                header("Location: manager_dashboard.php");
                exit;
            }
            else{
                header("Location: dashboard.php");
                exit;
            }
        }
    }


    header("Location: login.php?error=1");
    exit;
}
?>
