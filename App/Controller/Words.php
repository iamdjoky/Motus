<?php

declare(strict_types=1);

namespace App\Controller;

use App\Infra\Memory\MotsJson;

class Words implements Controller
{
    public function render(): void
    {
        // dommage que l'affichage ne soit pas géré en dehors du contrôleur.
        echo "Page d'accueil<br><br>";
        $words = new MotsJson();

        echo 'Motus';
        echo '
        <form method="POST">
                <label for="word">Votre mot :</label>
                <input type="text" name="word">
                <button type="submit">Confirmer</button>
            </form>
            ';
        $words->findWord();

        if (isset($_POST['word'])) {
            $words->findWord(); // mais ça tu le fais déjà ligne 25
            $words->TryWord($_POST['word']);
        }
    }
}
