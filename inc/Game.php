<?php

/*
    Class: Game

    * __construct instance of Phrase Class.
    * Holds game logic // if user won, lost or still in the game.
    * Displays keyboard to the UI.
    * Display remaining lives (tries left)
*/

class Game
{
    /** Phrase class */
    public $phrase;

    /** lives at start of the game (5) */
    public $lives = 5;

    /** all correctly guesssec keys */
    public $correctGuesses = array();

    /** all incorrectly guesssec keys */
    public $incorrectGuesses = array();

    /** keyboard keys */
    public $keyboard = [
        ["q", "w", "e", "r", "t", "y", "u", "i", "o", "p"],
        ["a", "s", "d", "f", "g", "h", "j", "k", "l"],
        ["z", "x", "c", "v", "b", "n", "m"]
    ];


    /**
     * Creates an instance of of Phrase class.
     *
     * @param string $phrase Phrase class name.
     *
     * @return void
     */
    public function __construct(Phrase $phrase)
    {
        $this->phrase = $phrase;
    }


    /**
     * Adds correctly guessed key to correctGuesses.
     *
     * @param string $guess passed key.
     *
     * @return void
     */
    public function addCorrectGuess($guess)
    {
        $_SESSION["correctGuesses"][] = $guess;
        $this->correctGuesses = $_SESSION["correctGuesses"];
    }


    /**
     * Adds incorrectly guessed key to incorrectGuesses.
     *
     * @param string $guess passed key.
     *
     * @return void
     */
    public function addIncorrectGuess($guess)
    {
        $_SESSION["incorrectGuesses"][] = $guess;
        $this->incorrectGuesses = $_SESSION["incorrectGuesses"];
    }


    /**
     * Checks if if user guessed all the correct keys.
     *
     * @param void
     *
     * @return bool (true) = user won the game
     */
    public function checkForWin()
    {
        $phraseLetters = str_replace(" ", "", $this->phrase->currentPhrase);
        $phraseLetters = array_unique(str_split(strtolower($phraseLetters)));

        $results = array_diff($phraseLetters, $_SESSION["correctGuesses"]);

        if (empty($results)) {
            return true;
        }
    }


    /**
     * Checks if user is out of remaining lives.
     *
     * @param void
     *
     * @return bool (true) = user lost the game
     */
    public function checkForLose()
    {
        $currentLives = $this->lives - $_SESSION['missesNum'];

        if ($currentLives == 0) {
            return true;
        }
    }


    /**
     * Checks result from checkForWin() and checkForLose(), ends the game and displays proper message.
     *
     * @param void
     *
     * @return bool (false) to stay in the game
     */
    public function gameOver()
    {
        if ($this->checkForWin()) {
            echo '<h1 id="game-over-message">🎉 Congratulations on guessing: "' . $this->phrase->currentPhrase . '"</h1>';
            echo '<form action="" method="post">';
            echo '<input type="submit" class="btn__reset" name="restart" value="⟲ Play Again">';
            echo '</form>';
            exit;
        } elseif ($this->checkForLose()) {
            echo '<h1 id="game-over-message">🤕 The phrase was: "' . $this->phrase->currentPhrase . '". Better luck next time!</h1>';
            echo '<form action="" method="post">';
            echo '<input type="submit" class="btn__reset" name="restart" value="⟲ Try Again">';
            echo '</form>';
            exit;
        } else {
            return false;
        }
    }


    /**
     * Displays keyboard form/logic to the UI.
     *
     * @param void
     *
     * @return void
     */
    public function displayKeyboard()
    {
        $keyRow = array_keys($this->keyboard);
        for ($i = 0; $i < count($this->keyboard); $i++) {
            echo '<div class="keyrow">';

            foreach ($this->keyboard[$keyRow[$i]] as $value) {
                echo '<input type="submit" name="submit" class="key ';

                if (in_array($value, $_SESSION["correctGuesses"])) {
                    echo "correct";
                }

                if (in_array($value, $_SESSION["incorrectGuesses"])) {
                    echo "incorrect";
                }

                echo '" value="' . $value . '"';
                if (in_array($value, $this->phrase->selectedKeys)) {

                    echo " disabled";
                }
                echo '>';
            }
            echo '</div>';
        }
    }


    /**
     * Displays remaining lives to the UI.
     *
     * @param void
     *
     * @return void
     */
    public function displayScore()
    {
        $currentLives = $this->lives - $_SESSION['missesNum'];

        for ($i = 0; $i < $_SESSION['missesNum']; $i++) {
            echo '<li class="tries"><img src="images/lostHeart.png" height="35px" widght="30px"></li>';
        }

        for ($i = 0; $i < $currentLives; $i++) {
            echo '<li class="tries"><img src="images/liveHeart.png" height="35px" widght="30px"></li>';
        }
    }
}
