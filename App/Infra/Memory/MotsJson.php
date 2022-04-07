<?php

declare(strict_types=1);

namespace App\Infra\Memory;


class MotsJson
{
    private string $currentWord = "";
    private array $words = [];

    private function loadFile()
    {
        if (empty($this->words)) {
            $this->words = json_decode(file_get_contents(__DIR__ . '/../../../var/db.json'), true);
        }
        return $this->words;
    }

    public function findWord()
    {
        $this->loadFile();
        shuffle($this->words);
        if(!array_key_exists("currentWord",$_COOKIE)) {
            $this->currentWord = $this->words[0]['mot'];
            setcookie("currentWord", $this->currentWord);
            setcookie("nombreTentative", "0");
        }
        
        $strLen = strlen($_COOKIE['currentWord']);
        echo "Le mot contient : $strLen  caractères <br><br>";
        return $this->currentWord;

    }
    public function TryWord($word){
        $nombreTentative = $_COOKIE['nombreTentative'] + 1;
        setcookie("nombreTentative", "$nombreTentative");
        $currentWord = $_COOKIE['currentWord'];
        if($nombreTentative <= 6) {
            if (strlen($word) === strlen($_COOKIE['currentWord'])) {
                echo "Tentative n° $nombreTentative ";
                $tabWord = str_split($word);
                $tabCurrentWord = str_split($currentWord);
                foreach ($tabCurrentWord as $keyCurrentWord => $value) {
                    if ($value === $tabWord[$keyCurrentWord]) echo "<span style='color: green'>$tabWord[$keyCurrentWord]</span>";
                    if ($value != $tabWord[$keyCurrentWord]) {
                        if (in_array($tabWord[$keyCurrentWord], $tabCurrentWord)) echo "<span style='color:yellow'>$tabWord[$keyCurrentWord]</span>";
                        else {
                            echo "<span style='color:red'>$tabWord[$keyCurrentWord]</span>";
                        }
                    }
                }
            } else {
                echo "<h2 style='color: red'>Vous n'avez pas entré le bon nombre de caractères</h2>";
            }
        }
        else{
            echo "<h3 style='color: red'>Perdu !</h3>
                <button onclick='replay'>Rejouer</button>
            ";
            echo "La solution était $currentWord " ; 
        }
    }

    public function Replay() {
        
    }

    public function reloadGame(){
        unset($_COOKIE['currentWord']);
        unset($_COOKIE['nombreTentative']);
        header('location : /');
    }
    
}