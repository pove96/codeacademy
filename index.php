<?php
$daiktu_pavadinimai = ['Kremas', 'Lakas', 'Pinigine'];
$daiktuskaicius = rand(0, 5);
$tase = [];
for ($i = 0; $i < $daiktuskaicius; $i++) {
    $size = rand(10, 60);
    $spalva = rand(0, 1);
    $rand_pavad_idx = rand(0, count($daiktu_pavadinimai) - 1);
    $rand_pavad = $daiktu_pavadinimai[$rand_pavad_idx];

    $tase[] = [
        'Pavadinimas' => $rand_pavad,
        'Dydis' => $size,
        'Spalva' => $spalva
    ];
}
?>
<html>
    <head>
        <style>
            div {
                width: 100px;
                height: 100px;
                background-size: cover;
            }

        </style>
    </head>
    <body>
        <?php foreach ($tase as $key => $produktas): ?>
            <p><?php print $produktas['Pavadinimas'] . " uzima: " . $produktas['Dydis'] . " cm3 <br> Daikto spalva: " . ($produktas['Spalva'] ? 'sviesi' : 'tamsi'); ?></p>
        <?php endforeach; ?>
    </body>
</html>