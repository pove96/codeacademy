<?php
require('classes/Database.php');
require('classes/Model.php');
require('classes/abstract/AbstractUser.php');
require('classes/User.php');

$db = new Database('db.txt');
$user = new User($db);
//var_dump($_POST);
$action = $_POST['action'] ?? false; // Pracheckina ar vapse kazkoks actionas buvo atliktas
if ($action) {
    if ($action == 'register') {
        if (!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['confirm_password']) && !empty($_POST['full_name'])) {

            if ($_POST['password'] == $_POST['confirm_password']) {

                $user->register($_POST['email'], $_POST['password'], $_POST['full_name']);
            } else {
                print "Slaptazodziai nesutampa";
            }
        }
    }

    if ($action == 'login') {
        if (!empty($_POST['email']) && !empty($_POST['password'])) {
            $user->login($_POST['email'], $_POST['password']);
        }
    }

    if ($action == 'logout') {
        $user->logout();
    }
}
?>
<!DOCTYPE html>
<html>
    <head>

    </head>

    <body>
        <?php if ($user->isLoggedIn()): ?>
            <h1>Zdarova</h1>
        <?php endif; ?>
        <form id="RegisterForm" method="post" action="index.php">

            <h1>Register here!</h1>
            <input type="text" placeholder="Email@email.com" name="email" autofocus /> <br>
            <input type="text" placeholder="Password" name="password"/> <br>
            <input type="text" placeholder="Confirm Password" name="confirm_password"/> <br>
            <input type="text" placeholder="Full Name" name="full_name"/><br>
            <button name="action" value="register">Register Now!</button>
        </form>

        <form id="LoginForm" method="post" action="index.php">

            <h1>Login Here!</h1>
            <input type="text" placeholder="Email@email.com" name="email" autofocus /> <br>
            <input type="text" placeholder="Password" name="password"/> <br>
            <button name="action" value="login">Login Now!</button>
        </form>

        <form id="LogoutForm" method="post" action="index.php">
            <button name="action" value="logout">Logout!</button>
        </form>
    </body>
</html>