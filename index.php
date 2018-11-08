<?php
date_default_timezone_set('Europe/Vilnius');

$distance = rand(500, 1000);
$fuel_100km = 7.5;
$fuel_price = 1.3;
$litrai = $distance / 13.33;
$kaina = $litrai * 1.3;
$litraisukaina = "Nuvažiavus " . $distance . "km" . " mašina sunaudos " . round($litrai) . " l. kuro" . " Kaina: " . round($kaina) . " " . " €";
?>
<html>
    <head>
        <style>

        </style>
        <title>

        </title>
    </head>
    <body>
        <p><?php print $litraisukaina; ?> </p>
    </body>
</html>