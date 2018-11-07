<?php
$sunny = rand(0, 1);

if ($sunny) {
    $class = "sauleta";
    $text = "Sauleta blet";
} else {
    $class = "debesuota";
    $text = "Debesuota blet nx";
}
?>
<style>
    .sauleta {
        background-image: url(https://cdn.iconscout.com/icon/free/png-256/sunny-176-781177.png);
    }
    .debesuota {
        background-image: url(https://image.flaticon.com/icons/svg/164/164806.svg);
    }
    .paveiksliukas {
        width: 100px;
        height: 100px;
        background-size: contain;
        background-repeat: no-repeat;
    }

</style>

<html>
    <head>
        <title>

        </title>
    </head>
    <body>
        <div class="paveiksliukas <?php print $class; ?>"></div>
        <p><?php print $text; ?></p>
    </body>
</html>