<?php
$klausimas = null;
$atsakymu_masyvas = ['Taip', 'Ne', 'Galbut'];
if (isset($_POST['klausimas'])) {

    $klausimas = $_POST['klausimas'];
    //print "Jusu klausimas: " . $klausimas;
    if (strlen($klausimas) > 0) {
        $atsakymas = atsakymu_masyvas($atsakymu_masyvas);
    }
}

function atsakymu_masyvas($atsakymu_masyvas) {
    $indexas = array_rand($atsakymu_masyvas, 1);
    return $atsakymu_masyvas[$indexas];
}

//Taste some cookies biiiiiiiiiiiitch
setcookie('klausimas', serialize($klausimas), time() + 3600);
$data = unserialize($_COOKIE['klausimas']);
?>
<!DOCTYPE html>
<html>
    <head>
        <style>
        </style>
    </head>
    <body>
        <form action="index.php" method="POST">
            Vardas: <input name="klausimas" type="text"/>
            <input type="submit"/>
        </form>
<?php if (isset($atsakymas)): ?>
            <h1> Jūsų klausimas: <?php print $klausimas ?></h1>
            <h2> Atsakymas: <?php print $atsakymas ?></h2>
<?php endif; ?>
    </body>
</html>