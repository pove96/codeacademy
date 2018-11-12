<?php
$fridge = ['Jogurtas', 'Alus',
    'bananas', 'apelsinas', 'kiaušai'];
$noriu = ['Kebabas', 'Alus', 'Pica'];
$tekstas = " ";

foreach ($noriu as $produktas) {
    $radau = in_array($produktas, $fridge);

    if ($radau) {
        $tekstas .= "<br> As turiu " . $produktas;
    } else {
        $tekstas .= "<br> Neturiu " . $produktas;
    }
}
?>
<html>
    <head>
        <style>

        </style>
    </head>
    <body>
        <h3>Ar viską turiu šaldytuve?</h3>
        <p><?php print $tekstas ?></p>
    </body>
</html>