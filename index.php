<?php
$months = 12;
$starting_money = 1000;
$alga = 700;
$likutis = $starting_money;
$visosislaidos = 0;
for ($i = 1; $i < $months; $i++) {

    $islaidos = rand(200, 350);
    $visosislaidos += $islaidos;
    $likutis += $alga - $islaidos;
    if ($likutis < 0) {
        break;
    }
}
$vidutinesislaidos = round($visosislaidos / $months);
$skaiciavimai = "Per $months Prognozuotų mėnesių, vidutinės išlaidos: " . $vidutinesislaidos . " Likutis pabaigoje $likutis";
?>
<html
    <head>
        <style>
            //Here we write the motherfucking style blyat
        </style>
    </head>
    <body>
        <p><?php print $skaiciavimai; ?></p>
    </body>
</html>