<?php
// starts a game session
session_start();

// currentPhrase session var
if (!isset($_SESSION["currentPhrase"])) {
    $_SESSION["currentPhrase"] = "";
}

// selectedKeys session array
if (!isset($_SESSION['selectedKeys'])) {
    $_SESSION['selectedKeys'] = [];
}

// correctGuesses session array
if (!isset($_SESSION['correctGuesses'])) {
    $_SESSION['correctGuesses'] = [];
}

// incorrectGuesses session array
if (!isset($_SESSION['incorrectGuesses'])) {
    $_SESSION['incorrectGuesses'] = [];
}

// missesNum session var (counter)
if (!isset($_SESSION['missesNum'])) {
    $_SESSION['missesNum'] = 0;
}
