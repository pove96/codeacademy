<?php
date_default_timezone_set('Europe/Vilnius');

/**
 * Funkcija, kuri is masyvo suranda valanda, kuri yra artimiausia dabartinei valandai.
 * if () Tikriname ar skirtumas yra mazesnis uz 99, jei mazesnis spausdiname ta valanda is masyvo
 * @param type integer $find_closest_hour Dabartine valanda
 * @return integer $closest_hour_of_the_array Valanda is masyvo, kuri buvo artimiausia dabartinei valandai
 */
function find_closest_hour($hour_find) {
    //Masyvas su 3 betkokiomis valandomis
    $hour_array_source = [
        date("G", strtotime("+29 hours")),
        date("G", strtotime("-35 hours")),
        date("G", strtotime("+3 days"))
    ];

    $hour_min_diff_from_source = 99;
    //Artimiausia valanda - is pradziu undefined, nera lygi niekam
    $closest_hour = null;
    //Foreach ciklas, kuris pereina per visas valandas esancias masyve; $hour_source - valanda is masyvo
    foreach ($hour_array_source as $hour_source) {
        $hour_diff_from_source = abs($hour_find - $hour_source);

        if ($hour_diff_from_source < $hour_min_diff_from_source) {
            $closest_hour = $hour_source;
        }
    }

    return $closest_hour;
}

$closest_hour_of_the_array = find_closest_hour(date("G"));
?>
<html>
    <head>
        <style>
            /*The <style> tag is used to define 
            style information for an HTML document.*/
        </style>
    </head>
    <body>
        <h1><?php print $closest_hour_of_the_array; ?></h1>
    </body>
</html>