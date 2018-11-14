<?php
$cars_array = [
    'Fiat Multipla' => [
        'pavadinimas' => 'Fiat Multipla',
        'kaina' => '420'
    ],
    'Audi 80' => [
        'pavadinimas' => 'Audi 80',
        'kaina' => '169'
    ]
];

/**
 * Funkcija, kuri priima automobilių masyvą ir priklausomai nuo pardavimų kainos,
 * kuri yra atsitiktinai suskaičiuota, grąžina papildomus elementus masyve, už
 * kiek ta mašina buvo parduota ir ar apsimokėjo.
 * 
 * @return integer $cars_array Gražinam cars_array masyvą
 */
function sell_cars($cars_array) {
    //Ciklas, kuris pereina per visus automobilius ir jų informaciją
    foreach ($cars_array as $idx => $car_info) {
        //Paskaiciuojam ar pardavimo kaina +30% ar -30%
        $sell_price_min = $car_info['kaina'] * 0.7;
        $sell_price_max = $car_info['kaina'] * 1.3;
        //Kiekvieną kartą vykdomas ciklas sugeneruoja atsitiktinę kainą [+-30%]
        $car_info['pard_kaina'] = rand($sell_price_min, $sell_price_max);
        //Tikriname ar pardavimo kaina yra daugiau už pradinę automobilio kainą
        if ($car_info['pard_kaina'] > $car_info['kaina']) {
            $car_info['varke'] = " Taip, apsimokėjo";
        } else {
            $car_info['varke'] = " Ne, neapsimokėjo";
        }
        //Į tą patį masyvą įtraukiame naują automobilio pardavimo kainą
        $cars_array[$idx] = $car_info;
    }
    return $cars_array;
}

$cars_array = sell_cars($cars_array);
var_dump($cars_array);
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