<?php
// includes
include 'inc/session.php';
include 'inc/Phrase.php';
include 'inc/Game.php';

// restarts game
if (isset($_POST['restart'])) {
    session_destroy();
    echo "<meta http-equiv='refresh' content='0'>";
}

// assign user submitted key to $letter
if (isset($_POST['submit'])) {
    $letter = $_POST['submit'];
} else {
    $letter = null;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Phrase Hunter</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/styles.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
</head>

<body>
    <div class="main-container">
        <div id="banner" class="section">
            <h2 class="header">Phrase Hunter</h2>
        </div>

        <div id="phrase" class="section noselect">
            <ul>
                <?php
                // instantiate Phrase object
                $phraser = new Phrase($_SESSION["currentPhrase"], $letter);

                // displays currentPhrase
                echo $phraser->addPhraseToDisplay();

                // instantiate Game object
                $gamer = new Game($phraser);
                ?>
            </ul>
        </div>

        <?php
        // form $_POST handling
        if (isset($_POST['submit'])) {

            if ($phraser->checkLetter($letter)) {
                $gamer->addCorrectGuess($letter);
            } else {
                $gamer->addIncorrectGuess($letter);
                $_SESSION['missesNum'] += 1;
            }

            // checks results
            $gamer->gameOver();
        }
        ?>

        <div id="qwerty" class="section">
            <form action="play.php" method="post">
                <?php
                // displays keyboard form
                echo $gamer->displayKeyboard();
                ?>
            </form>
        </div>

        <div id="scoreboard" class="section">
            <ol>
                <?php
                // displays remaining lives
                $gamer->displayScore();
                ?>
            </ol>
        </div>
    </div>

</body>

</html>