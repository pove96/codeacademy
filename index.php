<?php
require('tinder/classes/Database.php');
require('tinder/classes/Model.php');
require('tinder/classes/abstracts/AbstractUser.php');
require('tinder/classes/User.php');
require('tinder/classes/UserRepository.php');
require('tinder/classes/Session.php');

$db = new Database('db.txt');

$repository = new UserRepository($db); // i repozitorija paduodi database
$session = new Session($repository); // o i database paduodi repozitorija

$action = $_POST['action'] ?? false; // Pracheckina ar vapse kazkoks actionas buvo atliktas
if ($action) {
    if ($action == 'register') {
        if (!empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['confirm_password']) && !empty($_POST['full_name'])) {
            if ($_POST['password'] == $_POST['confirm_password']) {
                $data = [
                    'fullname' => $_POST['full_name'],
                    'age' => $_POST['Age'],
                    'gender' => $_POST['Gender']
                ];
                $session->register($_POST['email'], $_POST['password'], $data);
            } else {
                print "Slaptazodziai nesutampa";
            }
        }
    }
    if ($action == 'login') {
        if (!empty($_POST['email']) && !empty($_POST['password'])) {
            $session->login($_POST['email'], $_POST['password']);
        }
    }
    if ($action == 'logout') {
        $session->logout();
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <style>
            .formu_centravimas {
                text-align: center;
            }
            form {
                position: relative;
                z-index: 1;
                background: #FFFFFF;
                max-width: 360px;
                margin: 0 auto 100px;
                padding: 40px;
                text-align: center;
                box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
            }
            button {

                text-transform: uppercase;
                background: #4CAF50;
                width: 60%;
                border: 0;
                padding: 15px;
                color: #FFFFFF;
                font-size: 14px;
                cursor: pointer;
                font-family: "Courier New", Courier, monospace;
            }
            body {
                background: #76b852;
            }
            h1 {
                font-family: "Courier New", Courier, monospace;
            }
            input {
                width: 100%;
                padding: 12px 20px;
                margin: 4px 0;
                border: 1px solid #ccc;
                box-sizing: border-box;
            }
            select {
                width: 100%;
                padding: 12px 20px;
                margin: 4px 0;
                border: 1px solid #ccc;
                box-sizing: border-box;
            }
            input[type="password"], input[type="confirm_password"]
            {
                -webkit-text-security: disc;
            }
            p {
                font-family: "Courier New", Courier, monospace;
                text-align: left;
            }
            input[type="file"]
            {
                width: 80%;
                padding: 12px 20px;
                margin: 4px 0;
                border: 1px solid #ccc;
                box-sizing: border-box;
                display: none;
            }
            .prideti_nuotrauka {
                text-transform: uppercase;
                background: #FFFFFF;
                width: 100%;
                border: 0;
                padding: 5px;
                color: #4CAF50;
                font-size: 14px;
                cursor: pointer;
                font-family: "Courier New", Courier, monospace;
            }


        </style>
    </head>
    <body>
        <?php if ($session->registrationSuccessful()): ?>
            <h1>Registracija sėkminga</h1>
        <?php endif; ?>
        <?php if (!$session->isLoggedIn()): ?>

            <form class ="formu_centravimas" id="LoginForm" method="post" action="index.php">
                <h1>Login Here!</h1>
                <input type="text" placeholder="Email@email.com" name="email" autofocus /> <br>
                <input type="password" placeholder="Password" name="password"/> <br> <br>
                <button name="action" value="login">Login Now!</button>
                <button onclick="hideForm(); return false;">Don't have an account?</button>
            </form>
            <div id="hideRegister">
                <form class ="formu_centravimas" id="RegisterForm" method="post" action="index.php">
                    <h1>Register here!</h1>
                    <input type="text" placeholder="Email@email.com" name="email" autofocus /> <br>
                    <input type="password" placeholder="Password" name="password"/> <br>
                    <input type="confirm_password" placeholder="Confirm Password" name="confirm_password"/> <br>
                    <input type="text" placeholder="Full Name" name="full_name"/><br>
                    <input type="text" placeholder="Age" name="Age"/><br>
                    <select name="Gender"> <br>
                        <option value="male" name="Gender">Male</option>
                        <option value="female" name="Gender">Female</option>
                    </select>
                    <br> <br>

                    <input type="file" id="file" accept="image/*"/>
                    <label class="prideti_nuotrauka" for="file">Press here to select your profile picture</label><br> <br>

                    <button name="action" value="register">Register Now!</button><br>
                </form>
            <?php endif; ?>
        </div>
        <?php if ($session->isLoggedIn()): ?>
            <form id="LogoutForm" method="post" action="index.php">
                <h1>You are logged in!</h1>
                <button name="action" value="logout">Logout!</button>
            </form>
        <?php endif; ?>



        <!--JS for form hiding-->
        <script>
            function hideForm() {
                var x = document.getElementById("hideRegister");
                if (x.style.display === "block") {
                    x.style.display = "none";
                } else {
                    x.style.display = "none";
                }
            }
        </script>
    </body>
</html>