<?php
$drinks = [
    'Vodka' => [
        'pavadinimas' => 'Vodka',
        'turis_litrais' => 0.7,
        'prom' => 40
    ],
    'Alus' => [
        'pavadinimas' => 'Alus',
        'turis_litrais' => 0.5,
        'prom' => 4.5
    ]
];

/**
 * Funkcija, kuri skaičiuoja, kiek butelių galima išgerti, kol gryno
 * alkoholio kiekis neviršys tam tikro kiekio litrais.
 * 
 * @param array $drinks Gėrimų masyvas su pavadinimais, tūriu bei promilėmis.<br>
 * $arr[0]<br>
 *      ['pavadinimas'] = 'Vodke';<br>
 *      ['prom'] = 40;<br>
 * 
 * @param real $max_level Maksimalus alokoholio kiekis, kiek gali išgerti.
 * @return array $drinks Gražiname $drinks masyvą.
 */
function drinks($drinks, $max_level) {
    //Ciklas, kuris pereina per visas gėrimų rūšis
    foreach ($drinks as $idx => $drink_info) {
        //Paskaičiuojame alkoholio kiekį
        $alcohol_quantity = $drink_info['turis_litrais'] * $drink_info['prom'] / 100;
        //Surandame kiek butelių galima išgerti
        $bonkiu_skaicius = $max_level / $alcohol_quantity;
        //Prie esamo masyvo pridedame naują bonkių skaičiaus informaciją
        $drink_info['Bonkiu_skaicius'] = floor($bonkiu_skaicius);
        $drinks[$idx] = $drink_info;
    }
    return $drinks;
}

var_dump(drinks($drinks, 0.4));
?>
<!DOCTYPE html>
<html>
    <head>
        <style>
        </style>
    </head>
    <body>
        <h1> </h1>
    </body>
</html>