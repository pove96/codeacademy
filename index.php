<?php
$fridge = ['Jogurtas', 'Alus',
    'bananas', 'apelsinas', 'kiaušai'];
$bbd = 'Šaldytuvo turinys: ';
$indexas = rand(0, count($fridge) - 1);
$produktas = $fridge[$indexas];
foreach ($fridge as $value) {
    $bbd .= $value . "<br>";
}
?>
<html>
    <head>
        <style>

        </style>
    </head>
    <body>
        <h1><?php print $bbd ?> </h1>
        <h2>Šiandien turbūt valgysiu: </h2>
        <p><?php print $produktas ?> </p>
    </body>
</html>