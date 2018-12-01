<?php
define('DEBUG', true);

require('functions/core.php');
require('classes/MysqlDatabase.php');
require('classes/SQLBuilder.php');
require('classes/abstracts/Model.php');
require('classes/User.php');
require('classes/UserRepository.php');
require('classes/Session.php');
require('classes/Tinder.php');
require('classes/models/ModelUsers.php');
require('classes/models/ModelTinderData.php');

$db = new MysqlDatabase('root', '123456', 'localhost', 'tinder');
$repository = new UserRepository($db); // i repozitorija paduodi database
$session = new Session($repository); // o i session paduodi repozitorija
// Sukuriam $page masyvą, kurį naudosime duomenų spausdinimui HTML'e
$page = [
    'form_errors' => [],
    'viewed_user' => null,
    'matches' => []
];

$action = $_POST['action'] ?? false; // Checks if any action was made
if ($action) {
    if ($action == 'register') {
        // Filter $_POST array fields to prevent any HTML injection
        // The array $inputs is safe to use after this
        $inputs = filter_input_array(INPUT_POST, [
            'email' => FILTER_SANITIZE_EMAIL,
            'password' => FILTER_DEFAULT,
            'confirm_password' => FILTER_DEFAULT,
            'full_name' => FILTER_SANITIZE_STRING,
            'age' => FILTER_SANITIZE_NUMBER_INT,
            'gender' => FILTER_SANITIZE_STRING
        ]);

        // Create an array of mandatory fields
        $mandatory_fields = [
            'email' => 'Email',
            'password' => 'Password',
            'confirm_password' => 'Confirm Password',
            'full_name' => 'Full Name',
            'age' => 'Age',
            'gender' => 'Gender'
        ];
        // Check if fields are not empty and create errors        
        foreach ($mandatory_fields as $field_index => $field_name) {
            if (empty($inputs[$field_index])) {
                $page['form_errors'][] = "$field_name is empty!";
            }
        }

        // Check if passwords match
        if ($inputs['password'] != $inputs['confirm_password']) {
            $page['form_errors'][] = 'Passwords do not match!';
        }

        // Check if photo was uploaded
        if (empty($_FILES['photo'] ?? false)) {
            $page['form_errors'][] = "Photo not uploaded!";
        }

        // If everything is okay, upload the photo & register
        if (empty($page['form_errors'])) {
            $uploaded_file_path = save_photo($_FILES['photo']);
            if ($uploaded_file_path) {
                // Register funkcija ima tris parametrus
                // email, password ir array'ju - data
                $session->register($inputs['email'], $inputs['password'], [
                    'full_name' => $inputs['full_name'],
                    'age' => $inputs['age'],
                    'gender' => $inputs['gender'],
                    'photo' => $uploaded_file_path,
                ]);
            } else {
                $page['form_errors'][] = 'Failed to upload the file!';
            }
        }
    }
    // -------------------------------------------------------------------------

    if ($action == 'login') {
        // Filter $_POST array fields to prevent any HTML injection
        // The array $inputs is safe to use after this
        $inputs = filter_input_array(INPUT_POST, [
            'email' => FILTER_SANITIZE_EMAIL,
            'password' => FILTER_DEFAULT,
        ]);
        // Create an array of mandatory fields
        $mandatory_fields = [
            'email' => 'Email',
            'password' => 'Password',
        ];
        // Check if fields are not empty and create errors        
        foreach ($mandatory_fields as $field_index => $field_name) {
            if (empty($inputs[$field_index])) {
                $page['form_errors'][] = "$field_name is empty!";
            }
        }

        // If everything is okay, login
        if (empty($page['form_errors'])) {
            $success = $session->login($inputs['email'], $inputs['password']);
            if (!$success) {
                $page['form_errors'][] = 'Login failed! Check your email/password!';
            }
        }
    }


    if ($action == 'logout') {
        $session->logout();
    }
}

// Tinder form actions starts here --------------------------------------------- 

