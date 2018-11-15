<?php
/**
 * Funkcija, kuri tiems patiems klausimas iš to pačio PC visada duotų tuos pačius atsakymus.
 * Atsakymai su klausimais yra dedami į masyva ir overwritinami.
 */

$klausimas = null;
$atsakymu_masyvas = ['Taip', 'Ne', 'Galbut'];

/**
 * Funkcija atsitiktinai isrenkanti viena atsakyma is masyvo.
 * 
 * @param type array $atsakymu_masyvas Masyvas su 3 atsakymais.
 * @return type array $atsakymu_masyvas Grazina viena atsakyma is masyvo nuradant jo indeksa
 */
function get_random_answer($atsakymu_masyvas) {
    $indexas = array_rand($atsakymu_masyvas, 1);
    return $atsakymu_masyvas[$indexas];
}

/**
 * Funkcija skirta patikrinti ar yra sukurtas cookie
 * ir grazinti jame esancia decodinta data
 * 
 * @param integer $cookie_name Cookie pavadinimas
 * @return array Data is Cookie (tuscias jei cookie negzistuoja)
 */
function cookie_read($cookie_name) {
    if (isset($_COOKIE[$cookie_name])) {
        // Returninam decodinta cookie verte
        return json_decode($_COOKIE[$cookie_name], true);
    }
    // Jei nera sukurtas toks cookie (neegzistuoja), grazinam tuscia masyva
    return [];
}

/**
 * Funkcija, kuri sukuria nauja cookie
 * 
 * @param array integer $cookie_name Cookie pavadinimas
 * @param array $data Kazkokia data
 */
function cookie_write($cookie_name, $data) {
    setcookie($cookie_name, json_encode($data), time() + 3600);
}

//Tikriname ar buvo kazkas ivykdyta (submit)
if (isset($_POST['klausimas'])) {
// Jei buvo, prilyginam kintamajam
    $klausimas = $_POST['klausimas'];

    // Tikriname ar i forma buvo irasytas klausimas
    if (strlen($klausimas) > 0) {
        // Jei buvo metam ji i history
        $answer_history = cookie_read('history');
        var_dump($answer_history);
        // Tikriname ar buvo setintas klausimas
        if (isset($answer_history[$klausimas])) {
            // Jei buvo, priskiriam ji senam atsakymui
            // (Atsakymui, kuris jau buvo sugeneruotas atsitiktinai ir priskirtas klausimui)
            $atsakymas = $answer_history[$klausimas];
        } else {
            // Iskvieciam get_random_answer funkcija, kuri sugeneruoja random atsakyma
            $atsakymas = get_random_answer($atsakymu_masyvas);
            // Klausima priskiriam atsakymui
            $answer_history[$klausimas] = $atsakymas;
            // Irasom nauja klausima su nauju atsakymu i cookie history
            cookie_write('history', $answer_history);
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <style>
        </style>
    </head>
    <body>
        <form action="index.php" method="POST">
            <b> Vardas: </b> <input name="klausimas" type="text"/>
            <input type="submit"/>
        </form>
        <?php if (isset($atsakymas)): ?>
            <h1> Jūsų klausimas: <?php print $klausimas ?></h1>
            <h2> Atsakymas: <?php print $atsakymas ?></h2>
        <?php endif; ?>
    </body>
</html>