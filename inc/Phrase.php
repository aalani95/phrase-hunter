<?php

/*
    Class: Phrase

    * __construct Generates a new phrase from $allPhrases randomly.
    * Displays the phrase to the UI.
    * Has all the keys a user submitted.
    * Checks if submitted keys are correct or incorrect
*/

class Phrase
{
    /** holds randomly chosen phrase */
    public $currentPhrase;

    /** contains phrases */
    private $allPhrases = [
        "On the Ropes",
        "Two Down One to Go",
        "Love Birds",
        "Dropping Like Flies",
        "Easy As Pie",
        "Right Off the Bat",
        "On the Same Page",
        "Cut The Mustard",
        "An Arm and a Leg",
        "Heads Up",
        "Back to Square One",
        "Quality Time",
        "Right Out of the Gate",
    ];

    /** all keys user submiited in their session */
    public $selectedKeys = [];


    /**
     * Sets currentPhrase to the session.
     *
     * @param string $phrase picks and maintain currentPhrase.
     * @param array $selected user submitted key.
     *
     * @return void
     */
    public function __construct($phrase = null, $selected = null)
    {

        if (empty($phrase)) {
            $this->currentPhrase = $this->allPhrases[array_rand($this->allPhrases, 1)];
            $_SESSION['currentPhrase'] = $this->currentPhrase;
        } else {
            $this->currentPhrase = $_SESSION['currentPhrase'];
        }

        if (isset($selected)) {
            $_SESSION['selectedKeys'][] = $selected;
            $this->selectedKeys = $_SESSION['selectedKeys'];
        }
    }


    /**
     * Displays currentPhrase to UI.
     *
     * @param void 
     *
     * @return void
     */
    public function addPhraseToDisplay()
    {
        $phraseLetters = str_split($this->currentPhrase);

        foreach ($phraseLetters as $letter) {
            if (ctype_space($letter)) {
                $class = "space";
            } else {
                $class = "letter";
            }

            if (in_array(strtolower($letter), $this->selectedKeys)) {
                $state = "show";
            } else {
                $state = "hide";
            }
            echo '<li class="' . $state . ' ' . $class . ' ' . $letter . '">' . $letter . '</li>';
        }
    }


    /**
     * Evaluate if submitted key exist in the curretnPhrase.
     *
     * @param string $letter user submitted key 
     *
     * @return bool
     */
    public function checkLetter($letter)
    {
        if (false !== strpos(strtolower($this->currentPhrase), $letter)) {
            return true;
        } else {
            return false;
        }
    }
}
