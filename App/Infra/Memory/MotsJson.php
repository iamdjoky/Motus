<?php

declare(strict_types=1);

namespace App\Infra\Memory;

class MotsJson
{
    private string $currentWord = '';
    private array $words = [];

    private function loadFile()
    {
        if (empty($this->words)) {
            $this->words = json_decode(file_get_contents(__DIR__.'/../../../var/db.json'), true);
        }

        return $this->words;
    }

    public function findWord()
    {
        // autant faire ces 2 actions uniquement dans le IF pour éviter un chargement inutile.
        $this->loadFile();
        shuffle($this->words);

        if (!\array_key_exists('currentWord', $_COOKIE) || '' === $_COOKIE['currentWord']) {
            $this->currentWord = $this->words[0]['mot'];
            setcookie('currentWord', $this->currentWord);
            setcookie('nombreTentative', '0');
        }

        return $this->currentWord;
    }

    public function TryWord(string $word): void
    {
        $nombreTentative = $_COOKIE['nombreTentative'] + 1;
        setcookie('nombreTentative', "$nombreTentative");

        $currentWord = $_COOKIE['currentWord'];

        $strLen = \strlen($currentWord);
        echo "Le mot contient : $strLen  caractères <br><br>";

        if ($nombreTentative > 6) {
            setcookie('nombreTentative', '0');
            setcookie('currentWord', '');

            echo '<h3 style="color: red">Perdu !</h3>
                <a href="/"> Rejouer </a> <hr>
            ';
            echo "La solution était $currentWord ";
            exit;
        }

        if (\strlen($word) === \strlen($_COOKIE['currentWord'])) {
            echo "Tentative n° $nombreTentative ";
            $tabWord = str_split($word);
            $tabCurrentWord = str_split($currentWord);

            foreach ($tabCurrentWord as $keyCurrentWord => $value) {
                if ($value === $tabWord[$keyCurrentWord]) {
                    echo "<span style='color: green'>$tabWord[$keyCurrentWord]</span>";
                    continue;
                }

                if (\in_array($tabWord[$keyCurrentWord], $tabCurrentWord, true)) {
                    echo "<span style='color:yellow'>$tabWord[$keyCurrentWord]</span>";
                } else {
                    echo "<span style='color:red'>$tabWord[$keyCurrentWord]</span>";
                }
            }
        } else {
            echo "<h2 style='color: red'>Vous n'avez pas entré le bon nombre de caractères</h2>";
        }
    }

    public function Replay(): void
    {
    }

    public function reloadGame(): void
    {
        // ça c'est pas bon, pour supprimer un cookie il faut envoie un cookie avec un timestamp de fin de vie dans le passé
        unset($_COOKIE['currentWord']);
        unset($_COOKIE['nombreTentative']);
        header('location : /');
    }
}
