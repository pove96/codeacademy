<?php

class Girl {

    private $vardas;
    private $amzius;
    private $email;
    private $nuotrauka;

    public function __construct($vardas, $amzius, $email, $nuotrauka) {
        $this->vardas = $vardas;
        $this->amzius = $amzius;
        $this->email = $email;
        $this->nuotrauka = $nuotrauka;
    }

    public function tryMatch() {
        return rand(0, 1);
    }

    public function getName() {
        return $this->vardas;
    }

    public function setName($vardas) {
        $this->vardas = $vardas;
    }

    public function getAge() {
        return $this->amzius;
    }

    public function setAge($amzius) {
        $this->amzius = $amzius;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getPhoto() {
        return $this->nuotrauka;
    }

    public function setPhoto($nuotrauka) {
        $this->nuotrauka = $nuotrauka;
    }

    public function getAll() {
        return [
            'name' => $this->vardas,
            'amzius' => $this->amzius,
            'email' => $this->email,
            'nuotrauka' => $this->nuotrauka
        ];
    }

}

class SexyGirl extends Girl {

    function tryMatch() {
        $sexy = rand(0, 3);
        if ($sexy > 2) {
            return true;
        }
        //tikimybe turi but mazesne
    }

}

class UglyGirl extends Girl {

    function tryMatch() {
        $ugly = rand(0, 100);
        if ($ugly < 75) {
            return true;
        } else {
            return false;
        }
        // tikimybe turi but didesne
    }

}

//-----------Class Girl Ends Here-----------Class Girl Ends Here-----------Class Girl Ends Here-----------Class Girl Ends Here-----------Class Girl Ends Here-----------Class Girl Ends Here-----------
class Tinder {

    const COOKIE_NAME = 'tinder';

    private $girls;
    private $viewed;
    private $matches;
    private $dismatches; //nereikia sito sudo

    public function __construct() {
        $this->girls = [];
        $this->viewed = [];
        $this->matches = [];
        $this->dismatches = []; //nereikia sito sudo
    }

    //Adds new girl to the array
    public function girlAdd(Girl $girl) {
        $this->girls[] = $girl;
    }

    //View last girl you have seen (if no botton pressed return same girl)
    /**
     * 
     * @return Girl
     */
    public function girlViewLast() {
        if (empty($this->viewed)) {
            return $this->girlViewNext();
        } else {
            return end($this->viewed);
        }
    }

    //View next girl
    public function girlViewNext() {
        foreach ($this->girls as $girl) {
            if (!in_array($girl, $this->viewed)) {
                $this->viewed[] = $girl;
                return $girl;
            }
        }
    }

    public function girlLike() {
        $girl = $this->girlViewLast();
        if ($girl->tryMatch()) {
            $this->matches[] = $girl;
        }
    }

    public function getMatches() {
        return $this->matches;
    }

    //Load the data from cookies
    public function dataLoad() {
        $data = $_COOKIE[self::COOKIE_NAME] ?? false;

        if ($data) {
            $data = unserialize($data);
            $this->viewed = $data['viewed'] ?? [];
            $this->matches = $data['matches'] ?? [];
        }
    }

//Save data to cookies
    public function dataSave() {
        $data = [
            'viewed' => $this->viewed,
            'matches' => $this->matches
                //...
        ];
        setcookie(self::COOKIE_NAME, serialize($data), time() + (9987 * 40), '/');
    }

    public function dataClear() {
        setcookie(self::COOKIE_NAME, '', time() - 3600, '/');
    }

}

$tinder = new Tinder();
$tinder->girlAdd(new SexyGirl('Kristina', '21', 'ciolka69duodupyst@gmail.com', 'https://thephotostudio.com.au/wp-content/uploads/2017/10/Emily-Ratajkowski-1.jpg'));
$tinder->girlAdd(new UglyGirl('Karolina', '22', 'Karolina@gmail.com', 'https://www.piedfeed.com/wp-content/uploads/2017/07/hannah-davis-sports-illustrated-2014-swimsuit-issue-part-2-_25.jpg'));
$tinder->girlAdd(new UglyGirl('Sandra', '23', 'sirdyjauna@inbox.lt', 'http://cdn.shopify.com/s/files/1/2999/4578/products/HTB12Tkvd8TH8KJjy0Fiq6ARsXXaQ_1024x1024.jpg?v=1524823949'));
$tinder->dataLoad();

//Form actions starts herei
$action = $_POST['action'] ?? false;
if ($action) {
    if (in_array($action, ['like', 'dislike'])) {
        if ($action == 'like') {
            $tinder->girlLike();
        }
        $viewed_girl = $tinder->girlViewNext();
        $tinder->dataSave();
    }
} else {
    $viewed_girl = $tinder->girlViewLast();
}

if (!$viewed_girl) {
    $tinder->dataClear();
}
?>

<html>
    <head>

    </head>
    <style>
        .bobos {
            background-size: cover;
            height: 300px;
            width: 300px;
        }
    </style>

    <body>
        <?php if ($viewed_girl): ?>

            <form action="index.php" method="POST">
                <img src="<?php print $viewed_girl->getPhoto() ?>" class="bobos">
                <br>
                <?php print $viewed_girl->getName() . $viewed_girl->getAge() ?>
                <br>
                <button name="action" value="like">Like</button>
                <button name="action" value="dislike">Dislike</button>
            </form>
        <?php else: ?>
            <h1>You are single.</h1>
        <?php endif; ?>
        <h1>Matches:</h1>
        <?php foreach ($tinder->getMatches() as $girl): ?>
            <div class="match">
                <img src="<?php print $girl->getPhoto() ?>" class="bobos"> <br>
                <?php print $girl->getName(); ?>
            </div>
        <?php endforeach; ?>
    </body>
</html>