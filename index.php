<?php
date_default_timezone_set('Europe/Vilnius');


$distance = rand(500, 1000);
$fuel_100km = 7.5;
$fuel_price = 1.3;
$litrai = $distance / 13.33;
$kaina = $litrai * 1.3;
$litraisukaina = "Nuvažiavus " . $distance . "km" . " mašina sunaudos " . round($litrai) . " l. kuro" . " Kaina: " . round($kaina) . " " . " €";
$my_money = rand(50, 60);
$bako_talpa = 50;
$kiek = $my_money / $fuel_price * 13.33;
$info = "Mano turimi pinigai: " . $my_money . "€ Noriu nuvažiuoti " . $distance . " kilometrų";

if ($my_money >= $kaina) {
    $isvada = "Aš galiu sau tai leisti";
} else {
    $isvada = "Aš negaliu sau to leisti";
}
if ($litrai > $bako_talpa) {
    $pakartotinaskuras = "Reikės";
} else {
    $pakartotinaskuras = "Nereikes";
}
if ($litrai > $bako_talpa) {
    $kartai = $litrai / $bako_talpa . "kartu";
} else {
    $kartai = " ";
}
?>
<html>
    <head>
        <style>

        </style>
        <title>

        </title>
    </head>
    <body>
        <p><?php print $info ?></p>
        <p><?php print $litraisukaina; ?> </p>
        <p><?php print $isvada; ?> </p>
        <p><?php print "Kuro pakartotinai pilti " . $pakartotinaskuras; ?></p>
        <p><?php print ceil($kartai); ?></p>
        <p><?php print "Tolimiausia kelionė su turimais pinigais " . round($kiek) . " km"; ?></p>
    </body>
</html>