<?php
$fridge = ['Jogurtas', 'Alus',
    'bananas', 'apelsinas', 'kiaušai'];
$noriu = ['Kebabas', 'Alus', 'Pica'];
$tekstas = " ";

foreach ($fridge as $key => $reiksme) {
    if (in_array($reiksme, $noriu)) {
        unset($fridge[$key]);
    }
}
foreach ($fridge as $reiksme) {
    print $reiksme . "<br>";
}
?>
<html>
    <head>
        <style>

        </style>
    </head>
    <body>
        <h1>Šaldytuvo turinys po visko:</h1>
    </body>
</html>