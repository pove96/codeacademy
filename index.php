<?php
date_default_timezone_set('Europe/Vilnius');

$kiek_isgerei = rand(1, 8);
$barnio_riba = rand(1, 4);
$bokalai = $kiek_isgerei - $barnio_riba;
if ($kiek_isgerei > $barnio_riba) {
    $bokalai = "Žmona barsis, nes išgėrei " . $bokalai . " bokalais per daug.";
} else {
    $bokalai = "Žmona nesibars. Šiandien galėjai išgerti dar " . abs($bokalai) . " bokalus";
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
        <h1><?php print $bokalai ?></h1>
    </body>
</html>