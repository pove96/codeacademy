<?php
if (isset($_GET['page'])) {
    $page = $_GET['page'];

    if ($page == 'home') {
        $title = "Home Page";
        $h1 = "Sveiki atvyke!";
    } else if ($page == 'cv') {
        $title = "Mano CV";
        $h1 = "CV:";
    } else if ($page == 'showcase') {
        $title = "Mano paroda";
        $h1 = "Paroda: Skaiciuokle";
    }
}
//var_dump($_GET['page']);
?>
<!DOCTYPE html>
<html>
    <head>
        <style>
        </style>
    </head>
    <body>
        <title><?php print $title ?></title>
        <h1><?php print $h1 ?></h1>
    </body>
</html>