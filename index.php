<?php
date_default_timezone_set('Europe/Vilnius');

function datos($dabartine_valanda) {
    $min_skirtumas = 99;
    $datu_array = [
        date("G", strtotime("+29 hours")),
        date("G", strtotime("-35 hours")),
        date("G", strtotime("+3 days"))
    ];

    $isrinktoji_valanda_is_arr = null;
    foreach ($datu_array as $idx => $valanda) {

        $skirtumas = abs($valanda - $dabartine_valanda);
        if ($skirtumas < $min_skirtumas) {
            $isrinktoji_valanda_is_arr = $valanda;
            $min_skirtumas = $skirtumas;
        }
    }

    return $isrinktoji_valanda_is_arr;
}

$artimiausia_valanda_is_arr = datos(date("G"));
?>
<html>
    <head>
        <style>
            /*The <style> tag is used to define 
            style information for an HTML document.*/
        </style>
    </head>
    <body>
        <h1><?php print $artimiausia_valanda_is_arr; ?></h1>
    </body>
</html>