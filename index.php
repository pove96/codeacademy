<?php
$catalog = [
    'kiausiniai' => [
        'pavadinimas' => "kiausiniai",
        'kaina' => 3.5,
        'aprasymas' => "ziauriai geri kiausiniai",
        'nuolaida' => "15%",
    ],
    'pica' => [
        'pavadinimas' => "pica",
        'kaina' => 7,
        'aprasymas' => "ziauriai gera pica",
    ],
    'sunio kebabai' => [
        'pavadinimas' => "sunio kebabai",
        'kaina' => 3,
        'aprasymas' => "geriau nevalgyk blet",
        'nuolaida' => "50%"
    ]
];
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
        <?php foreach ($catalog as $key => $produktas): ?>
            <div class="produktas"><?php print $produktas['pavadinimas'] ?></div>
            <span class="pavadinimas"><?php print $produktas['pavadinimas'] ?></span>
            <span class="kaina"><?php print $produktas['kaina'] ?></span>
            <span class="aprasymas"><?php print $produktas['aprasymas'] ?></span>
            <?php if (isset($produktas['nuolaida'])): ?>
                <span class="nuolaida"><?php print $produktas['nuolaida'] ?> </span>
            <?php endif; ?>
        <?php endforeach; ?>
    </body>
</html>