<?php
require('tinder/classes/Database.php');
require('tinder/classes/Model.php');
require('tinder/classes/abstracts/AbstractUser.php');
require('tinder/classes/User.php');
require('tinder/classes/UserRepository.php');
require('tinder/classes/Session.php');
require('tinder/classes/Tinder.php');

$db = new Database('db.txt');
$repository = new UserRepository($db); // i repozitorija paduodi database
$session = new Session($repository); // o i database paduodi repozitorija

$action = $_POST['action'] ?? false; // Pracheckina ar vapse kazkoks actionas buvo atliktas
if ($action) {
    if ($action == 'register') {
        $error = false;
        $fields = ['post' => ['email', 'password', 'confirm_password', 'full_name'], 'files' => ['photo']];
        foreach ($fields['post'] as $field) {
            if (empty($_POST[$field])) {
                $error = "$field is empty!";
            }
        }
        if (empty($_FILES['photo'])) {
            $error = "Photo not uploaded!";
        } else {
            $photo = $_FILES['photo'];
        }

        // Code for photo uploading --------------------------------------------

        if (!$error) {
            if ($_POST['password'] == $_POST['confirm_password']) {
                $target_dir = 'photos';
                $target_fname = time() . $photo['name'];
                $target_path = $target_dir . '/' . $target_fname;

                if (in_array($photo['type'], ['image/jpeg', 'image/png'])) {
                    if ($photo['error'] === 0) {
                        if (move_uploaded_file($photo['tmp_name'], $target_path)) {
                            $data = [
                                'full_name' => $_POST['full_name'],
                                'age' => $_POST['Age'],
                                'gender' => $_POST['Gender'],
                                'photo' => $target_path
                            ];
                            $session->register($_POST['email'], $_POST['password'], $data);
                        } else {
                            $error = 'Check if your path folders are correct';
                        }
                    } else {
                        $error = 'Maybe a file is too big?';
                    }
                } else {
                    $error = 'Maybe a file is not a picture?';
                }
            } else {
                $error = "Slaptazodziai nesutampa";
            }
        }
    }
    // -------------------------------------------------------------------------

    if ($action == 'login') {
        if (!empty($_POST['email']) && !empty($_POST['password'])) {
            $session->login($_POST['email'], $_POST['password']);
        } else {
            $error = 'Please enter email and password';
        }
    }
    if ($action == 'logout') {
        $session->logout();
    }
}

// Tinder form actions starts here ---------------------------------------------
if ($session->isLoggedIn()) {
    $tinder = new Tinder($repository, $session);

    if (in_array($action, ['like', 'dislike'])) {
        if ($action == 'like') {
            $tinder->userLike();
        }
        $viewed_user = $tinder->userViewNext();
        $tinder->save();
    } else {
        $viewed_user = $tinder->userViewLast();
    }

    $matches = $tinder->getMatches();
}


// -----------------------------------------------------------------------------
?>
<!DOCTYPE html>
<html>
    <head>
        <style>
            .formu_centravimas {
                text-align: center;
            }

            .hidden {
                display: none;
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

            }
            .like-dislike-form-picture {
                width: 100%;
            }
            
            .grid-container {
                display: grid;
                grid-template-columns: repeat(13, 102.39px);
                grid-auto-flow: row;
                grid-template-columns: 100px 100px 100px 100px 100px 100px;
                padding: 40px; 
                grid-gap: 120px;
                margin: 40px;
            }
            
            .grid-container img {
                width: 200px;
            }


        </style>
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    </head>
    <body>
        <?php if ($session->registrationSuccessful()): ?>
            <h1>Registracija sėkminga</h1>
        <?php endif; ?>
        <?php if (!$session->isLoggedIn()): ?>

            <form class="formu_centravimas" id="LoginForm" method="post" action="index.php">
                <h1>Login Here!</h1>
                <input type="text" placeholder="Email@email.com" name="email" autofocus />
                <input type="password" placeholder="Password" name="password"/>
                <button name="action" value="login">Login Now!</button>
                <button id="show-register-form">Don't have an account?</button>
            </form>
            <form class="formu_centravimas hidden" id="RegisterForm" enctype="multipart/form-data" method="post" action="index.php">
                <h1>Register here!</h1>
                <input type="text" placeholder="Email@email.com" name="email" autofocus /> <br>
                <input type="password" placeholder="Password" name="password"/> <br>
                <input type="confirm_password" placeholder="Confirm Password" name="confirm_password"/> <br>
                <input type="full_name" placeholder="Full Name" name="full_name"/><br>
                <input type="age" placeholder="Age" name="Age"/><br>
                <select name="Gender"> <br>
                    <option value="male" name="Gender">Male</option>
                    <option value="female" name="Gender">Female</option>
                </select>
                <br> <br>

                Choose a file to upload: <input name="photo" type="file"/>
                <button name="action" value="register">Register Now!</button>
                <button id="show-login-form">Already have an account?</button>
            </form>
        <?php endif; ?>
        <?php if ($session->isLoggedIn()): ?>
            <form id="LogoutForm" method="post" action="index.php">
                <h1>You are logged in!</h1>
                <button name="action" value="logout">Logout!</button>
            </form>
        <?php endif; ?>
        <?php if (isset($error)): ?>
            <p> <?php print $error ?> </p>
        <?php endif; ?>

        <!-- TINDER FORMS -->
        <?php if ($session->isLoggedIn()): ?>
            <?php if ($viewed_user): ?>

                <form action="index.php" method="POST">
                    <img src="<?php print $viewed_user->getDataItem('photo') ?>" class="like-dislike-form-picture">

                    <br>
                    <?php print $viewed_user->getDataItem('full_name') . $viewed_user->getDataItem('age') ?>
                    <br>
                    <button name="action" value="like">Like</button>
                    <button name="action" value="dislike">Dislike</button>
                </form>
            <?php endif; ?>
            <?php if (!empty($matches)): ?>
                <h1>You are not single! </h1>
                <p>Your matches:</p>
                <div class="grid-container">
                    <?php foreach ($tinder->getMatches() as $user): ?>
                        <div class="match">
                            <img src="<?php print $user->getDataItem('photo') ?>"> <br>
                            <?php print $user->getEmail(); ?>
                        </div>
                    <?php endforeach; ?>      
                </div>
            <?php else: print 'No matches' ?>
            <?php endif; ?>
        <?php endif; ?>

        <!--JS for form hiding-->
        <script>
            $('#show-login-form, #show-register-form').on('click', function () {
                $('#RegisterForm, #LoginForm').toggleClass('hidden');
                return false;
            });
        </script>
    </body>
</html>