if ($session->isLoggedIn()) {
    $tinder = new Tinder($db, $repository, $session);

    // Check for action in form
    if (in_array($action, ['like', 'dislike'])) {
        switch ($action) {
            case 'like':
                $tinder->userLike();
                break;
            case 'dislike':
                $tinder->userDislike();
                break;
        }



        // If either like or dislike was pressed, load next
        $page['viewed_user'] = $tinder->userViewNext();
    } else {
        // If there was no action   
        $page['viewed_user'] = $tinder->userViewLast();
    }

    // Load matches
    $page['matches'] = $tinder->getMatches();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="css/tindercss.css"/>
        <link rel="stylesheet" href="css/tindercss_ext.css"/>
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    </head>
    <body>
        <?php if ($session->isRegistrationSuccessful()): ?>
        <center><h1>Registracija sėkminga</h1></center>
    <?php endif; ?>

    <?php if (!empty($page['form_errors'])): ?>
        <!-- FORM ERRORS -->
        <div class="form-errors">
            <?php foreach ($page['form_errors'] as $error): ?>
                <span class="error"><?php print $error ?></span>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if (!$session->isLoggedIn()): ?>
        <!-- LOGIN FORM -->
        <form class="formu_centravimas" id="login-form" method="post" action="index.php">
            <h1>Login Here!</h1>
            <input type="text" placeholder="Email@email.com" name="email" autofocus />
            <input type="password" placeholder="Password" name="password"/>
            <button class="button submit" name="action" value="login">Login Now!</button>
            <button class="button redirect" id="show-register-form">Don't have an account?</button>
        </form>

        <!-- REGISTER FORM -->
        <form class="formu_centravimas hidden" id="register-form" enctype="multipart/form-data" method="post" action="index.php">
            <h1>Register here!</h1>
            <input name="email" type="text" placeholder="Email@email.com" autofocus /> <br>
            <input name="password" type="password" placeholder="Password"/> <br>
            <input name="confirm_password" type="password" placeholder="Confirm Password" /> <br>
            <input name="full_name" type="full_name" placeholder="Full Name"/><br>
            <input name="age" type="number" min="18" max="120" placeholder="Age" /><br>
            <select name="gender">
                <option value="m">Male</option>
                <option value="f">Female</option>
            </select>
            <label>Choose a file to upload:</label>
            <input name="photo" type="file"/>
            <button class="button submit" name="action" value="register">Register Now!</button>
            <button class="button redirect" id="show-login-form">Already have an account?</button>
        </form>
    <?php endif; ?>

    <?php if ($session->isLoggedIn()): ?>
        <!-- LOGOUT FORM -->
        <form id="logout-form" method="post" action="index.php">
            <h1>Welcome back, <?php print $session->getCurrentUser()->getFullName() ?>!</h1>
            <button class="button submit" name="action" value="logout">Logout!</button>
        </form>
    <?php endif; ?>

    <?php if ($session->isLoggedIn()): ?>
        <?php if ($page['viewed_user']): ?>
            <form action="index.php" method="POST">
                <div class="user-wrapper">
                    <span class="user-name"><?php print $page['viewed_user']->getFullName(); ?></span>
                    <span class="user-age"><?php print $page['viewed_user']->getAge(); ?></span>                                        
                    <img src="<?php print $page['viewed_user']->getPhoto() ?>" class="like-dislike-form-picture">
                    <button class="button tinder like" name="action" value="like">Like</button>
                    <button class="button tinder dislike" name="action" value="dislike">Dislike</button>
                </div>
            </form>
        <?php else: ?>
            <div class="box">
                We're out of people :(
            </div>
        <?php endif; ?>

        <?php if (!empty($page['matches'])): ?>
            <div class="matches-wrapper">
                <h3>You are no longer single! </h3>
                <h4>Your matches:</h4>
                <div class="grid-container">
                    <?php foreach ($page['matches'] as $user): ?>
                        <div class="match">
                            <img src="<?php print $user->getDataItem('photo') ?>">
                            <span class="match-name"><?php print $user->getFullName(); ?></span>
                            <span class="match-age"><?php print $user->getAge(); ?></span>
                        </div>
                    <?php endforeach; ?>      
                </div>
            </div>
        <?php else: ?>
            <h3>No matches so far. </h3>
        <?php endif; ?>
    <?php endif; ?>

    <!--JS for form hiding-->
    <script>
        $('#show-login-form, #show-register-form').on('click', function () {
            $('#register-form, #login-form').toggleClass('hidden');
            return false;
        });
    </script>
</body>
</html>